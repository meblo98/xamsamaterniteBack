<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCampagneRequest;
use App\Http\Requests\UpdateCampagneRequest;
use App\Models\Campagne;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CampagneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campagnes = Campagne::all();
        return response()->json($campagnes, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCampagneRequest $request)
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
        $badienGox = $user->badienGox;

        if (!$badienGox) {
            return response()->json([
                'message' => 'Badiene Gox non trouvée pour cet utilisateur'
            ], Response::HTTP_NOT_FOUND);
        }


        // Validation
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Valider le type de fichier
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        // Gestion de l'upload de l'image
        $imagePath = $request->file('image')->store('campagnes', 'public'); // Stocke dans storage/app/public/campagnes

        // Créer la campagne
        $campagne = Campagne::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'image' => $imagePath, // Enregistrer le chemin de l'image dans la base de données
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'badien_gox_id' => $badienGox->id,
        ]);

        return response()->json($campagne, Response::HTTP_CREATED);
    }


    /**
     * Display the specified resource.
     */
    public function show(Campagne $campagne)
    {
        return response()->json($campagne, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campagne $campagne)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCampagneRequest $request, $id)
    {
        $user = Auth::user();
        $badienGox = $user->badienGox;

        if (!$badienGox) {
            return response()->json([
                'message' => 'Badiene Gox non trouvée pour cet utilisateur'
            ], Response::HTTP_NOT_FOUND);
        }

        // Récupérer la campagne
        $campagne = Campagne::where('badien_gox_id', $badienGox->id)->findOrFail($id);

        // Validation
        $request->validate([
            'nom' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Valider le type de fichier
            'date_debut' => 'sometimes|date',
            'date_fin' => 'sometimes|date|after_or_equal:date_debut',
        ]);

        // Gestion de l'upload de la nouvelle image si présente
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si nécessaire
            Storage::disk('public')->delete($campagne->image);

            // Stocker la nouvelle image
            $imagePath = $request->file('image')->store('campagnes', 'public');
            $campagne->image = $imagePath;
            $campagne->save(); 
        }

        // Mettre à jour les autres champs
        $campagne->update($request->only(['nom', 'description', 'date_debut', 'date_fin']));
        return response()->json($campagne, Response::HTTP_OK);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $badienGox = $user->badienGox;

        if (!$badienGox) {
            return response()->json([
                'message' => 'Badiene Gox non trouvée pour cet utilisateur'
            ], Response::HTTP_NOT_FOUND);
        }

        // Récupérer la campagne
        $campagne = Campagne::where('badien_gox_id', $badienGox->id)->findOrFail($id);

        // Supprimer l'image associée
        Storage::disk('public')->delete($campagne->image);

        // Supprimer la campagne
        $campagne->delete();

        return response()->json(['message' => 'Campagne supprimée'], Response::HTTP_OK);
    }
}
