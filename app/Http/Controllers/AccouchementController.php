<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccouchementRequest;
use App\Http\Requests\UpdateAccouchementRequest;
use App\Models\Accouchement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccouchementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      // Liste des accouchements
      public function index()
      {
          $accouchements = Accouchement::with('patiente')->get();
          return response()->json([
              'accouchements' => $accouchements,
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
      // Ajouter un nouvel accouchement
      public function store(Request $request)
      {
          $validator = Validator::make($request->all(), [
              'patiente_id' => 'required|exists:patientes,id',
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
  
          if ($validator->fails()) {
              return response()->json($validator->errors(), 400);
          }
  
          $accouchement = Accouchement::create($request->all());
  
          return response()->json($accouchement, 201);
      }

    /**
     * Display the specified resource.
     */
    // Afficher un accouchement spécifique
    public function show($id)
    {
        $accouchement = Accouchement::with('patiente')->find($id);

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
            'patiente_id' => 'required|exists:patientes,id',
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

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $accouchement->update($request->all());

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
