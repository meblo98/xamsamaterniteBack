<?php

namespace App\Http\Controllers;

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
        $sageFemmeId = $user->sageFemme->id; // Récupère l'id de la sage-femme associée à l'utilisateur

        $consultations = Consultaton::where('sage_femme_id', $sageFemmeId)->get();

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
        $user = Auth::user(); // Récupère l'utilisateur connecté
        $sageFemmeId = $user->sageFemme->id; // Récupère l'id de la sage-femme associée à l'utilisateur

        $validatedData = $request->validated();
        $validatedData['sage_femme_id'] = $sageFemmeId;

        $consultation = Consultaton::create($validatedData);

        return response()->json([
            'message' => 'Consultation créée avec succès',
            'data' => $consultation
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultaton $consultation)
    {
        $consultation = Consultaton::find($consultation);

        if (!$consultation) {
            return response()->json([
                'message' => 'Consultation non trouvée'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($consultation, Response::HTTP_OK);
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
