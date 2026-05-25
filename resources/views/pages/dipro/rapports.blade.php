<x-app-layout>
    <x-slot name="header">Centre des Rapports Analytiques</x-slot>

    <div class="py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100">
                <div class="p-10 bg-saemape-blue text-white">
                    <h2 class="text-3xl font-black uppercase">Documents Stratégiques</h2>
                    <p class="text-blue-200 mt-2 font-bold uppercase text-[10px] tracking-widest">Extractions de données pour la gouvernance minière</p>
                </div>

                <div class="p-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Carte Rapport 1 -->
                    <div class="p-8 bg-gray-50 rounded-3xl border border-gray-200 hover:border-saemape-gold transition-all group">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-saemape-blue shadow-sm group-hover:bg-saemape-gold transition-colors">
                                <i class="fas fa-file-invoice-dollar text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-saemape-blue uppercase text-sm">Rapport Global des Activités</h3>
                                <p class="text-xs text-gray-400">Synthèse de la production et des finances</p>
                            </div>
                        </div>
                        <a href="{{ route('download.strategic-report') }}" target="_blank" 
                           class="w-full block text-center py-4 bg-saemape-blue text-white rounded-xl font-black text-[10px] uppercase shadow-lg hover:bg-blue-900">
                            Générer le rapport maintenant (PDF)
                        </a>
                    </div>

                    <!-- Carte Rapport 2 (Cotisations Caisse) -->
                    <div class="p-8 bg-gray-50 rounded-3xl border border-gray-200 hover:border-saemape-red transition-all group">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-saemape-red shadow-sm">
                                <i class="fas fa-vault text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-saemape-blue uppercase text-sm">Rapport de la Caisse (CEDAF)</h3>
                                <p class="text-xs text-gray-400">Historique complet des cotisations perçues</p>
                            </div>
                        </div>
                        <a href="{{ route('download.payment-report') }}" target="_blank" 
                           class="w-full block text-center py-4 bg-white text-saemape-blue border-2 border-saemape-blue rounded-xl font-black text-[10px] uppercase hover:bg-saemape-blue hover:text-white transition-all">
                            Visualiser les Recettes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>