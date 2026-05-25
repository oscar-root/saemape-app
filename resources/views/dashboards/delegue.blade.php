<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 bg-saemape-gold/20 text-saemape-gold text-[10px] font-black uppercase rounded-lg border border-saemape-gold/30">Espace Exploitant</span>
            <h2 class="font-bold text-xl text-saemape-blue leading-tight">Tableau de Bord Délégué</h2>
        </div>
    </x-slot>

    <div class="py-8 px-4">
        <div class="max-w-7xl mx-auto space-y-8">
            
            <!-- SECTION BIENVENUE : BANNIÈRE PREMIUM -->
            <div class="relative bg-gradient-to-br from-saemape-blue via-blue-900 to-black p-10 rounded-[3rem] shadow-2xl overflow-hidden border-b-8 border-saemape-red">
                <!-- Décoration en arrière-plan -->
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <i class="fas fa-gem text-[15rem] rotate-12 text-white"></i>
                </div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="space-y-4">
                        <h3 class="text-white text-4xl font-black leading-tight">
                            Heureux de vous revoir, <br>
                            <span class="text-saemape-gold italic">{{ auth()->user()->name }}</span>
                        </h3>
                        <p class="text-blue-200 text-lg max-w-lg font-medium">
                            "Votre contribution à la traçabilité minière du Haut-Lomami commence ici. Gérez vos flux en toute transparence."
                        </p>
                        <div class="flex items-center gap-4 text-xs font-bold text-white/60">
                            <span class="flex items-center gap-2"><i class="fas fa-id-badge text-saemape-gold"></i> {{ auth()->user()->matricule }}</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-white/20"></span>
                            <span class="flex items-center gap-2"><i class="fas fa-calendar-alt text-saemape-gold"></i> {{ date('d M Y') }}</span>
                        </div>
                    </div>

                    <!-- Badge Statut Association -->
                    @php $assoc = auth()->user()->association; @endphp
                    <div class="bg-white/5 backdrop-blur-xl p-6 rounded-3xl border border-white/10 text-center min-w-[200px]">
                        <p class="text-[10px] font-black text-saemape-gold uppercase tracking-widest mb-2">Statut Entité</p>
                        @if($assoc)
                            <div class="text-white font-black text-xl mb-1 uppercase tracking-tighter">{{ $assoc->statut }}</div>
                            <p class="text-[9px] text-blue-300 font-bold uppercase">{{ $assoc->num_rccm }}</p>
                        @else
                            <div class="text-saemape-red font-black text-sm uppercase animate-pulse">Non identifiée</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SECTION STATISTIQUES RAPIDES (Cartes animées) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Carte 1 -->
                <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-50 flex items-center gap-6 hover:scale-105 transition-transform duration-300">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-saemape-blue">
                        <i class="fas fa-truck-loading text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Productions</p>
                        <h4 class="text-2xl font-black text-saemape-blue">{{ $assoc ? $assoc->declarations->count() : 0 }}</h4>
                    </div>
                </div>
                <!-- Carte 2 -->
                <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-50 flex items-center gap-6 hover:scale-105 transition-transform duration-300">
                    <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-saemape-red">
                        <i class="fas fa-weight-hanging text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Poids Total (T)</p>
                        <h4 class="text-2xl font-black text-saemape-blue">{{ $assoc ? number_format($assoc->declarations->sum('quantite_produite'), 1) : '0' }}</h4>
                    </div>
                </div>
                <!-- Carte 3 -->
                <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-50 flex items-center gap-6 hover:scale-105 transition-transform duration-300">
                    <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600">
                        <i class="fas fa-receipt text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Cotisations (USD)</p>
                        <h4 class="text-2xl font-black text-saemape-blue">{{ $assoc ? number_format($assoc->declarations->where('statut', 'payé')->sum('montant_cotisation'), 2) : '0' }}</h4>
                    </div>
                </div>
            </div>

            <!-- ACTIONS RAPIDES (Grandes tuiles interactives) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Tuile Déclarer -->
                <a href="{{ route('delegue.production.create') }}" class="group relative bg-white p-8 rounded-[2.5rem] shadow-2xl overflow-hidden border-2 border-transparent hover:border-saemape-gold transition-all duration-500">
                    <div class="absolute top-0 right-0 p-8 text-gray-50 group-hover:text-saemape-gold/20 transition-colors">
                        <i class="fas fa-plus-circle text-8xl"></i>
                    </div>
                    <div class="relative z-10">
                        <h4 class="text-2xl font-black text-saemape-blue uppercase mb-2">Nouvelle Déclaration</h4>
                        <p class="text-gray-500 text-sm max-w-xs mb-6 font-medium">Soumettez vos flux de production pour obtenir vos bulletins techniques.</p>
                        <span class="inline-flex items-center gap-2 text-xs font-black text-saemape-gold uppercase tracking-widest group-hover:translate-x-2 transition-transform">
                            Lancer le formulaire <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>

                <!-- Tuile Documents -->
                <a href="{{ route('delegue.documents.index') }}" class="group relative bg-white p-8 rounded-[2.5rem] shadow-2xl overflow-hidden border-2 border-transparent hover:border-saemape-blue transition-all duration-500">
                    <div class="absolute top-0 right-0 p-8 text-gray-50 group-hover:text-saemape-blue/20 transition-colors">
                        <i class="fas fa-file-invoice text-8xl"></i>
                    </div>
                    <div class="relative z-10">
                        <h4 class="text-2xl font-black text-saemape-blue uppercase mb-2">Mes Documents PDF</h4>
                        <p class="text-gray-500 text-sm max-w-xs mb-6 font-medium">Accédez à vos certificats d'identification et reçus de caisse certifiés.</p>
                        <span class="inline-flex items-center gap-2 text-xs font-black text-saemape-blue uppercase tracking-widest group-hover:translate-x-2 transition-transform">
                            Ouvrir les archives <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>