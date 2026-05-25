<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SAEMAPE - Gestion</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body class="font-sans antialiased bg-gray-100 flex h-screen overflow-hidden">
        
        <!-- SIDEBAR DYNAMIQUE -->
        @include('layouts.sidebar-saemape')

        <!-- ZONE DE CONTENU -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar (Optionnelle pour le profil/notifs) -->
            <header class="bg-white shadow-sm z-10 py-4 px-8 flex justify-between items-center">
                <h2 class="text-xl font-bold text-saemape-blue uppercase tracking-tight">
                    {{ $header ?? 'Tableau de bord' }}
                </h2>
                <div class="flex items-center gap-4">
                    <span class="text-xs font-black bg-saemape-gold/20 text-saemape-blue px-3 py-1 rounded-full uppercase">
                        {{ auth()->user()->role }}
                    </span>
                    <span class="text-sm font-medium text-gray-600">{{ auth()->user()->name }}</span>
                </div>
            </header>

            <!-- Contenu de la page -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>