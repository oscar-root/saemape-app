<?php

use App\Models\Declaration;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    // Action : Valider le paiement et générer le reçu
    public function validatePayment($id)
    {
        $declaration = Declaration::find($id);
        
        $declaration->update([
            'statut' => 'payé', // Le statut passe de 'en_attente' à 'payé'
            'date_paiement' => now(),
        ]);

        session()->flash('message', 'Paiement validé pour l\'association ' . $declaration->association->raison_sociale . '. Le reçu est désormais disponible.');
    }

    public function with(): array
    {
        return [
            // On ne montre que les productions qui attendent un paiement
            'pendingDeclarations' => Declaration::where('statut', 'en_attente')->latest()->paginate(10),
        ];
    }
}; ?>

<div class="space-y-6">
    @if (session('message'))
        <div class="p-4 bg-green-500 text-white rounded-2xl font-bold shadow-lg animate-bounce">
            <i class="fas fa-check-circle mr-2"></i> {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8 bg-saemape-blue text-white flex justify-between items-center">
            <div>
                <h2 class="text-xl font-black uppercase tracking-tight">Validation des Cotisations</h2>
                <p class="text-[10px] text-blue-200 font-bold uppercase mt-1 tracking-widest">Service de la Caisse / Bureau Technique</p>
            </div>
            <i class="fas fa-cash-register text-3xl opacity-30"></i>
        </div>

        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 text-[10px] font-black uppercase text-gray-400 tracking-widest">
                    <th class="px-8 py-4">Association & Minerai</th>
                    <th class="px-8 py-4">Montant à Percevoir</th>
                    <th class="px-8 py-4">Détails</th>
                    <th class="px-8 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pendingDeclarations as $dec)
                    <tr class="hover:bg-gray-50/50 transition-all">
                        <td class="px-8 py-5">
                            <div class="font-black text-saemape-blue">{{ $dec->association->raison_sociale }}</div>
                            <div class="text-[10px] font-bold text-saemape-red uppercase">{{ $dec->qualite_minerai }} ({{ $dec->quantite_produite }} T)</div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-lg font-black text-gray-800">{{ number_format($dec->montant_cotisation, 2) }} USD</div>
                        </td>
                        <td class="px-8 py-5 text-[10px] text-gray-400 font-bold uppercase">
                            Soumis le {{ $dec->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button wire:click="validatePayment({{ $dec->id }})" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase shadow-lg transition-all">
                                Confirmer Paiement & Reçu
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center text-gray-400 font-bold italic">
                            Aucune déclaration en attente de paiement.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 bg-gray-50">
            {{ $pendingDeclarations->links() }}
        </div>
    </div>
</div>