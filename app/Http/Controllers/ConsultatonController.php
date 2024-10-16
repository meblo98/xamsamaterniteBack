<?php

namespace App\Http\Controllers;

use App\Models\Patiente;
use App\Models\Consultaton;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreConsultatonRequest;
use App\Http\Requests\UpdateConsultatonRequest;

class ConsultatonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); // Récupère l'utilisateur connecté
        // $sageFemmeId = $user->sageFemme->id; // Récupère l'id de la sage-femme associée à l'utilisateur

        // $consultations = Consultaton::where('sage_femme_id', $sageFemmeId)->get();
        if ($user->hasRole('sage-femme')) {
            $sageFemmeId = $user->sageFemme->id; // Récupère l'id de la sage-femme associée à l'utilisateur
        $consultations = Consultaton::where('sage_femme_id', $sageFemmeId)->get();
        if($consultations->isEmpty()){
            return response()->json(['message' => 'Aucune consultation trouvé'], 404);
        }
    } elseif ($user->hasRole('badien-gox')) {
            $badieneId = $user->badienGox->id; // Récupère l'id de la badiene associée à l'utilisateur
        $consultations = Consultaton::where('badien_gox_id', $badieneId)->get();
        if($consultations->isEmpty()){
            return response()->json(['message' => 'Aucune consultation trouvé'], 404);
        }
    } else {
            // Handle case where user doesn't have either role
            $consultations = collect(); // Return an empty collection
        }

        return response()->json($consultations, Response::HTTP_OK);
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
    public function store(StoreConsultatonRequest $request)
    {
        $user = Auth::user(); // Récupère l'utilisateur authentifié
        // Vérifie si l'utilisateur est associé à une sage-femme
        if (!$user->sageFemme) {
            return response()->json([
                'message' => 'L\'utilisateur n\'est pas associé à une sage-femme',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    
        $request->merge(['sage_femme_id' => $user->sageFemme->id]);
        $consultation = Consultaton::create($request->all());
        return response()->json([
            'message' => 'Consultation créée avec succès',
            'data' => $consultation
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $consultation = Consultaton::find($id)->load('visite');

        if (!$consultation) {
            return response()->json([
                'message' => 'Consultation non trouvée'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($consultation, Response::HTTP_OK);
    }

    /**
     * Récupère la liste des consultations pour une patiente donnée.
     */
    public function getConsultationsByPatient($patientId)
    {
        $patiente = Patiente::find($patientId);
        $consultations = $patiente->consultations->load('visite');
        return response()->json(['consultations' => $consultations, Response::HTTP_OK]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultaton $consultaton)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConsultatonRequest $request, Consultaton $consultation)
    {
        if (!$consultation) {
            return response()->json([
                'message' => 'Consultation non trouvée'
            ], Response::HTTP_NOT_FOUND);
        }

        $consultation->update($request->validated());

        return response()->json([
            'message' => 'Consultation mise à jour avec succès',
            'data' => $consultation
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultaton $id)
    {
        $consultation = Consultaton::find($id);

        if (!$consultation) {
            return response()->json([
                'message' => 'Consultation non trouvée'
            ], Response::HTTP_NOT_FOUND);
        }

        $consultation->delete();

        return response()->json([
            'message' => 'Consultation supprimée avec succès'
        ], Response::HTTP_OK);
    }
}
