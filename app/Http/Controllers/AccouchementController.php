<?php

namespace App\Http\Controllers;

use App\Models\Enfant;
use App\Models\Accouchement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreAccouchementRequest;
use App\Http\Requests\UpdateAccouchementRequest;

class AccouchementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Liste des accouchements
    public function index()
    {
        $accouchements = Accouchement::with('grossesse.patiente.user')->get();

        if ($accouchements->isEmpty()) {
            return response()->json(['message' => 'Aucun accouchement trouvé'], 404);
        } else {
            return response()->json([
                'accouchements' => $accouchements,
            ], 200);
        }
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
    // Ajouter un nouvel accouchement
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'grossesse_id' => 'required|exists:grossesses,id',
            'lieu' => 'required|in:maternité,domicile',
            'mode' => 'required|in:naturel,instrumental,césarienne',
            'date' => 'required|date',
            'heure' => 'required|date_format:H:i',
            'terme' => 'required|string',
            'mois_grossesse' => 'required|integer|min:1|max:9',
            'debut_travail' => 'required|date_format:H:i',
            'perinee' => 'required|in:intact,episiotomie,dechirure',
            'pathologie' => 'nullable|string',
            'evolution_reanimation' => 'required|in:favorable,transfert,décès',
        ]);
        $user = Auth::user();
        // Vérifier si l'utilisateur a le rôle "Sage-femme"
        if (!$user->hasRole('sage-femme')) {
            return response()->json([
                'message' => 'Vous n\'avez pas les autorisations nécessaires pour ajouter un accouchement.',
            ], 403);
        }
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $grossesse_id = $request->input('grossesse_id');
        if (Accouchement::where('grossesse_id', $grossesse_id)->exists()) {
            return response()->json(['message' => 'Un accouchement existe déjà pour cette grossesse.'], 400);
        }
        $data = $validator->validated();
        $data['sage_femme_id'] = $user->sageFemme->id; // Add sage_femme_id to the validated data


        $accouchement = Accouchement::create($data);

        return response()->json($accouchement, 201);
    }

    // Récupérer les accouchements d'une patiente spécifique
    public function getAccouchementsByPatiente($patiente_id)
    {
        $accouchements = Accouchement::where('patiente_id', $patiente_id)->with('patiente')->get();

        if ($accouchements->isEmpty()) {
            return response()->json(['message' => 'Aucun accouchement trouvé pour cette patiente'], 404);
        }

        return response()->json(['accouchements' => $accouchements], 200);
    }

    // Dans le contrôleur AccouchementController
public function getAccouchementByEnfant($enfant_id)
{
    $enfant = Enfant::find($enfant_id);
    if (!$enfant) {
        return response()->json(['message' => 'Enfant non trouvé'], 404);
    }

    $accouchement = $enfant->accouchement;

    if (!$accouchement) {
        return response()->json(['message' => 'Accouchement non trouvé pour cet enfant'], 404);
    }

    return response()->json($accouchement, 200);
}

    /**
     * Display the specified resource.
     */
    // Afficher un accouchement spécifique
    public function show($id)
    {
        $accouchement = Accouchement::with('patiente.user')->find($id);

        if (!$accouchement) {
            return response()->json(['message' => 'Accouchement non trouvé'], 404);
        }

        return response()->json($accouchement, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Accouchement $accouchement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // Mettre à jour un accouchement
    public function update(Request $request, $id)
    {
        $accouchement = Accouchement::find($id);
        if (!$accouchement) {
            return response()->json(['message' => 'Accouchement non trouvé'], 404);
        }

        $validator = Validator::make($request->all(), [
            'lieu' => 'nullable|in:maternité,domicile',
            'mode' => 'nullable|in:naturel,instrumental,césarienne',
            'date' => 'nullable|date',
            'heure' => 'nullable|date_format:H:i',
            'terme' => 'nullable|string',
            'mois_grossesse' => 'nullable|integer|min:1|max:9',
            'debut_travail' => 'nullable|date_format:H:i',
            'perinee' => 'nullable|in:intact,episiotomie,dechirure',
            'pathologie' => 'nullable|string',
            'evolution_reanimation' => 'nullable|in:favorable,transfert,décès',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $accouchement->update($validator->validated());

        return response()->json($accouchement, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    // Supprimer un accouchement
    public function destroy($id)
    {
        $accouchement = Accouchement::find($id);

        if (!$accouchement) {
            return response()->json(['message' => 'Accouchement non trouvé'], 404);
        }

        $accouchement->delete();

        return response()->json(['message' => 'Accouchement supprimé'], 200);
    }
}
