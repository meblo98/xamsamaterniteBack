<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnfantRequest;
use App\Http\Requests\UpdateEnfantRequest;
use App\Models\Enfant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnfantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Lister tous les enfants
    public function index()
    {
        $enfants = Enfant::with('accouchement')->get();
        return response()->json([
            'Liste_des_enfants' => $enfants
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
  // Créer un nouvel enfant
  public function store(StoreEnfantRequest $request)
  {

      $enfant = Enfant::create($request->all());
      return response()->json($enfant, Response::HTTP_CREATED);
  }

    /**
     * Display the specified resource.
     */
      // Afficher un enfant spécifique
      public function show($id)
      {
          $enfant = Enfant::with('accouchement.patiente.user')->findOrFail($id);
          return response()->json($enfant, Response::HTTP_OK);
      }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enfant $enfant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // Mettre à jour un enfant
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'string',
            'prenom' => 'string',
            'lieu_naissance' => 'string',
            'sexe' => 'string',
            'date_naissance' => 'date',
            'accouchement_id' => 'exists:accouchements,id'
        ]);

        $enfant = Enfant::findOrFail($id);
        $enfant->update($request->all());

        return response()->json($enfant, Response::HTTP_OK);
    }


    /**
     * Remove the specified resource from storage.
     */
     // Supprimer un enfant
     public function destroy($id)
     {
         $enfant = Enfant::findOrFail($id);
         $enfant->delete();

         return response()->json([
             'message' => 'Enfant supprimé'
         ], Response::HTTP_OK);
     }
}
