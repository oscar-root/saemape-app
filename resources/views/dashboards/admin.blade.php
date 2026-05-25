<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 bg-red-600/10 text-saemape-red text-[10px] font-black uppercase rounded-lg border border-saemape-red/20">Administration Système</span>
            <h2 class="font-bold text-xl text-saemape-blue leading-tight uppercase tracking-tighter">Console de Supervision</h2>
        </div>
    </x-slot>

    <div class="py-8 px-4 space-y-8 max-w-7xl mx-auto">
        
        <!-- SECTION 1 : ÉTAT DE SANTÉ DU SYSTÈME (Effet Néon discret) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-slate-900 p-4 rounded-2xl border border-white/5 flex items-center gap-4 shadow-xl">
                <div class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-500 uppercase">Base de données</p>
                    <p class="text-xs font-bold text-white">OPÉRATIONNELLE</p>
                </div>
            </div>
            <div class="bg-slate-900 p-4 rounded-2xl border border-white/5 flex items-center gap-4 shadow-xl">
                <i class="fas fa-shield-halved text-saemape-gold text-lg"></i>
                <div>
                    <p class="text-[9px] font-black text-gray-500 uppercase">Sécurité SSL</p>
                    <p class="text-xs font-bold text-white">ACTIVÉE (AES-256)</p>
                </div>
            </div>
            <div class="bg-slate-900 p-4 rounded-2xl border border-white/5 flex items-center gap-4 shadow-xl">
                <i class="fas fa-server text-blue-400 text-lg"></i>
                <div>
                    <p class="text-[9px] font-black text-gray-500 uppercase">Charge Serveur</p>
                    <p class="text-xs font-bold text-white">STABLE (12%)</p>
                </div>
            </div>
            <div class="bg-slate-900 p-4 rounded-2xl border border-white/5 flex items-center gap-4 shadow-xl">
                <i class="fas fa-sync fa-spin text-saemape-red text-lg"></i>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase">Version</p>
                    <p class="text-xs font-bold text-white">SAEMAPE HL v1.0</p>
                </div>
            </div>
        </div>

        <!-- SECTION 2 : BANNIÈRE DE GESTION TECHNIQUE -->
        <div class="relative bg-gradient-to-br from-saemape-blue via-slate-900 to-black p-10 rounded-[3rem] shadow-2xl overflow-hidden border-b-8 border-saemape-gold">
            <!-- Filigrane technique -->
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <i class="fas fa-cogs text-[20rem] rotate-12"></i>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-12">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-3 px-4 py-2 rounded-xl bg-white/5 border border-white/10 backdrop-blur-md">
                        <i class="fas fa-user-shield text-saemape-gold"></i>
                        <span class="text-xs font-black text-white uppercase tracking-widest">Privilèges Super-Utilisateur</span>
                    </div>
                    
                    <h3 class="text-white text-5xl font-black leading-none tracking-tighter">
                        Contrôle <br> <span class="text-saemape-gold italic">Centralisé</span>
                    </h3>
                    
                    <p class="text-blue-100 text-lg max-w-lg font-medium opacity-80 border-l-4 border-saemape-red pl-6">
                        "Maîtrisez les accès, configurez les comptes agents et assurez l'intégrité du registre minier provincial."
                    </p>

                    <div class="flex gap-4">
                        <a href="{{ route('admin.users.index') }}" class="px-8 py-4 bg-saemape-gold text-blue-900 rounded-2xl font-black text-xs uppercase hover:scale-105 transition-all shadow-xl flex items-center gap-3">
                            <i class="fas fa-users-gear text-lg"></i> Gérer les Utilisateurs
                        </a>
                        
                    </div>
                </div>

                <!-- Visualisation rapide de la structure (Acteurs Chap.3) -->
                <div class="hidden lg:block bg-white/5 backdrop-blur-xl p-8 rounded-[2.5rem] border border-white/10 w-80">
                    <h4 class="text-[10px] font-black text-saemape-gold uppercase tracking-[0.2em] mb-6">Répartition des comptes</h4>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-400 font-bold">Agents SAEMAPE</span>
                            <span class="font-black text-white">{{ \App\Models\User::where('role', 'agent')->count() }}</span>
                        </div>
                        <div class="w-full bg-white/10 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full" style="width: 45%"></div>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-400 font-bold">Délégués Associés</span>
                            <span class="font-black text-white">{{ \App\Models\User::where('role', 'delegue')->count() }}</span>
                        </div>
                        <div class="w-full bg-white/10 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-saemape-gold h-full" style="width: 70%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3 : INDICATEURS DE CHARGE (Cartes Attrayantes) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Utilisateurs -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100 group hover:-translate-y-2 transition-all duration-300">
                <div class="flex justify-between items-center mb-6">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-saemape-blue group-hover:bg-saemape-blue group-hover:text-white transition-all">
                        <i class="fas fa-users-viewfinder text-2xl"></i>
                    </div>
                    <span class="text-[9px] font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase">Actifs</span>
                </div>
                <h4 class="text-4xl font-black text-slate-900">{{ \App\Models\User::count() }}</h4>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Total Utilisateurs</p>
            </div>

            <!-- Associations -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100 group hover:-translate-y-2 transition-all duration-300">
                <div class="flex justify-between items-center mb-6">
                    <div class="w-14 h-14 bg-yellow-50 rounded-2xl flex items-center justify-center text-saemape-gold group-hover:bg-saemape-gold group-hover:text-blue-900 transition-all">
                        <i class="fas fa-building-shield text-2xl"></i>
                    </div>
                    <span class="text-[9px] font-black text-saemape-gold bg-yellow-50 px-3 py-1 rounded-full uppercase">Homologuées</span>
                </div>
                <h4 class="text-4xl font-black text-slate-900">{{ \App\Models\Association::count() }}</h4>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Associations Enregistrées</p>
            </div>

            <!-- Alertes Système -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100 group hover:-translate-y-2 transition-all duration-300">
                <div class="flex justify-between items-center mb-6">
                    <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-saemape-red group-hover:bg-saemape-red group-hover:text-white transition-all">
                        <i class="fas fa-triangle-exclamation text-2xl"></i>
                    </div>
                    <span class="text-[9px] font-black text-red-600 bg-red-50 px-3 py-1 rounded-full uppercase">Incidents</span>
                </div>
                <h4 class="text-4xl font-black text-slate-900">0</h4>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Alertes de Sécurité</p>
            </div>
        </div>

    </div>
</x-app-layout>