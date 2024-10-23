<?php

namespace App\Http\Controllers;
use App\Models\Boutiques;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BoutiqueController extends Controller
{
    public function createshop(Request $request)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'imgshop' => 'required|image', // Validation pour s'assurer que c'est une image
                'nameshop' => 'required',
                'addresshop' => 'required',
                'phoneshop' => 'required'
            ], [
                'imgshop.required' => 'Ajoutez une image.',
                'nameshop.required' => 'Le nom de la boutique est nécessaire.',
                'addresshop.required' => 'L\'adresse est requise.',
                'phoneshop.required' => 'Le numéro est requis',
            ]);
    
            // Encodage de l'image en base64
            $imgFile = $request->file('imgshop');
            // $imgBase64 = base64_encode(file_get_contents($imgFile->getRealPath()));
    
            // Création de la boutique
            $boutique = Boutiques::create([
                'imgshop' => $imgFile,
                'nameshop' => $request->nameshop,
                'addresshop' => $request->addresshop,
                'phoneshop' => $request->phoneshop,
                'user_id' => Auth::id(),
            ]);
    
            return response()->json([
                'message' => 'Boutique créée avec succès',
                'boutique' => $boutique,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur lors de la création de la boutique',
                'errors' => $e->errors(),
            ], 422);
        }
    }
    

    //afficher boutique

    public function afficherBoutique()
{
    // Récupère la boutique associée à l'utilisateur connecté
    $boutique = Boutiques::where('user_id', Auth::id())->first();

    if (!$boutique) {
        return response()->json([
            'message' => 'Aucune boutique trouvée pour cet utilisateur.'
        ], 404);
    }

    return response()->json([
        'boutique' => $boutique
    ]);
}



  // ajouter un produit dans une boutique
  public function createProduct(Request $request)
      {
          try {
              // Validation des données
              $validator = Validator::make($request->all(), [
                  'productimg' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                  'productname' => 'required|string|max:255',
                  'productdescript' => 'nullable|string',
                  'productprice' => 'required|numeric',
                  'productqte' => 'required|integer',
                  'productcat' => 'nullable|string',
                  'boutique_id' => 'required|exists:boutiques,id'
              ], [
                  'productimg.required' => 'L\'image du produit est obligatoire.',
                  'productimg.image' => 'Le fichier doit être une image.',
                  'productimg.mimes' => 'L\'image doit être de type jpeg, png, jpg, gif.',
                  'productname.required' => 'Le nom du produit est obligatoire.',
                  'productprice.required' => 'Le prix du produit est obligatoire.',
                  'productqte.required' => 'La quantité du produit est obligatoire.',
                  'boutique_id.required' => 'La boutique est requise.'
              ]);
  
              // Si la validation échoue
              if ($validator->fails()) {
                  return response()->json([
                      'message' => 'Erreur de validation des données.',
                      'errors' => $validator->errors()
                  ], 422);
              }
  
              // Encodage de l'image en base64
              $productImgBase64 = $request->file('productimg');
  
              // Création du produit
              $produit = Produit::create([
                  'productimg' => $productImgBase64,
                  'productname' => $request->productname,
                  'productdescript' => $request->productdescript,
                  'productprice' => $request->productprice,
                  'productqte' => $request->productqte,
                  'productcat' => $request->productcat,
                  'user_id' => Auth::id(),
                  'boutique_id' => $request->boutique_id
              ]);
  
              return response()->json([
                  'message' => 'Produit créé avec succès.',
                  'produit' => $produit
              ], 201);
  
          } catch (ValidationException $e) {
              return response()->json([
                  'message' => 'Erreur lors de la création du produit.',
                  'errors' => $e->errors()
              ], 422);
          } catch (\Exception $e) {
              return response()->json([
                  'message' => 'Une erreur est survenue lors de la création du produit.',
                  'error' => $e->getMessage()
              ], 500);
          }
      }

  

}
