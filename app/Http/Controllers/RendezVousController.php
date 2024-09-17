<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Http\Requests\StoreRendezVousRequest;
use App\Http\Requests\UpdateRendezVousRequest;
use Illuminate\Http\Response;
class RendezVousController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rendez_vouses = RendezVous::with(['patiente', 'sageFemme', 'visite', 'vaccination'])->get();
        return response()->json([
            'Liste des rendez-vous' => $rendez_vouses
        ], 200);
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
    public function store(StoreRendezVousRequest $request)
    {
        $rendezVous = RendezVous::create($request->validated());

        return response()->json([
            'message' => 'Rendez-vous créé avec succès.',
            'rendezVous' => $rendezVous
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(RendezVous $rv)
    {
        // Charger les relations patiente, sageFemme, visite et vaccination
        $rendezVous = $rv->load(['patiente', 'sageFemme', 'visite', 'vaccination']);
    
        return response()->json($rendezVous, Response::HTTP_OK);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RendezVous $rendezVous)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRendezVousRequest $request, RendezVous $rv)
    {
        if (!$rv) {
            return response()->json([
                'message' => 'Rendez-vous non trouvée'
            ], Response::HTTP_NOT_FOUND);
        }

        $rv->update($request->validated());
       
        return response()->json([
            'message' => 'Rendez-vous mise à jour avec succès',
            'data' => $rv
        ], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RendezVous $rendezVous)
    {
        $rendezVous = RendezVous::findOrFail($rendezVous);
        $rendezVous->delete();

        return response()->json([
            'message' => 'Rendez-vous supprimé avec succès.'
        ], 200);
    }
    
}
