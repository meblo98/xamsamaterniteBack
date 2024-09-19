<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVaccinationRequest;
use App\Http\Requests\UpdateVaccinationRequest;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VaccinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Lister toutes les vaccinations
    public function index()
    {
        $vaccinations = Vaccination::with('enfant')->get();
        return response()->json([
            'Liste des vaccinations' => $vaccinations
        ], Response::HTTP_OK);
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
    // Créer une nouvelle vaccination
    public function store(StoreVaccinationRequest $request)
    {
       
        $vaccination = Vaccination::create($request->all());
        return response()->json($vaccination, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    // Afficher une vaccination spécifique
    public function show($id)
    {
        $vaccination = Vaccination::with('enfant')->findOrFail($id);
        return response()->json($vaccination, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vaccination $vaccination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    // Mettre à jour une vaccination
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'string',
            'observation' => 'nullable|string',
            'dose' => 'string',
            'enfant_id' => 'exists:enfants,id'
        ]);

        $vaccination = Vaccination::findOrFail($id);
        $vaccination->update($request->all());

        return response()->json($vaccination, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    // Supprimer une vaccination
    public function destroy($id)
    {
        $vaccination = Vaccination::findOrFail($id);
        $vaccination->delete();

        return response()->json([
            'message' => 'Vaccination supprimée'
        ], Response::HTTP_OK);
    }
}
