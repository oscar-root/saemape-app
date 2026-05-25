<footer class="bg-white border-t-8 border-saemape-blue mt-auto">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            
            <!-- Colonne 1: Identité -->
            <div class="col-span-1 md:col-span-1">
                <img src="{{ asset('images/saemape.png') }}" class="h-16 w-auto mb-4" alt="SAEMAPE">
                <p class="text-gray-500 text-sm leading-relaxed">
                    Service d'Animation et d'Encadrement de l'Exploitation Minière Artisanale et à Petite Échelle.
                </p>
            </div>

            <!-- Colonne 2: Localisation (Page 4 du CDC) -->
            <div>
                <h3 class="text-saemape-blue font-black text-sm uppercase tracking-wider mb-4">Bureau Provincial</h3>
                <ul class="text-gray-600 text-sm space-y-2">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-saemape-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Av. LUBILANJI, N°13<br>Centre-ville de Kamina<br>Haut-Lomami, RDC</span>
                    </li>
                </ul>
            </div>

            <!-- Colonne 3: Liens rapides -->
            <div>
                <h3 class="text-saemape-blue font-black text-sm uppercase tracking-wider mb-4">Navigation</h3>
                <ul class="text-gray-600 text-sm space-y-2 font-medium">
                    <li><a href="#" class="hover:text-saemape-red transition">Annuaire des associations</a></li>
                    <li><a href="#" class="hover:text-saemape-red transition">Statistiques de production</a></li>
                    <li><a href="#" class="hover:text-saemape-red transition">Réglementations minières</a></li>
                </ul>
            </div>

            <!-- Colonne 4: Support -->
            <div>
                <h3 class="text-saemape-blue font-black text-sm uppercase tracking-wider mb-4">Support Technique</h3>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <p class="text-[10px] text-gray-400 uppercase font-bold mb-2">Administrateur Système</p>
                    <p class="text-saemape-blue font-bold text-sm">support@saemape.cd</p>
                </div>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-400 text-xs">
                © {{ date('Y') }} SAEMAPE Haut-Lomami. Tous droits réservés.
            </p>
            <div class="flex gap-2">
                <div class="w-8 h-1 bg-saemape-blue"></div>
                <div class="w-8 h-1 bg-saemape-gold"></div>
                <div class="w-8 h-1 bg-saemape-red"></div>
            </div>
        </div>
    </div>
</footer>