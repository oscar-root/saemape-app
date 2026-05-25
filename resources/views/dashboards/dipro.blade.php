<x-app-layout>
    <x-slot name="header">Bureau du Directeur Provincial</x-slot>

    <div class="bg-white p-10 rounded-[3rem] shadow-2xl border-l-[16px] border-saemape-red">
        <div class="flex flex-col md:flex-row items-center gap-10">
            <div class="flex-1">
                <h2 class="text-4xl font-black text-saemape-blue leading-tight mb-4">Bienvenue, Monsieur le Directeur.</h2>
                <p class="text-gray-500 font-medium leading-relaxed italic">
                    "Toutes les activités minières de la province du Haut-Lomami sont centralisées ici. Utilisez les outils d'analyse pour piloter le développement du secteur artisanal."
                </p>
                <div class="mt-8 flex gap-4">
                    <a href="{{ route('dipro.stats') }}" class="px-8 py-4 bg-saemape-blue text-white rounded-2xl font-black text-xs uppercase shadow-xl hover:scale-105 transition-all">
                        Consulter les Statistiques
                    </a>
                </div>
            </div>
            <div class="w-full md:w-64 bg-gray-50 p-6 rounded-[2rem] border border-gray-100 flex flex-col items-center">
                 <img src="{{ asset('images/saemape.png') }}" class="h-32 w-auto mb-4 opacity-50" alt="">
                 <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Système de Décision Intégré</p>
            </div>
        </div>
    </div>
</x-app-layout>