<?php

namespace App\Http\Controllers;

use App\Models\Conseil;
use App\Models\Patiente;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreConseilRequest;
use App\Http\Requests\UpdateConseilRequest;

class ConseilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); // Récupère l'utilisateur connecté
    
        if ($user->role === 'sage-femme') {
            // Si l'utilisateur est une sage-femme, récupérer les conseils qu'elle a créés
            $conseils = Conseil::where('sage_femme_id', $user->sageFemme->id)->get();
            if($conseils->isEmpty()){
                return response()->json(['message' => 'Aucun conseil trouvé'], Response::HTTP_OK);
            }
        } elseif ($user->role === 'patiente') {
            // Si l'utilisateur est une patiente, récupérer les conseils qui lui sont destinés
            $patiente = Patiente::where('user_id', $user->id)->first();
    
            if (!$patiente) {
                return response()->json(['message' => 'Non autorisé'], 403);
            }
    
            $conseils = Conseil::where('patiente_id', $patiente->id)->get();
            if($conseils->isEmpty()){
                return response()->json(['message' => 'Aucun conseil trouvé'], Response::HTTP_OK);
            }
        } else {
            return response()->json(['message' => 'Non autorisé'], 403);
        }
    
        return response()->json($conseils, Response::HTTP_OK);
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
    public function store(StoreConseilRequest $request)
    {
        $user = Auth::user();
        $sageFemme = $user->sageFemme;
    
        if (!$sageFemme) {
            return response()->json(['message' => 'Sage-femme non trouvée pour cet utilisateur'], Response::HTTP_NOT_FOUND);
        }
    
       
        // Gestion de l'upload de l'image
        $imagePath = $request->file('image')->store('conseils', 'public');
    
        // Création du conseil
        $conseil = Conseil::create([
            'description' => $request->description,
            'image' => $imagePath,
            'sage_femme_id' => $sageFemme->id,
            'grossesse_id' => $request->grossesse_id,
        ]);
    
        return response()->json($conseil, Response::HTTP_CREATED);
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $user = Auth::user();
    $sageFemme = $user->sageFemme;

    if (!$sageFemme) {
        return response()->json(['message' => 'Sage-femme non trouvée pour cet utilisateur'], Response::HTTP_NOT_FOUND);
    }

    $conseil = Conseil::where('sage_femme_id', $sageFemme->id)->with('patiente')->findOrFail($id);

    return response()->json($conseil);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Conseil $conseil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConseilRequest $request, $id)
    {
        $user = Auth::user();
        $sageFemme = $user->sageFemme;
    
        if (!$sageFemme) {
            return response()->json(['message' => 'Sage-femme non trouvée pour cet utilisateur'], Response::HTTP_NOT_FOUND);
        }
    
        // Récupérer le conseil
        $conseil = Conseil::where('sage_femme_id', $sageFemme->id)->findOrFail($id);
    
        // Mise à jour de l'image si elle est fournie
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            Storage::disk('public')->delete($conseil->image);
    
            // Stocker la nouvelle image
            $imagePath = $request->file('image')->store('conseils', 'public');
            $conseil->image = $imagePath;
        }
    
        // Mise à jour des autres champs
        $conseil->update($request->except('image'));
    
        return response()->json($conseil, Response::HTTP_OK);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $sageFemme = $user->sageFemme;
    
        if (!$sageFemme) {
            return response()->json(['message' => 'Sage-femme non trouvée pour cet utilisateur'], Response::HTTP_NOT_FOUND);
        }
    
        // Récupérer le conseil
        $conseil = Conseil::where('sage_femme_id', $sageFemme->id)->findOrFail($id);
    
        // Supprimer l'image associée
        Storage::disk('public')->delete($conseil->image);
    
        // Supprimer le conseil
        $conseil->delete();
    
        return response()->json(['message' => 'Conseil supprimé'], Response::HTTP_OK);
    }
    
}
