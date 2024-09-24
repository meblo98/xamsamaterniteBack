<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisiteRequest;
use App\Http\Requests\UpdateVisiteRequest;
use App\Models\Visite;
use Illuminate\Http\Response;

class VisiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Lister toutes les visites
    public function index()
    {
        $visites = Visite::all();
        return response()->json([
            'ListeVisites' => $visites
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
   // Créer une nouvelle visite
   public function store(StoreVisiteRequest $request)
   {

       $visite = Visite::create($request->all());
       return response()->json($visite, Response::HTTP_CREATED);
   }

    /**
     * Display the specified resource.
     */
    // Afficher une visite spécifique
    public function show($id)
    {
        $visite = Visite::findOrFail($id);
        return response()->json($visite, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visite $visite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   
    // Mettre à jour une visite
    public function update(UpdateVisiteRequest $request, $id)
    {
        
        $visite = Visite::findOrFail($id);
        $visite->update($request->all());

        return response()->json($visite, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
   // Supprimer une visite
   public function destroy($id)
   {
       $visite = Visite::findOrFail($id);
       $visite->delete();

       return response()->json([
           'message' => 'Visite supprimée'
       ], Response::HTTP_OK);
   }
}
