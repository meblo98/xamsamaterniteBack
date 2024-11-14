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
            // Vérifiez si l'utilisateur a des grossesses
            if ($user->patiente->grossesses->isEmpty()) {
                return response()->json(['message' => 'Aucune grossesse trouvée pour cette patiente']);
            }
            
            // Récupérez tous les IDs des grossesses
            $grossesseIds = $user->patiente->grossesses->pluck('id');
            // Récupérez tous les rendez-vous associés à ces grossesses
            $rendez_vouses = RendezVous::whereIn('grossesse_id', $grossesseIds)
                ->with(['consultation', 'sageFemme'])
                ->get();
            
            // Vérifiez si des rendez-vous ont été trouvés
            if ($rendez_vouses->isEmpty()) {
                return response()->json(['message' => 'Aucun rendez-vous trouvé pour cette patiente']);
            }
        
            // Retournez la liste des rendez-vous
            return response()->json($rendez_vouses);
        } elseif ($user->hasRole('sage-femme')) {

            $rendez_vouses = RendezVous::where('grossesse_id', $user->sageFemme->grossesses->id)
                ->with(['consultation', 'sageFemme'])
                ->get();
                if($rendez_vouses->isEmpty()){
                    return response()->json(['message'=> 'Aucune patiente trouvé']);
        } else {
            return response()->json(['error' => 'non authorisé'], 401);
        }

        return response()->json([
            'Liste_des_rendez-vous' => $rendez_vouses
        ], 200);
    }
}

public function getRendezvousByPatiente($id)
{
    // Trouver la patiente par son ID
    $patiente = Patiente::with('grossesses.rendezvous.consultation')->find($id);
    
    // Vérifiez si la patiente existe
    if (!$patiente) {
        return response()->json(['message' => 'Patiente non trouvée'], 404);
    }

    // Récupérer tous les rendez-vous associés à toutes les grossesses de la patiente
    $rendezvous = $patiente->grossesses->flatMap(function ($grossesse) {
        return $grossesse->rendezvous; // Récupère les rendez-vous pour chaque grossesse
    });

    // Vérifiez si des rendez-vous ont été trouvés
    if ($rendezvous->isEmpty()) {
        return response()->json(['message' => 'Aucun rendez-vous trouvé pour cette patiente'], 404);
    }

    // Retourner la liste des rendez-vous
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
        $rendezVous = $rv->load(['consultation']);

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
    public function destroy($id)
    {
        $rendezVous = RendezVous::findOrFail($id);
        $rendezVous->delete();

        return response()->json([
            'message' => 'Rendez-vous supprimé avec succès.'
        ], 200);
    }
}
