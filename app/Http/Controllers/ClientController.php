<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::orderBy('client_name')->paginate(10);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name'      => 'required|string|max:255',
            'client_email'     => 'required|email|unique:clients,client_email',
            'industry_type'    => 'nullable|string|max:255',
            'client_number'    => 'nullable|string|max:20',
            'client_address'   => 'required|string',
            'pan'              => 'nullable|string|max:20',
            'gst'              => 'nullable|string|max:20',
            'tan_number'       => 'nullable|string|max:20',
            'cin_number'       => 'nullable|string|max:20',
            'pf_num'           => 'nullable|string|max:20',
            'esi_num'          => 'nullable|string|max:20',
            'pt_num'           => 'nullable|string|max:20',
            'lwf_num'          => 'nullable|string|max:20',
            'poc_name'         => 'nullable|string|max:255',
            'poc_designation'  => 'nullable|string|max:255',
            'poc_email'        => 'nullable|email',
            'poc_number'       => 'nullable|string|max:20',
        ]);

        $client = Client::create($validated);
   
        return redirect()->route('clients.index')
            ->with('success', 'Client created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'client_name'      => 'nullable|string|max:255',
            'client_email'     => 'nullable|email|',
            'industry_type'    => 'nullable|string|max:255',
            'client_number'    => 'nullable|string|max:20',
            'client_address'   => 'nullable|string',
            'pan'              => 'nullable|string|max:20',
            'gst'              => 'nullable|string|max:20',
            'tan_number'       => 'nullable|string|max:20',
            'cin_number'       => 'nullable|string|max:20',
            'pf_num'           => 'nullable|string|max:20',
            'esi_num'          => 'nullable|string|max:20',
            'pt_num'           => 'nullable|string|max:20',
            'lwf_num'          => 'nullable|string|max:20',
            'poc_name'         => 'nullable|string|max:255',
            'poc_designation'  => 'nullable|string|max:255',
            'poc_email'        => 'nullable|email',
            'poc_number'       => 'nullable|string|max:20',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}
