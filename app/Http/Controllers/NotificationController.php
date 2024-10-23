<?php

namespace App\Http\Controllers;

use App\Services\TwilioService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Correct
use App\Models\Publicite; // Modèle pour la table publicité
use Illuminate\Validation\ValidationException; // Assurez-vous d'importer cette classe si nécessaire
use App\Mail\TestEmail; 
use App\Models\Emails;

class NotificationController extends Controller
{
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    // Méthode pour envoyer une notification par SMS
    public function sendSmsNotification(Request $request)
    {
        $to = '+237695328943'; // Numéro du destinataire avec l'indicatif du pays
        $message = 'Bonjour ! Ceci est un test de notification via Twilio by Emmens Dev.';
        
        try {
            $this->twilio->sendSms($to, $message);
            return response()->json(['status' => 'Message envoyé avec succès !']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'Erreur lors de l\'envoi du message : ' . $e->getMessage()], 500);
        }
    }

    // Méthode pour envoyer une notification par email via Elastic Email
  


public function sendEmailNotification(Request $request)
{
    // Valider les données
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|image', // La variable body est une image
        'contain' => 'required|string',
        'locations' => 'required|string', // Zone choisie par l'utilisateur
    ]);

    // Récupérer le fichier image
    $imgFile = $request->file('body');
    // Déplacez l'image dans le dossier public/images
    // $imagePath = $imgFile->store('images', 'public'); // Stocke l'image dans le dossier public/images
    // $imageUrl = asset('storage/' . $imagePath); // Obtenir l'URL de l'image

    // Enregistrer les données dans la table publicité
    $publicite = Publicite::create([
        'title' => $validatedData['title'],
        'body' => $imgFile, // Utilisez l'URL de l'image
        'contain' => $validatedData['contain'],
        'locations' => $validatedData['locations'],
    ]);

    // Structure des données de l'email
    $data = [
        'title' => $validatedData['title'],
        'body' => $imgFile, // Utilisez l'URL de l'image
        'contain' => $validatedData['contain'],
    ];

    // Récupérer les emails correspondant à la zone
    $emails = Emails::where('locations', $validatedData['locations'])->pluck('mails');

    // Envoyer l'email à chaque adresse dans la zone
    foreach ($emails as $email) {
        Mail::to($email)->send(new TestEmail($data));
    }

    return response()->json(['message' => 'Notification envoyée avec succès à tous les contacts de la zone sélectionnée et données sauvegardées dans la publicité !'], 200);
}
    
    // Récupération des données envoyées dans la requête JSON
//   $data = [  
//     'title' => 'TEST AVEC GMAI',
//     'body' => 'ceci est une notification pour le hackathon blablabla by EMMENS-DEV',
//     'contain' => 'ceci est une notification pour le hackathon blablabla by EMMENS-DEV'
    
//   ];
//      Mail::to('menwamenwaemmanuel@gmail.com')->send(new  TestEmail($data));

}
