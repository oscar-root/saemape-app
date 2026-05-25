<?php

use App\Models\Declaration;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public function with(): array
    {
        return [
            // On ne montre que les paiements effectués
            'payments' => Declaration::where('statut', 'payé')->with('association')->latest()->paginate(10),
            'total_percu' => Declaration::where('statut', 'payé')->sum('montant_cotisation')
        ];
    }
}; ?>

<div class="space-y-6">
    <!-- Résumé financier rapide -->
    <div class="bg-saemape-gold p-6 rounded-3xl shadow-xl flex justify-between items-center text-blue-900">
        <div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em]">Total Recettes (Caisse)</p>
            <h3 class="text-3xl font-black">{{ number_format($total_percu, 2) }} USD</h3>
        </div>
        <i class="fas fa-vault text-4xl opacity-20"></i>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-black text-saemape-blue uppercase tracking-tight">Journal des Encaissements</h2>
            <!-- le bouton Exporter Rapport  -->
            <a href="{{ route('download.payment-report') }}" target="_blank" 
            class="px-4 py-2 bg-saemape-red text-white rounded-xl text-[10px] font-black uppercase shadow-lg hover:bg-red-700 transition-all flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Exporter Rapport Analytique
            </a>
        </div>

        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 text-[9px] font-black uppercase text-gray-400 tracking-widest">
                    <th class="px-8 py-4">N° Quittance</th>
                    <th class="px-8 py-4">Association</th>
                    <th class="px-8 py-4">Montant Versé</th>
                    <th class="px-8 py-4">Date de Paiement</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($payments as $pay)
                <tr class="text-sm font-medium">
                    <td class="px-8 py-5 text-saemape-blue font-bold">#REC-{{ $pay->id }}</td>
                    <td class="px-8 py-5">{{ $pay->association->raison_sociale }}</td>
                    <td class="px-8 py-5 font-black text-green-600">{{ number_format($pay->montant_cotisation, 2) }} $</td>
                    <td class="px-8 py-5 text-gray-500">{{ $pay->date_paiement->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>