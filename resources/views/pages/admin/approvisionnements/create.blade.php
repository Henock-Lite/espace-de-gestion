<x-layout.admin title="Nouvel approvisionnement">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('approvisionnements.index') }}" class="text-muted-foreground hover:text-foreground transition text-sm">
            ← Retour
        </a>
        <h1 class="text-xl md:text-2xl font-bold">Nouvel approvisionnement</h1>
    </div>

    @if($errors->has('error'))
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ $errors->first('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('approvisionnements.store') }}"
        x-data="{
            lignes: [{ produit_id: '', quantite: 1, prix_achat: 0, numero_lot: '', date_expiration: '', date_fabrication: '' }],
            get total() {
                return this.lignes.reduce((sum, l) => sum + (l.quantite * l.prix_achat), 0).toFixed(2);
            },
            ajouterLigne() {
                this.lignes.push({ produit_id: '', quantite: 1, prix_achat: 0, numero_lot: '', date_expiration: '', date_fabrication: '' });
            },
            supprimerLigne(index) {
                if (this.lignes.length > 1) this.lignes.splice(index, 1);
            }
        }">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            {{-- FOURNISSEUR --}}
            <div class="md:col-span-2 bg-card border border-border rounded-lg p-4">
                <h2 class="font-semibold mb-3">Fournisseur</h2>
                <select name="fournisseur_id"
                    class="input {{ $errors->has('fournisseur_id') ? 'border-red-500' : '' }}">
                    <option value="">— Sélectionner un fournisseur —</option>
                    @foreach($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id }}"
                            {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                            {{ $fournisseur->nom }}
                        </option>
                    @endforeach
                </select>
                @error('fournisseur_id') <p class="error">{{ $message }}</p> @enderror
            </div>

            {{-- TOTAL --}}
            <div class="bg-card border border-border rounded-lg p-4 flex flex-col justify-between">
                <h2 class="font-semibold mb-2">Total</h2>
                <p class="text-2xl md:text-3xl font-bold text-primary" x-text="total + ' DA'"></p>
            </div>

        </div>

        {{-- LIGNES --}}
        <div class="bg-card border border-border rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold">Produits</h2>
                <button type="button" @click="ajouterLigne()" class="btn btn-outlined text-xs">
                    + Ajouter produit
                </button>
            </div>

            <div class="space-y-4">
                <template x-for="(ligne, index) in lignes" :key="index">
                    <div class="border border-border rounded-lg p-4 relative">

                        <button type="button"
                            @click="supprimerLigne(index)"
                            x-show="lignes.length > 1"
                            class="absolute top-3 right-3 text-red-400 hover:text-red-300 transition text-lg">
                            ✕
                        </button>

                        {{-- Produit + N° Lot --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="text-xs text-muted-foreground mb-1 block">Produit</label>
                                <select :name="'lignes[' + index + '][produit_id]'"
                                    x-model="ligne.produit_id"
                                    class="input text-sm">
                                    <option value="">— Sélectionner —</option>
                                    @foreach($produits as $produit)
                                        <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-xs text-muted-foreground mb-1 block">N° Lot</label>
                                <input type="text"
                                    :name="'lignes[' + index + '][numero_lot]'"
                                    x-model="ligne.numero_lot"
                                    class="input text-sm"
                                    placeholder="Ex: LOT-2024-001">
                            </div>
                        </div>

                        {{-- Quantité + Prix + Dates --}}
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <div>
                                <label class="text-xs text-muted-foreground mb-1 block">Quantité</label>
                                <input type="number"
                                    :name="'lignes[' + index + '][quantite]'"
                                    x-model="ligne.quantite"
                                    class="input text-sm"
                                    min="1">
                            </div>
                            <div>
                                <label class="text-xs text-muted-foreground mb-1 block">Prix achat (DA)</label>
                                <input type="number"
                                    :name="'lignes[' + index + '][prix_achat]'"
                                    x-model="ligne.prix_achat"
                                    class="input text-sm"
                                    step="0.01" min="0">
                            </div>
                            <div>
                                <label class="text-xs text-muted-foreground mb-1 block">Date fabrication</label>
                                <input type="date"
                                    :name="'lignes[' + index + '][date_fabrication]'"
                                    x-model="ligne.date_fabrication"
                                    class="input text-sm">
                            </div>
                            <div>
                                <label class="text-xs text-muted-foreground mb-1 block">Date expiration</label>
                                <input type="date"
                                    :name="'lignes[' + index + '][date_expiration]'"
                                    x-model="ligne.date_expiration"
                                    class="input text-sm">
                            </div>
                        </div>

                        <div class="mt-3 text-right text-sm text-muted-foreground">
                            Sous-total :
                            <span class="font-medium text-foreground"
                                x-text="(ligne.quantite * ligne.prix_achat).toFixed(2) + ' DA'">
                            </span>
                        </div>

                    </div>
                </template>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <button type="submit" class="btn w-full sm:w-auto">Créer l'approvisionnement</button>
            <a href="{{ route('approvisionnements.index') }}" class="btn btn-outlined w-full sm:w-auto text-center">Annuler</a>
        </div>

    </form>

</x-layout.admin>