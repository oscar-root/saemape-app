<?php

use App\Models\Declaration;
use Livewire\Volt\Component;

new class extends Component {
    public $qualite_minerai = 'Cuivre';
    public $quantite_produite; 
    public $tennaire;
    public $localite = '';
    public $estimation = 0;

    // Déclenche le calcul dès qu'un champ change
    public function updated($property)
    {
        if (is_numeric($this->quantite_produite) && is_numeric($this->tennaire)) {
            $this->estimation = Declaration::calculerCotisation(
                $this->qualite_minerai, 
                (float)$this->quantite_produite, 
                (float)$this->tennaire
            );
        } else {
            $this->estimation = 0;
        }
    }

    public function save()
    {
        $association = auth()->user()->association;

        // 1. Vérification de l'existence de l'association
        if (!$association) {
            session()->flash('error', 'Action Interrompue : Votre compte n\'est lié à aucune association. Allez dans "Mon Association" pour vous identifier.');
            return;
        }

        // 2. Validation rigoureuse
        $this->validate([
            'qualite_minerai' => 'required',
            'quantite_produite' => 'required|numeric|min:0.01',
            'tennaire' => 'required|numeric|between:0.1,100',
            'localite' => 'required|min:3',
        ], [
            'quantite_produite.required' => 'La quantité est obligatoire.',
            'tennaire.required' => 'La teneur est obligatoire.',
            'localite.required' => 'Le lieu d\'extraction est requis.',
        ]);

        try {
            // 3. Création de la déclaration
            Declaration::create([
                'association_id' => $association->id,
                'qualite_minerai' => $this->qualite_minerai,
                'quantite_produite' => $this->quantite_produite,
                'tennaire' => $this->tennaire,
                'localite' => $this->localite,
                'montant_cotisation' => $this->estimation,
                'statut' => 'en_attente'
            ]);

            session()->flash('message', 'Déclaration transmise avec succès ! Montant à régler : ' . number_format($this->estimation, 2) . ' USD');
            
            // Réinitialisation
            $this->reset(['quantite_produite', 'tennaire', 'localite', 'estimation']);

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de l\'enregistrement : ' . $e->getMessage());
        }
    }
}; ?>

<div class="max-w-5xl mx-auto space-y-6">
    
    <!-- NOTIFICATIONS -->
    @if (session('message'))
        <div class="p-5 bg-green-600 text-white rounded-3xl font-bold shadow-2xl flex items-center gap-4 animate-bounce">
            <div class="bg-white/20 p-2 rounded-full"><i class="fas fa-check"></i></div>
            {{ session('message') }}
        </div>
    @endif

    @if (session('error'))
        <div class="p-5 bg-red-600 text-white rounded-3xl font-bold shadow-2xl flex items-center gap-4">
            <div class="bg-white/20 p-2 rounded-full"><i class="fas fa-exclamation-triangle"></i></div>
            {{ session('error') }}
        </div>
    @endif

    <!-- FORMULAIRE -->
    <div class="bg-white rounded-[3rem] shadow-2xl border-t-[12px] border-saemape-gold overflow-hidden">
        <form wire:submit.prevent="save" class="p-8 md:p-12">
            
            <!-- Header du Formulaire -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 border-b border-gray-100 pb-8 gap-4">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 bg-saemape-blue rounded-2xl flex items-center justify-center text-saemape-gold shadow-xl rotate-3">
                        <i class="fas fa-gem text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-black text-saemape-blue uppercase tracking-tighter">Bulletin de Flux</h2>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-[0.2em]">Déclaration technique de production</p>
                    </div>
                </div>
                
                <!-- Indicateur de chargement discret -->
                <div wire:loading wire:target="save" class="flex items-center gap-3 px-4 py-2 bg-blue-50 text-saemape-blue rounded-full border border-blue-100 shadow-sm">
                    <i class="fas fa-circle-notch fa-spin"></i>
                    <span class="text-[10px] font-black uppercase">Traitement sécurisé...</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">
                
                <!-- COLONNE SAISIE (3/5) -->
                <div class="lg:col-span-3 space-y-8">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Minerai -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest ml-2">Nature du Produit</label>
                            <select wire:model.live="qualite_minerai" class="w-full rounded-2xl border-gray-200 bg-gray-50 py-4 font-bold text-sm focus:ring-saemape-gold transition-all">
                                @foreach(App\Models\Declaration::TARIFS as $nom => $tarif)
                                    <option value="{{ $nom }}">{{ $nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Localité -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest ml-2">Site / Carré Minier</label>
                            <input wire:model="localite" type="text" placeholder="Localité précise" 
                                class="w-full rounded-2xl bg-gray-50 py-4 font-bold text-sm focus:ring-saemape-gold transition-all border {{ $errors->has('localite') ? 'border-red-500' : 'border-gray-200' }}">
                            @error('localite') <span class="text-[10px] text-red-500 font-bold ml-2">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Quantité -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest ml-2">Poids Brut (Tonnes)</label>
                            <div class="relative">
                                <input wire:model.live="quantite_produite" type="number" step="0.01" placeholder="0.00"
                                    class="w-full rounded-2xl bg-gray-50 py-4 font-bold text-sm focus:ring-saemape-gold transition-all border {{ $errors->has('quantite_produite') ? 'border-red-500' : 'border-gray-200' }}">
                                <span class="absolute right-4 top-4 text-gray-300 font-black">T</span>
                            </div>
                            @error('quantite_produite') <span class="text-[10px] text-red-500 font-bold ml-2">{{ $message }}</span> @enderror
                        </div>

                        <!-- Teneur -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest ml-2">Tennaire / Pureté (%)</label>
                            <div class="relative">
                                <input wire:model.live="tennaire" type="number" step="0.1" placeholder="0.0"
                                    class="w-full rounded-2xl bg-gray-50 py-4 font-bold text-sm focus:ring-saemape-gold transition-all border {{ $errors->has('tennaire') ? 'border-red-500' : 'border-gray-200' }}">
                                <span class="absolute right-4 top-4 text-gray-300 font-black">%</span>
                            </div>
                            @error('tennaire') <span class="text-[10px] text-red-500 font-bold ml-2">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- COLONNE RÉSUMÉ (2/5) -->
                <div class="lg:col-span-2 flex flex-col">
                    <div class="flex-1 bg-gradient-to-br from-saemape-blue to-blue-900 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden group border-b-8 border-saemape-gold">
                        <!-- Filigrane -->
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                            <i class="fas fa-calculator text-9xl"></i>
                        </div>
                        
                        <div class="relative z-10 h-full flex flex-col justify-between">
                            <div>
                                <p class="text-[10px] font-black text-saemape-gold uppercase tracking-[0.2em] mb-4">Cotisation Estimée</p>
                                <div class="text-6xl font-black mb-1 flex items-baseline gap-2">
                                    {{ number_format($estimation, 2) }} <span class="text-lg font-bold text-saemape-gold/2">USD</span>
                                </div>
                                <p class="text-[10px] text-blue-200 italic font-medium">À valider au bureau de la caisse</p>
                            </div>
                            
                            <div class="mt-10 space-y-3 w-full border-t border-white/10 pt-6">
                                <div class="flex justify-between text-[10px] uppercase font-black tracking-tighter">
                                    <span class="text-blue-300">Taux {{ $qualite_minerai }} :</span> 
                                    <span class="text-white">{{ App\Models\Declaration::TARIFS[$qualite_minerai] ?? 0 }} $/T</span>
                                </div>
                                <div class="flex justify-between text-[10px] uppercase font-black tracking-tighter">
                                    <span class="text-blue-300">Formule :</span> 
                                    <span class="text-saemape-gold">Qte × Taux × Teneur</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOUTON DE SOUMISSION -->
            <div class="mt-12 pt-8 border-t border-gray-50 flex justify-end">
                <button type="submit" 
                        wire:loading.attr="disabled"
                        class="w-full md:w-auto px-16 py-5 bg-saemape-blue text-white rounded-2xl font-black text-xs uppercase shadow-2xl hover:bg-blue-900 hover:-translate-y-1 transition-all disabled:opacity-50 disabled:cursor-not-allowed group">
                    
                    <!-- État Normal -->
                    <span wire:loading.remove wire:target="save" class="flex items-center justify-center gap-3">
                        <i class="fas fa-paper-plane text-saemape-gold transition-transform group-hover:translate-x-2"></i>
                        Soumettre la Déclaration Officielle
                    </span>

                    <!-- État Chargement -->
                    <span wire:loading wire:target="save" class="flex items-center justify-center gap-3">
                        <i class="fas fa-spinner fa-spin"></i>
                        Transmission en cours...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>