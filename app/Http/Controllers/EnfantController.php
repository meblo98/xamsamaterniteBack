<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Enfant;
use Illuminate\Http\Request;
use App\Services\EnfantService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEnfantRequest;
use App\Http\Requests\UpdateEnfantRequest;
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
      $user = Auth::user();
      // Vérifier si l'utilisateur a le rôle "Sage-femme"
      if (!$user->hasRole('sage-femme')) {
          return response()->json([
              'message' => 'Vous n\'avez pas les autorisations nécessaires pour ajouter un enfant.',
          ], 403);
      }

      try {
        $enfant = \DB::transaction(function () use ($request) {
            $enfant = Enfant::create($request->all());

            // Planifier les rendez-vous via le service
            EnfantService::planifierVaccinations($enfant);

            return $enfant; // Retourner l'instance créée
        });

      } catch (\Exception $e) {
          // Log the error or send a response with an error message
          Log::error($e->getMessage());
          return response()->json(['message' => 'Erreur lors de la création de l\'enfant'], 500);
      }

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
