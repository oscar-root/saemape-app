<?php

use App\Models\Declaration;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $search = '';

    // Action de l'Agent : Valider le paiement
    public function markAsPaid($id)
    {
        $declaration = Declaration::findOrFail($id);
        
        $declaration->update([
            'statut' => 'payé',
            'date_paiement' => now()
        ]);

        session()->flash('success', "Paiement de {$declaration->montant_cotisation} USD validé pour {$declaration->association->raison_sociale}. Reçu généré.");
    }

    public function with(): array
    {
        return [
            'declarations' => Declaration::with('association')
                ->whereHas('association', function($q) {
                    $q->where('raison_sociale', 'like', '%' . $this->search . '%');
                })
                ->latest()
                ->paginate(10),
        ];
    }
}; ?>

<div class="space-y-6">
    <!-- Barre de recherche -->
    <div class="flex justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <div class="relative w-1/3">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fas fa-search"></i>
            </span>
            <input wire:model.live="search" type="text" placeholder="Rechercher une association..." 
                   class="w-full pl-10 pr-4 py-2 rounded-xl border-none bg-gray-50 focus:ring-2 focus:ring-saemape-blue">
        </div>
        <div class="flex items-center gap-2 text-[10px] font-black uppercase text-gray-400 tracking-widest">
            <i class="fas fa-filter"></i> Suivi des Flux Techniques
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 bg-green-500 text-white rounded-2xl font-bold shadow-lg animate-fade-in-down">
            <i class="fas fa-check-double mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Table de Gestion -->
    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-saemape-blue/5 text-[10px] uppercase font-black tracking-[0.2em] text-saemape-blue">
                <tr>
                    <th class="px-8 py-5">Association / Délégué</th>
                    <th class="px-8 py-5">Minerai & Quantité</th>
                    <th class="px-8 py-5">Cotisation (USD)</th>
                    <th class="px-8 py-5">Statut</th>
                    <th class="px-8 py-5 text-right">Actions Agent</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($declarations as $dec)
                <tr class="hover:bg-gray-50/50 transition-all">
                    <td class="px-8 py-5">
                        <div class="font-black text-gray-900">{{ $dec->association->raison_sociale }}</div>
                        <div class="text-[10px] text-gray-400 font-bold uppercase mt-1">{{ $dec->association->delegue->name }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 bg-red-50 text-saemape-red text-[10px] font-black rounded uppercase border border-red-100">
                                {{ $dec->qualite_minerai }}
                            </span>
                            <span class="text-xs font-bold text-gray-600">{{ $dec->quantite_produite }} T</span>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="text-sm font-black text-saemape-blue">{{ number_format($dec->montant_cotisation, 2) }} $</div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter
                            {{ $dec->statut === 'payé' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-600' }}">
                            {{ $dec->statut }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-right">
                        @if($dec->statut === 'en_attente')
                            <button wire:click="markAsPaid({{ $dec->id }})" 
                                    class="px-4 py-2 bg-saemape-blue text-white rounded-xl text-[9px] font-black uppercase hover:bg-saemape-gold hover:text-blue-900 transition-all shadow-lg shadow-blue-900/20">
                                <i class="fas fa-cash-register mr-1"></i> Valider Paiement
                            </button>
                        @else
                            <div class="flex justify-end gap-2 text-green-600 font-black text-[10px] uppercase">
                                <i class="fas fa-check-circle"></i> Encaissé
                            </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-6 bg-gray-50/50">
            {{ $declarations->links() }}
        </div>
    </div>
</div>