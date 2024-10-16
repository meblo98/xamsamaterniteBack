<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Patiente;
use App\Models\Grossesse;
use Illuminate\Http\Response;
use App\Services\GrossesseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreGrossesseRequest;
use App\Http\Requests\UpdateGrossesseRequest;

class GrossesseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
    public function store(StoreGrossesseRequest $request)
    {
        $user = Auth::user();
        // Vérifier si l'utilisateur a le rôle "Sage-femme"
        if (!$user->hasRole('sage-femme')) {
            return response()->json([
                'message' => 'Vous n\'avez pas les autorisations nécessaires pour ajouter une grossesse.',
            ], 403);
        }

        // Récupérer l'ID de la patiente
        $patienteId = $request->input('patiente_id');

        // Récupérer la date de naissance de la patiente
        $patiente = Patiente::find($patienteId);
        if (!$patiente) {
            return response()->json([
                'message' => 'La patiente n\'existe pas.',
            ], 404);
        }

        $dateNaissance = $patiente->date_de_naissance;
        $agePatiente = Carbon::parse($dateNaissance)->age;
        // Vérifier si la patiente a au moins 12 ans
        if ($agePatiente < 12) {
            return response()->json([
                'message' => 'La patiente doit avoir au moins 12 ans pour ajouter une grossesse.',
            ], 422);
        }

        // Vérifier si la patiente a déjà une grossesse en cours
        $lastGrossesse = $patiente->grossesses()->latest()->first();
        if ($lastGrossesse && $lastGrossesse->statut != 'termine' && $lastGrossesse->statut != 'avorte') {
            return response()->json([
                'message' => 'La patiente a déjà une grossesse en cours.',
            ], 422);
        }

        // Vérifier si la patiente a déjà accouché il y a moins de 28 jours
        if ($lastGrossesse && $lastGrossesse->statut == 'termine' && $lastGrossesse->accouchement->date_accouchement->diffInDays(Carbon::now()) < 28) {
            return response()->json([
                'message' => 'La patiente a déjà accouché il y a moins de 28 jours.',
            ], 422);
        }
        // Définir la date prévue pour l'accouchement en ajoutant 280 jours à la date de début
        $dateDebut = $request->input('date_debut');
        $datePrevueAccouchement = Carbon::parse($dateDebut)->addDays(280);

        // Mettre à jour la requête avec la date prévue pour l'accouchement
        $request->merge(['date_prevue_accouchement' => $datePrevueAccouchement]);
        // Créer la grossesse
        $grossesse = Grossesse::create($request->all());

        // Planifier les rendez-vous via le service
        GrossesseService::planifierRendezVous($grossesse);

        return response()->json([
            'message' => 'Grossesse et rendez-vous ajoutés avec succès.',
            'grossesse' => $grossesse,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $grossesse = Grossesse::with('accouchement','rendezVous.consultation','conseils')->find($id);
        if ($grossesse) {
            return response()->json($grossesse);
        } else {
            return response()->json(['error' => 'Grossesse not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grossesse $grossesse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGrossesseRequest $request, $id)
    {
        if (!$id) {
            return response()->json([
                'message' => 'Grossesse non trouvée'
            ], Response::HTTP_NOT_FOUND);
        }
    
        try {
            // Récupération de la grossesse à mettre à jour
            $grossesse = Grossesse::find($id);
    
            if (!$grossesse) {
                return response()->json([
                    'message' => 'Grossesse non trouvée'
                ], Response::HTTP_NOT_FOUND);
            }
    
            // Mise à jour des données de la grossesse
            $grossesse->update($request->all());
    
            // Récupération des données mises à jour
            $grossesse = $grossesse->fresh();  // Cela recharge les données depuis la base de données
    
            return response()->json([
                'message' => 'Grossesse mise à jour avec succès',
                'data' => $grossesse
            ], Response::HTTP_OK);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de la grossesse',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grossesse $grossesse)
    {
        //
    }
}
