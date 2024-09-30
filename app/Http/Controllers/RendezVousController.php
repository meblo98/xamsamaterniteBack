<?php

namespace App\Http\Controllers;

use App\Models\Patiente;
use App\Models\RendezVous;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRendezVousRequest;
use App\Http\Requests\UpdateRendezVousRequest;

class RendezVousController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('patiente')) {
            $rendez_vouses = RendezVous::where('patiente_id', $user->id)
                ->with(['patiente', 'sageFemme', 'visite', 'vaccination'])
                ->get();
        } elseif ($user->hasRole('sage-femme')) {
            $rendez_vouses = RendezVous::where('sage_femme_id', $user->id)
                ->with(['patiente', 'sageFemme', 'visite', 'vaccination'])
                ->get();
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'Liste_des_rendez-vous' => $rendez_vouses
        ], 200);
    }

    public function getRendezvousByPatiente($id)
    {
        $patiente = Patiente::find($id);
        $rendezvous = $patiente->rendezvous->load('visite');
        return response()->json([
            'mes_rv' => $rendezvous
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
        $user = Auth::user(); // Récupère l'utilisateur connecté
        $sageFemmeId = $user->sageFemme->id; // Récupère l'id de la sage-femme associée à l'utilisateur

        $rendezVous = RendezVous::create([
            'date_rv' => $request->date_rv,
            'patiente_id' => $request->patiente_id,
            'sage_femme_id' => $sageFemmeId,
            'visite_id' => $request->visite_id,
            'vaccination_id' => $request->vaccination_id,
        ]);

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
