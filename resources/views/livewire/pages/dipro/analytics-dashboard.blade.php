<?php

use App\Models\Association;
use App\Models\Declaration;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\DB;

new class extends Component {
    public function with(): array
    {
        // 1. Statistiques Globales
        $totalProduction = Declaration::where('statut', 'payé')->sum('quantite_produite');
        $totalRecettes = Declaration::where('statut', 'payé')->sum('montant_cotisation');
        $assocCount = Association::where('statut', 'valide')->count();

        // 2. Données pour le graphique (Répartition par Minerai)
        $mineralsData = Declaration::where('statut', 'payé')
            ->select('qualite_minerai', DB::raw('sum(quantite_produite) as total'))
            ->groupBy('qualite_minerai')
            ->get();

        return [
            'stats' => [
                'production' => $totalProduction,
                'recettes' => $totalRecettes,
                'associations' => $assocCount
            ],
            'chartLabels' => $mineralsData->pluck('qualite_minerai'),
            'chartValues' => $mineralsData->pluck('total'),
        ];
    }
}; ?>

<div class="space-y-8">
    <!-- Cartes de Performance -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-saemape-blue p-8 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden">
            <p class="text-[10px] font-black uppercase tracking-widest opacity-60">Production Totale Validée</p>
            <h3 class="text-4xl font-black mt-2">{{ number_format($stats['production'], 2) }} <span class="text-sm font-normal">Tonnes</span></h3>
            <i class="fas fa-cubes absolute -right-4 -bottom-4 text-8xl opacity-10"></i>
        </div>

        <div class="bg-saemape-gold p-8 rounded-[2.5rem] text-blue-900 shadow-2xl relative overflow-hidden">
            <p class="text-[10px] font-black uppercase tracking-widest opacity-60">Recettes Globales (Caisse)</p>
            <h3 class="text-4xl font-black mt-2">{{ number_format($stats['recettes'], 2) }} <span class="text-sm font-normal">USD</span></h3>
            <i class="fas fa-dollar-sign absolute -right-4 -bottom-4 text-8xl opacity-10"></i>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100 relative overflow-hidden">
            <p class="text-[10px] font-black text-saemape-blue uppercase tracking-widest">Associations Homologuées</p>
            <h3 class="text-4xl font-black mt-2 text-saemape-blue">{{ $stats['associations'] }}</h3>
            <i class="fas fa-handshake absolute -right-4 -bottom-4 text-8xl text-gray-50"></i>
        </div>
    </div>

    <!-- Section Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Graphique 1 : Répartition -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100">
            <h4 class="text-sm font-black text-saemape-blue uppercase mb-8 flex items-center gap-2">
                <i class="fas fa-chart-pie text-saemape-gold"></i> Répartition de la Production par Minerai
            </h4>
            <div class="h-64">
                <canvas id="mineralChart"></canvas>
            </div>
        </div>

        <!-- Section Insights (Analyse textuelle pour le DIPRO) -->
        <div class="bg-gray-900 p-8 rounded-[2.5rem] shadow-xl text-white">
            <h4 class="text-sm font-black text-saemape-gold uppercase mb-6 tracking-widest">Analyse Stratégique</h4>
            <div class="space-y-6">
                <div class="p-4 bg-white/5 rounded-2xl border-l-4 border-saemape-red">
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Minerai le plus extrait</p>
                    <p class="text-lg font-black">{{ $chartLabels[0] ?? 'N/A' }}</p>
                </div>
                <div class="p-4 bg-white/5 rounded-2xl border-l-4 border-saemape-gold">
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Performance Financière</p>
                    <p class="text-sm italic opacity-70">"Le taux de recouvrement des cotisations est stable sur la période actuelle."</p>
                </div>
            </div>
            <a href="{{ route('download.strategic-report') }}" target="_blank" 
   class="mt-8 w-full py-4 bg-saemape-gold text-blue-900 font-black rounded-2xl text-[10px] uppercase shadow-lg flex items-center justify-center gap-2 hover:scale-105 transition-transform">
    <i class="fas fa-file-pdf"></i> Générer Rapport Décisionnel (PDF)
</a>
        </div>
    </div>

    <!-- Script Chart.js -->
    <script>
        document.addEventListener('livewire:init', () => {
            const ctx = document.getElementById('mineralChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        data: @json($chartValues),
                        backgroundColor: ['#0054A5', '#ED1C24', '#FFD700', '#1A1A1B'],
                        borderWidth: 0,
                        hoverOffset: 20
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { weight: 'bold' } } }
                    }
                }
            });
        });
    </script>
</div>