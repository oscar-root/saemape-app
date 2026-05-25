<?php

use App\Models\Association;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public function validateAssociation($id)
    {
        $assoc = Association::findOrFail($id);
        $assoc->update(['statut' => 'valide']);
        session()->flash('assoc_msg', "L'association {$assoc->raison_sociale} a été officiellement inscrite au registre.");
    }

    public function with(): array
    {
        return [
            'associations' => Association::with('delegue')->latest()->paginate(10),
        ];
    }
}; ?>

<div class="space-y-6">
    @if (session('assoc_msg'))
        <div class="p-4 bg-saemape-blue text-white rounded-2xl font-bold shadow-lg animate-fade-in">
            <i class="fas fa-check-circle text-saemape-gold mr-2"></i> {{ session('assoc_msg') }}
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8 bg-gradient-to-r from-saemape-blue to-blue-900 text-white flex justify-between items-center">
            <div>
                <h2 class="text-xl font-black uppercase tracking-tight">Registre des Associations</h2>
                <p class="text-[10px] text-blue-200 font-bold uppercase mt-1 tracking-widest">Vérification et Homologation Administrative</p>
            </div>
            <i class="fas fa-id-card-clip text-3xl opacity-20"></i>
        </div>

        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 text-[10px] font-black uppercase text-gray-400 tracking-widest">
                    <th class="px-8 py-4">RCCM / Raison Sociale</th>
                    <th class="px-8 py-4">Délégué Responsable</th>
                    <th class="px-8 py-4">Date Identification</th>
                    <th class="px-8 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($associations as $assoc)
                <tr class="hover:bg-gray-50/50 transition-all">
                    <td class="px-8 py-5">
                        <div class="font-black text-saemape-blue text-sm">{{ $assoc->raison_sociale }}</div>
                        <div class="text-[10px] font-mono font-bold text-saemape-red uppercase">{{ $assoc->num_rccm }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="text-xs font-bold text-gray-700">{{ $assoc->delegue->name }}</div>
                        <div class="text-[10px] text-gray-400 font-medium">Mat: {{ $assoc->delegue->matricule }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-[10px] font-black text-gray-400 uppercase">{{ $assoc->created_at->format('d/m/Y') }}</span>
                    </td>
                    <td class="px-8 py-5 text-right">
                        @if($assoc->statut === 'en_attente')
                            <button wire:click="validateAssociation({{ $assoc->id }})" 
                                    class="bg-saemape-gold text-blue-900 px-4 py-2 rounded-xl text-[9px] font-black uppercase hover:scale-105 transition-all shadow-md">
                                Inscrire au Registre
                            </button>
                        @else
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-[9px] font-black uppercase">
                                <i class="fas fa-check mr-1"></i> Validé
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>