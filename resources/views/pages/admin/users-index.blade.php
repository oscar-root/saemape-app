<x-app-layout>
    <x-slot name="header">Gestion des Acteurs SAEMAPE</x-slot>

    <div class="max-w-7xl mx-auto">
        <!-- Appel du composant Livewire Volt -->
        @livewire('pages.admin.user-management')
    </div>
</x-app-layout>