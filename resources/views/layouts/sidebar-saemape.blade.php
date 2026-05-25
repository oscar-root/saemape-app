<aside class="w-64 bg-saemape-blue text-white flex flex-col h-screen sticky top-0 shadow-2xl overflow-hidden border-r border-white/10">
    <div class="p-6 bg-gradient-to-b from-black/20 to-transparent border-b border-white/5 flex flex-col items-center">
        <div class="relative group">
            <img src="{{ asset('images/saemape.png') }}" class="relative h-16 w-auto mb-3" alt="Logo">
        </div>
        <p class="text-[10px] font-black text-saemape-gold uppercase tracking-[0.3em]">Haut-Lomami</p>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar">
        <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="fas fa-th-large" wire:navigate>
            Tableau de Bord
        </x-sidebar-link>

        <div class="my-6 border-t border-white/5"></div>

        <!-- 1. DÉLÉGUÉ -->
        @if(auth()->user()->role === 'delegue')
            <x-sidebar-link :href="route('delegue.association.create')" icon="fas fa-id-card" wire:navigate>Mon Association</x-sidebar-link>
            <x-sidebar-link :href="route('delegue.production.create')" icon="fas fa-gem" wire:navigate>Déclarer Production</x-sidebar-link>
            <x-sidebar-link :href="route('delegue.documents.index')" icon="fas fa-file-invoice" wire:navigate>Mes Documents</x-sidebar-link>
        @endif

        <!-- 2. AGENT -->
        @if(auth()->user()->role === 'agent')
            <x-sidebar-link :href="route('gestion.associations.index')" icon="fas fa-folder-tree" wire:navigate>Associations</x-sidebar-link>
            <x-sidebar-link :href="route('gestion.productions.index')" icon="fas fa-truck-ramp-box" wire:navigate>Suivi Productions</x-sidebar-link>
            <x-sidebar-link :href="route('gestion.payments.index')" icon="fas fa-cash-register" wire:navigate>Cotisations</x-sidebar-link>
        @endif

        <!-- 3. DIRECTION (CORRIGÉ : Rôle 'dipro') -->
        @if(auth()->user()->role === 'dipro')
            <div class="px-4 mb-2">
                <span class="text-[10px] text-blue-300 font-black uppercase tracking-widest opacity-60">Direction</span>
            </div>
            <x-sidebar-link :href="route('dipro.rapports')" :active="request()->routeIs('dipro.rapports')" icon="fas fa-file-contract" wire:navigate>
                Rapports Analytiques
            </x-sidebar-link>
            <x-sidebar-link :href="route('dipro.stats')" :active="request()->routeIs('dipro.stats')" icon="fas fa-chart-line" wire:navigate>
                Statistiques
            </x-sidebar-link>
        @endif

        <!-- 4. ADMIN -->
        @if(auth()->user()->role === 'admin')
            <x-sidebar-link :href="route('admin.users.index')" icon="fas fa-users-gear" wire:navigate>Utilisateurs</x-sidebar-link>
        @endif
    </nav>
    
    <div class="p-4 bg-black/10 border-t border-white/5">
        <div class="mb-4 px-2">
            <div class="text-[10px] text-saemape-gold font-bold uppercase">{{ auth()->user()->name }}</div>
            <div class="text-[8px] text-white/40 font-mono italic">{{ auth()->user()->matricule }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-saemape-red/10 hover:bg-saemape-red text-saemape-red hover:text-white rounded-xl font-black text-xs uppercase transition-all duration-300">
                <i class="fas fa-power-off"></i> Déconnexion
            </button>
        </form>
    </div>
</aside>