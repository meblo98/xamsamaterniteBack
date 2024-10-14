<?php

namespace App\Http\Controllers;

use App\Models\Grossesse;
use App\Services\GrossesseService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreGrossesseRequest;
use App\Http\Requests\UpdateGrossesseRequest;

class GrossesseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreGrossesseRequest $request)
    {
        $user = Auth::user();
        // Vérifier si l'utilisateur a le rôle "Sage-femme"
        if (!$user->hasRole('sage-femme')) {
            return response()->json([
                'message' => 'Vous n\'avez pas les autorisations nécessaires pour ajouter une grossesse.',
            ], 403);
        }
  
        // Créer la grossesse
        $grossesse = Grossesse::create($request->all());
    
        // Planifier les rendez-vous via le service
        GrossesseService::planifierRendezVous($grossesse);
    
        return response()->json([
            'message' => 'Grossesse et rendez-vous ajoutés avec succès.',
            'grossesse' => $grossesse,
            // 'patiente' => $grossesse->patiente
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Grossesse $grossesse)
    {
        //
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
    public function update(UpdateGrossesseRequest $request, Grossesse $grossesse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grossesse $grossesse)
    {
        //
    }
}
