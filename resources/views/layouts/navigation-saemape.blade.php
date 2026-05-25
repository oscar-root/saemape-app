<nav class="fixed top-0 w-full z-50 bg-gradient-to-r from-saemape-blue via-blue-800 to-saemape-blue shadow-2xl border-b-2 border-saemape-gold/30 backdrop-blur-sm bg-opacity-95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo amélioré avec animation -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group" wire:navigation>
                    <div class="relative">
                        <div class="absolute inset-0 bg-saemape-gold rounded-lg blur-md opacity-0 group-hover:opacity-50 transition-opacity duration-300"></div>
                        <div class="relative bg-gradient-to-br from-white to-gray-100 p-1.5 rounded-xl shadow-xl group-hover:shadow-2xl transition-all duration-300">
                            <img src="{{ asset('images/saemape.png') }}" class="h-12 w-auto transform group-hover:scale-105 transition-transform duration-300" alt="SAEMAPE">
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-black text-xl leading-none tracking-tighter group-hover:text-saemape-gold transition-colors duration-300">SAEMAPE</span>
                        <span class="text-saemape-gold text-[10px] font-black uppercase tracking-[0.2em]">Haut-Lomami</span>
                    </div>
                </a>

                <!-- Séparateur décoratif -->
                <div class="hidden sm:block h-12 w-px bg-gradient-to-b from-transparent via-saemape-gold to-transparent mx-6"></div>

                <!-- Liens de Navigation améliorés -->
                <div class="hidden space-x-1 sm:-my-px sm:ml-2 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="relative text-white hover:text-saemape-gold transition-all duration-300 px-4 py-2 rounded-lg hover:bg-white/10 group" wire:navigation>
                        <span class="relative z-10">{{ __('Tableau de bord') }}</span>
                    </x-nav-link>

                    @if(auth()->user()->role === 'delegue')
                        <x-nav-link :href="route('delegue.production.create')" :active="request()->routeIs('delegue.production.create')" class="relative text-white hover:text-saemape-gold transition-all duration-300 px-4 py-2 rounded-lg hover:bg-white/10 group" wire:navigation>
                            <span class="relative z-10">Déclarer Production</span>
                        </x-nav-link>
                        <x-nav-link :href="route('delegue.association.create')" :active="request()->routeIs('delegue.association.create')" class="relative text-white hover:text-saemape-gold transition-all duration-300 px-4 py-2 rounded-lg hover:bg-white/10 group" wire:navigation>
                            <span class="relative z-10">Mon Association</span>
                        </x-nav-link>
                    @endif

                    @if(in_array(auth()->user()->role, ['agent', 'admin', 'abt']))
                        <x-nav-link :href="route('gestion.associations.index')" :active="request()->routeIs('gestion.associations.index')" class="relative text-white hover:text-saemape-gold transition-all duration-300 px-4 py-2 rounded-lg hover:bg-white/10 group" wire:navigation>
                            <span class="relative z-10">Validation Dossiers</span>
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->role === 'dipro')
                        <x-nav-link :href="route('dipro.rapports')" :active="request()->routeIs('dipro.rapports')" class="relative text-white hover:text-saemape-gold transition-all duration-300 px-4 py-2 rounded-lg hover:bg-white/10 group" wire:navigation>
                            <span class="relative z-10">Rapports & Stats</span>
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="mr-4 text-right">
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] text-saemape-gold font-black uppercase tracking-[0.2em]">{{ auth()->user()->role }}</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                    </div>
                    <div class="text-sm text-white font-bold leading-tight">{{ auth()->user()->name }}</div>
                </div>
                
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="relative group flex text-sm border-2 border-saemape-gold rounded-full focus:outline-none transition-all duration-300 hover:scale-105">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-saemape-gold to-yellow-600 flex items-center justify-center text-saemape-blue font-black shadow-inner">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                            <div class="text-xs text-gray-400 font-bold uppercase tracking-widest">Matricule</div>
                            <div class="text-sm text-saemape-blue font-black">{{ auth()->user()->matricule }}</div>
                        </div>

                        <!-- Correction de la route Profile -->
                        <x-dropdown-link :href="route('profile.edit')" wire:navigation>
                            {{ __('Mon Profil') }}
                        </x-dropdown-link>

                        <!-- Bloc Déconnexion Corrigé -->
                        <form method="POST" action="{{ route('logout') }}" wire:navigation>
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm leading-5 text-red-600 font-bold hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    {{ __('Déconnexion') }}
                                </div>
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
    
    <!-- Barre de progression au scroll -->
    <div class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-saemape-gold via-saemape-red to-saemape-gold transition-all duration-100" id="scroll-progress" style="width: 0%"></div>
</nav>

<script>
    // Barre de progression au scroll
    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        const progressBar = document.getElementById('scroll-progress');
        if (progressBar) progressBar.style.width = scrolled + '%';
    });
</script>