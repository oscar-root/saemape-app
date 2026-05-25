<?php

use App\Models\Association;
use Livewire\Volt\Component;

new class extends Component {
    public $num_rccm, $raison_sociale, $date_creation;
    public $association;

    public function mount()
    {
        // Récupération automatique de l'association liée au compte connecté
        $this->association = auth()->user()->association;
    }

    public function identify()
    {
        $this->validate([
            'num_rccm' => 'required|unique:associations,num_rccm',
            'raison_sociale' => 'required|min:5',
            'date_creation' => 'required|date',
        ]);

        // Création avec lien automatique vers l'ID du délégué connecté
        $this->association = Association::create([
            'num_rccm' => $this->num_rccm,
            'raison_sociale' => $this->raison_sociale,
            'date_creation' => $this->date_creation,
            'user_id' => auth()->id(), // Récupéré automatiquement
            'statut' => 'en_attente'
        ]);

        session()->flash('message', 'Identification réussie ! Votre association est désormais rattachée à votre profil délégué.');
    }
}; ?>

<div class="max-w-5xl mx-auto">
    @if(!$association)
        <!-- PHASE D'IDENTIFICATION -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 animate-reveal">
            <div class="flex flex-col md:flex-row">
                
                <!-- Gauche : Le Formulaire de l'Association -->
                <div class="p-10 flex-1">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-saemape-gold rounded-xl flex items-center justify-center text-blue-900 shadow-lg">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-saemape-blue uppercase">Fiche d'Identification</h2>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Complétez les données de l'entité minière</p>
                        </div>
                    </div>

                    <form wire:submit.prevent="identify" class="space-y-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest ml-2">Dénomination (Raison Sociale)</label>
                            <input wire:model="raison_sociale" type="text" class="w-full rounded-2xl border-gray-100 bg-gray-50 py-4 font-bold text-sm focus:ring-saemape-gold" placeholder="Ex: COOPÉRATIVE MINIÈRE DE KAMINA">
                            @error('raison_sociale') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest ml-2">N° RCCM Officiel</label>
                                <input wire:model="num_rccm" type="text" class="w-full rounded-2xl border-gray-100 bg-gray-50 py-4 font-bold text-sm focus:ring-saemape-gold" placeholder="CD/KMN/RCCM/...">
                                @error('num_rccm') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest ml-2">Date de Création</label>
                                <input wire:model="date_creation" type="date" class="w-full rounded-2xl border-gray-100 bg-gray-50 py-4 font-bold text-sm">
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-saemape-blue text-white py-5 rounded-2xl font-black text-xs uppercase shadow-xl hover:bg-blue-900 transition-all flex items-center justify-center gap-3">
                                <i class="fas fa-check-circle text-saemape-gold"></i> CERTIFIER ET ENREGISTRER
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Droite : Reconnaissance automatique du Délégué -->
                <div class="bg-saemape-blue p-10 w-full md:w-80 text-white flex flex-col justify-center relative overflow-hidden">
                    <!-- Déco -->
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <i class="fas fa-user-shield text-9xl"></i>
                    </div>

                    <div class="relative z-10">
                        <h3 class="text-saemape-gold font-black text-[10px] uppercase tracking-[0.2em] mb-6">Délégué Identifié</h3>
                        
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-14 h-14 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-saemape-gold font-black text-xl shadow-inner">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-xs font-black uppercase leading-none">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] text-blue-300 font-bold mt-1">Représentant Légal</p>
                            </div>
                        </div>

                        <div class="space-y-4 border-t border-white/10 pt-6">
                            <div>
                                <p class="text-[9px] text-blue-300 font-black uppercase">Matricule Système</p>
                                <p class="font-mono text-sm font-bold text-white">{{ auth()->user()->matricule }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] text-blue-300 font-black uppercase">Statut de Session</p>
                                <p class="text-[10px] font-bold flex items-center gap-2">
                                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span> Authentifié
                                </p>
                            </div>
                        </div>

                        <p class="mt-10 text-[9px] text-blue-200 italic leading-relaxed opacity-60">
                            * Ces informations sont extraites de votre compte officiel. Elles seront liées de manière permanente à l'association.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- VUE : FICHE D'IDENTIFICATION VALIDÉE (Une fois identifiée) -->
        <div class="bg-white rounded-[3rem] shadow-2xl border-l-[16px] border-saemape-blue overflow-hidden animate-reveal">
            <div class="p-12 flex flex-col md:flex-row items-center gap-12">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1 bg-saemape-gold/20 text-saemape-gold text-[10px] font-black uppercase rounded-full tracking-widest border border-saemape-gold/30">
                            Entité Enregistrée
                        </span>
                        <span class="text-gray-300">/</span>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">ID #{{ str_pad($association->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    
                    <h1 class="text-5xl font-black text-saemape-blue leading-tight mb-4">{{ $association->raison_sociale }}</h1>
                    <div class="flex items-center gap-6">
                        <p class="text-sm font-black text-gray-500 uppercase tracking-tighter bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                            RCCM : <span class="text-saemape-red">{{ $association->num_rccm }}</span>
                        </p>
                        <p class="text-sm font-bold text-gray-400">
                            Depuis le {{ \Carbon\Carbon::parse($association->date_creation)->format('d/m/Y') }}
                        </p>
                    </div>
                </div>

                <div class="w-full md:w-auto">
                    <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 flex flex-col items-center text-center min-w-[250px]">
                        <div class="w-20 h-20 bg-saemape-blue rounded-2xl flex items-center justify-center text-white font-black text-3xl shadow-xl mb-4">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Délégué Responsable</p>
                        <h4 class="text-lg font-black text-saemape-blue">{{ auth()->user()->name }}</h4>
                        <p class="text-xs font-mono font-bold text-saemape-red mt-1">{{ auth()->user()->matricule }}</p>
                    </div>
                </div>
            </div>

            <!-- Footer de la fiche -->
            <div class="bg-saemape-blue/5 px-12 py-4 flex justify-between items-center border-t border-saemape-blue/10">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-orange-500 rounded-full"></span>
                        <span class="text-[10px] font-black uppercase text-orange-600">{{ $association->statut }}</span>
                    </div>
                    <span class="text-gray-300">|</span>
                    <p class="text-[10px] font-bold text-gray-500 italic">Dossier en cours de vérification par les services de l'Agent SAEMAPE.</p>
                </div>
                <img src="{{ asset('images/saemape.png') }}" class="h-8 opacity-20 grayscale" alt="">
            </div>
        </div>
    @endif
</div>