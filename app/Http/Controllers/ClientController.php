<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('pages.admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('pages.admin.clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'            => 'required|string|max:255',
            'prenom'         => 'nullable|string|max:255',
            'telephone'      => 'nullable|string|unique:clients,telephone',
            'email'          => 'nullable|email|unique:clients,email',
            'adresse'        => 'nullable|string',
            'ville'          => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')
            ->with('success', 'Client créé avec succès.');
    }

    public function show(string $id)
    {
        $client = Client::with('ventes.lignes.produit')
            ->findOrFail($id);

        return view('pages.admin.clients.show', compact('client'));
    }

    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('pages.admin.clients.edit', compact('client'));
    }

    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'nom'            => 'required|string|max:255',
            'prenom'         => 'nullable|string|max:255',
            'telephone'      => 'nullable|string|unique:clients,telephone,' . $id,
            'email'          => 'nullable|email|unique:clients,email,' . $id,
            'adresse'        => 'nullable|string',
            'ville'          => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date',
            'is_active'      => 'boolean',
        ]);

        $client->update($request->all());

        return redirect()->route('clients.index')
            ->with('success', 'Client mis à jour.');
    }

    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->update(['is_active' => false]);

        return redirect()->route('clients.index')
            ->with('success', 'Client désactivé.');
    }
}