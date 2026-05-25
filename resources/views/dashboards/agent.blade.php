<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 bg-saemape-blue/10 text-saemape-blue text-[10px] font-black uppercase rounded-lg border border-saemape-blue/20">Service d'Encadrement</span>
            <h2 class="font-bold text-xl text-saemape-blue leading-tight">Poste de Gestion Opérationnelle</h2>
        </div>
    </x-slot>

    <div class="py-8 px-4 space-y-8 max-w-7xl mx-auto">
        
        <!-- SECTION 1 : BANNIÈRE D'HOMOLOGATION (L'IMAGE DU MÉTIER) -->
        <div class="relative bg-gradient-to-br from-slate-900 via-saemape-blue to-blue-900 p-10 rounded-[3rem] shadow-2xl overflow-hidden border-b-8 border-saemape-gold">
            <!-- Effet de fond : Sceau et sécurité -->
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <i class="fas fa-user-check text-[18rem] -rotate-12"></i>
            </div>
            
            <div class="relative z-10 grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-saemape-gold text-blue-900 rounded-full text-[9px] font-black uppercase tracking-widest">
                        <i class="fas fa-shield-alt"></i> Agent de l'État Authentifié
                    </div>
                    <h3 class="text-white text-4xl font-black leading-tight">
                        Vérification & <br> <span class="text-saemape-gold">Homologation</span>
                    </h3>
                    <p class="text-blue-100 text-sm font-medium leading-relaxed max-w-md italic">
                        "En tant qu'agent, votre signature digitale valide la conformité des flux miniers et garantit la traçabilité des recettes du Haut-Lomami."
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('gestion.associations.index') }}" class="px-6 py-3 bg-saemape-gold text-blue-900 rounded-xl font-black text-xs uppercase hover:bg-white transition-all shadow-lg flex items-center gap-2">
                            <i class="fas fa-folder-tree"></i> Registre Associations
                        </a>
                        <a href="{{ route('gestion.productions.index') }}" class="px-6 py-3 bg-white/10 text-white border border-white/20 rounded-xl font-black text-xs uppercase hover:bg-white hover:text-saemape-blue transition-all backdrop-blur-sm flex items-center gap-2">
                            <i class="fas fa-cash-register"></i> Caisse & Flux
                        </a>
                    </div>
                </div>

                <!-- Missions détaillées (Effet de carte imbriquée) -->
                <div class="bg-white/5 backdrop-blur-md rounded-[2rem] p-6 border border-white/10 space-y-4">
                    <h4 class="text-xs font-black text-saemape-gold uppercase tracking-widest mb-4">Protocole de Vérification</h4>
                    <div class="flex items-start gap-4 p-3 bg-white/5 rounded-2xl">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-xs font-black">01</div>
                        <p class="text-[11px] text-gray-300">Examen de la conformité juridique des certificats **RCCM** soumis.</p>
                    </div>
                    <div class="flex items-start gap-4 p-3 bg-white/5 rounded-2xl">
                        <div class="w-8 h-8 bg-saemape-red rounded-lg flex items-center justify-center text-xs font-black">02</div>
                        <p class="text-[11px] text-gray-300">Calcul et validation des **quittances de cotisation** sur les minerais.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2 : CENTRE DE CONTRÔLE (STATS & EFFECTIFS) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Carte : Files d'attente -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100 group hover:border-saemape-red transition-all">
                <div class="flex justify-between items-center mb-4">
                    <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-saemape-red">
                        <i class="fas fa-clock text-xl animate-pulse"></i>
                    </div>
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[9px] font-black uppercase">Urgent</span>
                </div>
                <h4 class="text-4xl font-black text-saemape-blue">{{ \App\Models\Declaration::where('statut', 'en_attente')->count() }}</h4>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">Productions à valider</p>
                <div class="mt-4 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-saemape-red animate-pulse" style="width: 70%;"></div>
                </div>
            </div>

            <!-- Carte : Associations en attente -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100 group hover:border-saemape-gold transition-all">
                <div class="flex justify-between items-center mb-4">
                    <div class="w-12 h-12 bg-yellow-50 rounded-2xl flex items-center justify-center text-saemape-gold">
                        <i class="fas fa-id-card text-xl"></i>
                    </div>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[9px] font-black uppercase">Dossiers</span>
                </div>
                <h4 class="text-4xl font-black text-saemape-blue">{{ \App\Models\Association::where('statut', 'en_attente')->count() }}</h4>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">Nouvelles Identifications</p>
            </div>

            <!-- Carte : Volume du jour (Recettes) -->
            <div class="bg-saemape-blue p-8 rounded-[2.5rem] shadow-xl text-white relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex justify-between items-center mb-4">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-saemape-gold">
                            <i class="fas fa-coins text-xl"></i>
                        </div>
                    </div>
                    <h4 class="text-3xl font-black">{{ number_format(\App\Models\Declaration::where('statut', 'payé')->whereDate('date_paiement', today())->sum('montant_cotisation'), 2) }} <span class="text-sm font-normal">USD</span></h4>
                    <p class="text-[10px] font-bold text-blue-200 uppercase tracking-widest mt-1">Recettes perçues aujourd'hui</p>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10 rotate-12">
                    <i class="fas fa-chart-line text-8xl"></i>
                </div>
            </div>
        </div>

        <!-- SECTION 3 : INDICATEURS TECHNIQUES (EFFECTIFS / VOLUMES) -->
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                <div>
                    <h3 class="text-sm font-black text-saemape-blue uppercase tracking-widest">Activité Récente du Bureau</h3>
                    <p class="text-[9px] text-gray-400 font-bold uppercase mt-1">Monitoring des transactions validées par les services</p>
                </div>
                <i class="fas fa-database text-gray-200"></i>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase mb-2">Cuivre (T)</p>
                        <p class="text-xl font-black text-saemape-blue">{{ \App\Models\Declaration::where('qualite_minerai', 'Cuivre')->sum('quantite_produite') }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase mb-2">Cobalt (T)</p>
                        <p class="text-xl font-black text-saemape-blue">{{ \App\Models\Declaration::where('qualite_minerai', 'Cobalt')->sum('quantite_produite') }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase mb-2">Or (Kg)</p>
                        <p class="text-xl font-black text-saemape-blue">{{ \App\Models\Declaration::where('qualite_minerai', 'Or')->sum('quantite_produite') }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase mb-2">Taux Validation</p>
                        <p class="text-xl font-black text-green-600">92%</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>