<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatienteRequest;
use App\Http\Requests\UpdatePatienteRequest;
use App\Models\Patiente;

class PatienteController extends Controller
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
    public function store(StorePatienteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Patiente $patiente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patiente $patiente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatienteRequest $request, Patiente $patiente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patiente $patiente)
    {
        //
    }
}
