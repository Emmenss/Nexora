<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\LignePanier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
{
    public function ajouterAuPanier(Request $request)
    {
        $validatedData = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $panier = Panier::firstOrCreate(['user_id' => Auth::id()]);

        // Cherche si le produit existe déjà dans le panier
        $ligne = $panier->lignesPanier()->where('produit_id', $validatedData['produit_id'])->first();

        if ($ligne) {
            // Mise à jour de la quantité et du prix total si le produit est déjà présent
            $ligne->increment('quantite', $validatedData['quantite']);
            $ligne->increment('prixTotal', $validatedData['quantite'] * $ligne->prixUnitaire);
        } else {
            // Ajoute un nouveau produit dans le panier
            $produit = Produit::find($validatedData['produit_id']);
            $lignePanier = new LignePanier([
                'quantite' => $validatedData['quantite'],
                'prixTotal' => $validatedData['quantite'] * $produit->productprice,
                'prixUnitaire' => $produit->productprice,
            ]);
            $panier->lignesPanier()->save($lignePanier->produit()->associate($produit));
        }

        return response()->json(['message' => 'Produit ajouté au panier avec succès'], 201);
    }

    public function afficherPanier()
    {
        $panier = Panier::with('lignesPanier.produit')->where('user_id', Auth::id())->first();
        return response()->json($panier);
    }
}
