<x-layout.admin title="Nouvelle vente">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('ventes.index') }}" class="text-muted-foreground hover:text-foreground transition">
            ← Retour
        </a>
        <h1 class="text-2xl font-bold">Nouvelle vente</h1>
    </div>

    @if($errors->has('error'))
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ $errors->first('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('ventes.store') }}"
        x-data="{
            lignes: [{ produit_id: '', quantite: 1, prix_unitaire: 0 }],
            get total() {
                return this.lignes.reduce((sum, l) => sum + (l.quantite * l.prix_unitaire), 0).toFixed(2);
            },
            ajouterLigne() {
                this.lignes.push({ produit_id: '', quantite: 1, prix_unitaire: 0 });
            },
            supprimerLigne(index) {
                if (this.lignes.length > 1) this.lignes.splice(index, 1);
            }
        }">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            {{-- CLIENT --}}
            <div class="md:col-span-2 bg-card border border-border rounded-lg p-4">
                <h2 class="font-semibold mb-3">Client</h2>
                <select name="client_id" class="input">
                    <option value="">— Client anonyme —</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}"
                            {{ old('client_id') == $client->id ? 'selected' : '' }}>
                            {{ $client->nom }} {{ $client->prenom }}
                            @if($client->telephone) — {{ $client->telephone }} @endif
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TOTAL --}}
            <div class="bg-card border border-border rounded-lg p-4 flex flex-col justify-between">
                <h2 class="font-semibold mb-2">Total</h2>
                <p class="text-3xl font-bold text-primary" x-text="total + ' DA'"></p>
            </div>

        </div>

        {{-- LIGNES --}}
        <div class="bg-card border border-border rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold">Produits</h2>
                <button type="button" @click="ajouterLigne()" class="btn btn-outlined text-xs">
                    + Ajouter ligne
                </button>
            </div>

            <div class="space-y-3">
                <template x-for="(ligne, index) in lignes" :key="index">
                    <div class="grid grid-cols-12 gap-3 items-end">

                        {{-- Produit --}}
                        <div class="col-span-5">
                            <label class="text-xs text-muted-foreground mb-1 block">Produit</label>
                            <select :name="'lignes[' + index + '][produit_id]'"
                                x-model="ligne.produit_id"
                                class="input text-sm">
                                <option value="">— Sélectionner —</option>
                                @foreach($produits as $produit)
                                    <option value="{{ $produit->id }}"
                                        data-prix="{{ $produit->lots->first()?->prix_achat ?? 0 }}">
                                        {{ $produit->nom }}
                                        (stock: {{ $produit->stock_total }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Quantité --}}
                        <div class="col-span-2">
                            <label class="text-xs text-muted-foreground mb-1 block">Quantité</label>
                            <input type="number"
                                :name="'lignes[' + index + '][quantite]'"
                                x-model="ligne.quantite"
                                class="input text-sm"
                                min="1">
                        </div>

                        {{-- Prix unitaire --}}
                        <div class="col-span-3">
                            <label class="text-xs text-muted-foreground mb-1 block">Prix unitaire (DA)</label>
                            <input type="number"
                                :name="'lignes[' + index + '][prix_unitaire]'"
                                x-model="ligne.prix_unitaire"
                                class="input text-sm"
                                step="0.01" min="0">
                        </div>

                        {{-- Sous-total --}}
                        <div class="col-span-1">
                            <label class="text-xs text-muted-foreground mb-1 block">S/Total</label>
                            <p class="text-sm font-medium pt-3"
                                x-text="(ligne.quantite * ligne.prix_unitaire).toFixed(2)">
                            </p>
                        </div>

                        {{-- Supprimer --}}
                        <div class="col-span-1">
                            <button type="button"
                                @click="supprimerLigne(index)"
                                x-show="lignes.length > 1"
                                class="text-red-400 hover:text-red-300 transition text-lg">
                                ✕
                            </button>
                        </div>

                    </div>
                </template>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn">Valider la vente</button>
            <a href="{{ route('ventes.index') }}" class="btn btn-outlined">Annuler</a>
        </div>

    </form>

</x-layout.admin>