<?php

use App\Models\Association;
use Livewire\Volt\Component;

new class extends Component {
    public $num_rccm, $raison_sociale, $date_creation, $localite;

    public function register()
    {
        $this->validate([
            'num_rccm' => 'required|unique:associations,num_rccm',
            'raison_sociale' => 'required|min:5',
            'date_creation' => 'required|date',
            'localite' => 'required',
        ]);

        Association::create([
            'num_rccm' => $this->num_rccm,
            'raison_sociale' => $this->raison_sociale,
            'date_creation' => $this->date_creation,
            'localite' => $this->localite,
            'user_id' => auth()->id(),
        ]);

        session()->flash('message', 'Association enregistrée avec succès ! Elle est en attente de validation par un Agent SAEMAPE.');
        $this->reset();
    }
}; ?>

<div class="max-w-2xl mx-auto">
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-500 text-white rounded-2xl font-bold shadow-lg animate-bounce">
            <i class="fas fa-check-circle mr-2"></i> {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-2xl border-t-8 border-saemape-gold overflow-hidden">
        <div class="p-10">
            <h2 class="text-2xl font-black text-saemape-blue uppercase mb-2">Identification Administrative</h2>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-8">Soumission des informations au SAEMAPE HL</p>

            <form wire:submit.prevent="register" class="space-y-6">
                <div>
                    <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest ml-2">Numéro RCCM Officiel</label>
                    <input wire:model="num_rccm" type="text" placeholder="Ex: CD/KMN/RCCM/24-B-001" class="w-full rounded-2xl border-gray-100 bg-gray-50 py-4 font-bold text-sm focus:ring-saemape-gold">
                    @error('num_rccm') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest ml-2">Raison Sociale</label>
                    <input wire:model="raison_sociale" type="text" placeholder="Nom complet de l'association" class="w-full rounded-2xl border-gray-100 bg-gray-50 py-4 font-bold text-sm focus:ring-saemape-gold">
                    @error('raison_sociale') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest ml-2">Date de Création</label>
                        <input wire:model="date_creation" type="date" class="w-full rounded-2xl border-gray-100 bg-gray-50 py-4 font-bold text-sm">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest ml-2">Localité</label>
                        <input wire:model="localite" type="text" placeholder="Ex: Kamina Ville" class="w-full rounded-2xl border-gray-100 bg-gray-50 py-4 font-bold text-sm">
                    </div>
                </div>

                <button type="submit" class="w-full bg-saemape-blue text-white py-5 rounded-2xl font-black text-xs uppercase shadow-xl hover:bg-blue-900 transition-all flex items-center justify-center gap-3">
                    <i class="fas fa-save text-saemape-gold"></i> ENREGISTRER L'ASSOCIATION
                </button>
            </form>
        </div>
    </div>
</div>