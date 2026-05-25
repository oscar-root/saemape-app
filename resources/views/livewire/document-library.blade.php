<?php

use App\Models\Association;
use App\Models\Declaration;
use Livewire\Volt\Component;

new class extends Component {
    public $association;

    public function mount()
    {
        // On récupère l'association liée au délégué connecté
        $this->association = auth()->user()->association;
    }

    public function with(): array
    {
        return [
            // On récupère toutes les déclarations de l'association (le cas échéant)
            'declarations' => $this->association 
                ? $this->association->declarations()->latest()->get() 
                : collect([]),
        ];
    }
}; ?>

<div class="max-w-7xl mx-auto space-y-8 animate-reveal">
    <!-- BANNIÈRE D'EN-TÊTE -->
    <div class="relative bg-saemape-blue p-8 rounded-[2.5rem] shadow-2xl overflow-hidden border-b-4 border-saemape-gold">
        <!-- Déco Arrière-plan -->
        <div class="absolute top-0 right-0 p-4 opacity-10">
            <i class="fas fa-file-invoice-dollar text-[12rem] -rotate-12"></i>
        </div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-6">
                <div class="bg-white p-3 rounded-2xl shadow-xl">
                    <img src="{{ asset('images/saemape.png') }}" class="h-16 w-auto" alt="Logo">
                </div>
                <div>
                    <h2 class="text-3xl font-black text-white uppercase tracking-tight">Ma Bibliothèque Numérique</h2>
                    <p class="text-blue-200 font-bold uppercase text-[10px] tracking-[0.3em] mt-1">Archives Officielles SAEMAPE Haut-Lomami</p>
                </div>
            </div>
            @if($association)
                <div class="text-right">
                    <span class="text-[10px] font-black text-saemape-gold uppercase block mb-1">Entité Représentée</span>
                    <span class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl text-white font-bold text-sm border border-white/20">
                        {{ $association->raison_sociale }}
                    </span>
                </div>
            @endif
        </div>
    </div>

    @if(!$association)
        <!-- ÉTAT VIDE : AUCUNE ASSOCIATION -->
        <div class="bg-white p-20 rounded-[3rem] shadow-xl text-center border-2 border-dashed border-gray-100">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-200">
                <i class="fas fa-folder-open text-5xl"></i>
            </div>
            <h3 class="text-2xl font-black text-gray-400 uppercase">Aucun document archivé</h3>
            <p class="text-gray-400 mt-2 max-w-sm mx-auto">Veuillez d'abord procéder à l'identification de votre association pour générer vos certificats officiels.</p>
            <a href="{{ route('delegue.association.create') }}" class="mt-8 inline-flex items-center gap-3 px-8 py-4 bg-saemape-blue text-white rounded-2xl font-black text-xs uppercase hover:bg-blue-900 transition-all shadow-lg">
                <i class="fas fa-plus-circle text-saemape-gold"></i> S'identifier maintenant
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- SECTION 1 : CERTIFICAT D'IDENTIFICATION -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 ml-4">
                    <span class="w-2 h-2 bg-saemape-gold rounded-full"></span>
                    <h3 class="text-[10px] font-black text-saemape-blue uppercase tracking-widest">Identité Juridique</h3>
                </div>
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-50 group hover:border-saemape-blue transition-all relative overflow-hidden">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center text-saemape-blue mb-6 group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-certificate text-3xl"></i>
                        </div>
                        <h4 class="text-lg font-black text-gray-900 leading-tight mb-2">Certificat d'Identification</h4>
                        <p class="text-xs text-gray-400 font-medium mb-8">Document prouvant l'enregistrement de l'entité au registre provincial du SAEMAPE.</p>
                        
                        <a href="{{ route('download.identification', $association->id) }}" target="_blank" 
                           class="w-full py-4 bg-saemape-blue text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-blue-900/20 hover:bg-saemape-gold hover:text-blue-900 transition-all flex items-center justify-center gap-3">
                            <i class="fas fa-file-pdf text-base"></i> Visualiser le Certificat
                        </a>
                    </div>
                </div>
            </div>

            <!-- SECTION 2 : BULLETINS DE DÉCLARATION (PRODUCTION) -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center gap-2 ml-4">
                    <span class="w-2 h-2 bg-saemape-red rounded-full"></span>
                    <h3 class="text-[10px] font-black text-saemape-blue uppercase tracking-widest">Suivi des Flux de Production</h3>
                </div>
                
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-50 overflow-hidden">
                    @if($declarations->isEmpty())
                        <div class="p-20 text-center text-gray-400 italic font-medium text-sm">
                            Aucune production déclarée à ce jour.
                        </div>
                    @else
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr class="text-[9px] font-black text-gray-400 uppercase tracking-widest">
                                    <th class="px-8 py-5">Référence Flux</th>
                                    <th class="px-8 py-5">Spécifications</th>
                                    <th class="px-8 py-5">Statut</th>
                                    <th class="px-8 py-5 text-right">PDF</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($declarations as $dec)
                                <tr class="group hover:bg-blue-50/30 transition-all">
                                    <td class="px-8 py-5">
                                        <div class="font-black text-saemape-blue text-sm">#DEC-{{ str_pad($dec->id, 4, '0', STR_PAD_LEFT) }}</div>
                                        <div class="text-[10px] font-bold text-gray-400 mt-1 uppercase">{{ $dec->created_at->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-black text-gray-800 uppercase">{{ $dec->qualite_minerai }}</span>
                                            <span class="px-2 py-0.5 bg-red-50 text-saemape-red text-[10px] font-black rounded">{{ $dec->quantite_produite }}T</span>
                                        </div>
                                        <div class="text-[9px] font-bold text-gray-400 uppercase mt-1">{{ $dec->localite }}</div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-tighter
                                            {{ $dec->statut === 'payé' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-600' }}">
                                            {{ $dec->statut }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <a href="{{ route('download.declaration', $dec->id) }}" target="_blank" 
                                           class="inline-flex w-10 h-10 bg-gray-50 text-gray-400 items-center justify-center rounded-xl group-hover:bg-saemape-gold group-hover:text-blue-900 transition-all">
                                            <i class="fas fa-file-lines text-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <!-- SECTION 3 : REÇUS DE CAISSE (FINANCES) -->
            <div class="lg:col-span-3 pt-6 space-y-4">
                <div class="flex items-center gap-2 ml-4">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    <h3 class="text-[10px] font-black text-saemape-blue uppercase tracking-widest">Preuves de Paiement (Caisse)</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @forelse($declarations->where('statut', 'payé') as $pay)
                        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border-l-[12px] border-green-500 flex flex-col justify-between group hover:-translate-y-1 transition-all">
                            <div>
                                <div class="flex justify-between items-start mb-4">
                                    <div class="px-3 py-1 bg-green-50 text-green-700 text-[9px] font-black uppercase rounded-lg border border-green-100">Transaction Validée</div>
                                    <i class="fas fa-receipt text-green-200 text-2xl"></i>
                                </div>
                                <h4 class="text-3xl font-black text-saemape-blue mb-1 leading-none">
                                    {{ number_format($pay->montant_cotisation, 2) }} <span class="text-xs text-gray-400">USD</span>
                                </h4>
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-2 italic">
                                    Cotisation pour production #{{ $pay->id }}
                                </p>
                            </div>
                            
                            <a href="{{ route('download.receipt', $pay->id) }}" target="_blank" 
                               class="mt-8 flex items-center justify-center gap-3 py-3.5 bg-gray-900 text-white rounded-2xl font-black text-[10px] uppercase hover:bg-saemape-gold hover:text-blue-900 transition-all shadow-lg group-hover:shadow-saemape-gold/20">
                                <i class="fas fa-print text-sm"></i> Télécharger le Reçu
                            </a>
                        </div>
                    @empty
                        <div class="md:col-span-3 p-12 bg-gray-50/50 rounded-[3rem] text-center border-2 border-dashed border-gray-200">
                             <i class="fas fa-cash-register text-gray-200 text-4xl mb-4"></i>
                             <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">Aucun reçu de caisse disponible. Le service financier doit valider vos paiements.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>