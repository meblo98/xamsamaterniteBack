<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStructureSanteRequest;
use App\Http\Requests\UpdateStructureSanteRequest;
use App\Models\StructureSante;
use Illuminate\Support\Facades\Log;

class StructureSanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Récupérer toutes les structures de santé avec pagination
            // $structuresSante = StructureSante::paginate(10); // 10 items per page

            $structuresSante = StructureSante::all();

            // Retourner les détails en réponse JSON
            return response()->json([
                'structures_sante' => $structuresSante,
            ], 200);
        } catch (\Exception $e) {
            // Log des erreurs et retour d'une réponse d'erreur
            Log::error('Erreur lors de la récupération des structures de santé: ' . $e->getMessage());
            return response()->json([
                'error' => 'Erreur lors de la récupération des structures de santé.',
            ], 500);
        }
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
public function store(StoreStructureSanteRequest $request)
{
    try {
        $structureSante = new StructureSante();
        $structureSante->nom = $request->input('nom');
        $structureSante->lieu = $request->input('lieu');
        $structureSante->district_sanitaire_id = $request->input('district_sanitaire_id');
        $structureSante->save();

        return response()->json([
            'message' => 'Structure de santé créée avec succès.',
        ], 201);
    } catch (\Exception $e) {
        Log::error('Erreur lors de la création de la structure de santé: ' . $e->getMessage());
        return response()->json([
            'error' => 'Erreur lors de la création de la structure de santé.',
        ], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $structureSante = StructureSante::findOrFail($id);
            return response()->json([
                'structure_sante' => $structureSante,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération de la structure de santé: ' . $e->getMessage());
            return response()->json([
                'error' => 'Erreur lors de la récupération de la structure de santé.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StructureSante $structureSante)
    {
        //
    }

  /**
 * Update the specified resource in storage.
 */
public function update(UpdateStructureSanteRequest $request, StructureSante $structureSante)
{
    try {
        $structureSante->nom = $request->input('nom');
        $structureSante->lieu = $request->input('lieu');
        $structureSante->district_sanitaire_id = $request->input('district_sanitaire_id');
        $structureSante->save();

        return response()->json([
            'message' => 'Structure de santé mise à jour avec succès.',
        ], 200);
    } catch (\Exception $e) {
        Log::error('Erreur lors de la mise à jour de la structure de santé: ' . $e->getMessage());
        return response()->json([
            'error' => 'Erreur lors de la mise à jour de la structure de santé.',
        ], 500);
    }
}

   /**
 * Remove the specified resource from storage.
 */
public function destroy(StructureSante $structureSante)
{
    try {
        $structureSante->delete();

        return response()->json([
            'message' => 'Structure de santé supprimée avec succès.',
        ], 200);
    } catch (\Exception $e) {
        Log::error('Erreur lors de la suppression de la structure de santé: ' . $e->getMessage());
        return response()->json([
            'error' => 'Erreur lors de la suppression de la structure de santé.',
        ], 500);
    }
}
}
