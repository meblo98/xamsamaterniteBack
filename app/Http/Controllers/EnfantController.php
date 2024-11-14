<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Enfant;
use Illuminate\Http\Request;
use App\Services\EnfantService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEnfantRequest;
<<<<<<< HEAD
=======
use App\Http\Requests\UpdateEnfantRequest;
use App\Models\Accouchement;
>>>>>>> feature/amelioration
use Symfony\Component\HttpFoundation\Response;

class EnfantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Lister tous les enfants
    public function index()
    {
        $enfants = Enfant::with('accouchement.grossesse.patiente.user')->get();
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
<<<<<<< HEAD

        try {
            $enfant = \DB::transaction(function () use ($request) {
=======
        // Récupérer la date d'accouchement
        $accouchement = Accouchement::where('id', $request->input('accouchement_id'))->first();
        // Remplacer la date de naissance par la date d'accouchement
        // Vérifier si la date d'accouchement est définie
        if (!is_null($accouchement->date)) {
            // Remplacer la date de naissance par la date d'accouchement
            $request->merge(['date_naissance' => $accouchement->date]);
        } else {
            // Gérer le cas où la date d'accouchement est null
            // Par exemple, vous pouvez renvoyer une erreur ou une réponse personnalisée
            return response()->json(['message' => 'La date d\'accouchement est requise.'], 422);
        }
        try {
            $enfant = \DB::transaction(function () use ($request) {

                // Créer l'enfant avec les données mises à jour
>>>>>>> feature/amelioration
                $enfant = Enfant::create($request->all());

                // Planifier les rendez-vous via le service
                EnfantService::planifierVaccinations($enfant);

                return $enfant; // Retourner l'instance créée
            });
        } catch (\Exception $e) {
            // Log the error or send a response with an error message
            Log::error($e->getMessage());
<<<<<<< HEAD
            return response()->json(['message' => 'Erreur lors de la création de l\'enfant'], 500);
=======
            return response()->json(['message' => 'Erreur lors de la création de l\'enfant ' . $e->getMessage()], 500);
>>>>>>> feature/amelioration
        }

        return response()->json($enfant, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    // Afficher un enfant spécifique
    public function show($id)
    {
        $enfant = Enfant::with('accouchement.grossesse.patiente.user')->findOrFail($id);
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
            'nom' => 'nullable|string',
            'prenom' => 'nullable|string',
            'lieu_naissance' => 'nullable|string',
            'sexe' => 'nullable|string',
            'date_naissance' => 'nullable|date',
            'accouchement_id' => 'nullable|exists:accouchements,id'
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
