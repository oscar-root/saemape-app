<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

new class extends Component {
    use WithPagination;

    // Propriétés pour le formulaire
    public $name = '';
    public $email = '';
    public $role = 'agent';
    public $matricule = '';
    public $password = '';
    
    // État du composant
    public $search = '';
    public $editingUser = null;
    public $showModal = false;

    // Réinitialiser la page lors d'une recherche
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Ouvrir le modal pour un nouvel utilisateur
    public function openCreateModal()
    {
        $this->reset(['name', 'email', 'role', 'matricule', 'password', 'editingUser']);
        $this->resetErrorBag();
        $this->showModal = true;
    }

    // Ouvrir le modal pour modifier
    public function editUser(User $user)
    {
        $this->resetErrorBag();
        $this->editingUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->matricule = $user->matricule;
        $this->password = ''; // Vide par sécurité
        $this->showModal = true;
    }

    // Sauvegarder (Création ou Mise à jour)
    public function save()
    {
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'role' => 'required|in:admin,agent,delegue,directeur',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->editingUser?->id)],
            'matricule' => ['required', 'string', Rule::unique('users', 'matricule')->ignore($this->editingUser?->id)],
        ];

        if (!$this->editingUser) {
            $rules['password'] = 'required|string|min:6';
        }

        $this->validate($rules);

        if ($this->editingUser) {
            // Mise à jour
            $this->editingUser->update([
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
                'matricule' => $this->matricule,
            ]);

            if (!empty($this->password)) {
                $this->editingUser->update(['password' => Hash::make($this->password)]);
            }
            
            session()->flash('message', 'Utilisateur mis à jour avec succès.');
        } else {
            // Création
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
                'matricule' => $this->matricule,
                'password' => Hash::make($this->password),
            ]);
            
            session()->flash('message', 'Nouvel utilisateur créé avec succès.');
        }

        $this->showModal = false;
    }

    // Supprimer un utilisateur
    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Vous ne pouvez pas supprimer votre propre compte.');
            return;
        }

        $user->delete();
        session()->flash('message', 'Utilisateur supprimé.');
    }

    // Données pour la vue
    public function with(): array
    {
        return [
            'users' => User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('matricule', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10),
        ];
    }
}; ?>

<div x-data="{ open: @entangle('showModal') }">
    
    <!-- Zone d'en-tête : Recherche et Bouton Ajout -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
        <div class="relative w-full md:w-1/3">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fas fa-search"></i>
            </span>
            <input wire:model.live="search" type="text" 
                placeholder="Rechercher un nom ou matricule..." 
                class="w-full pl-10 pr-4 py-3 rounded-2xl border-none shadow-sm focus:ring-2 focus:ring-saemape-blue transition-all">
        </div>

        <button @click="$wire.openCreateModal()" 
            class="bg-saemape-blue text-white px-8 py-3 rounded-2xl font-black text-xs hover:bg-blue-800 transition shadow-xl shadow-blue-900/20 flex items-center gap-3 group">
            <i class="fas fa-user-plus text-saemape-gold transition-transform group-hover:scale-125"></i>
            NOUVEAU COMPTE
        </button>
    </div>

    <!-- Notifications Flash -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold rounded-r-lg animate-bounce">
            {{ session('message') }}
        </div>
    @endif

    <!-- Table des Utilisateurs (Visualisation) -->
    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-saemape-blue/5 text-[10px] uppercase font-black tracking-[0.2em] text-saemape-blue">
                        <th class="px-8 py-5">Identité de l'Acteur</th>
                        <th class="px-8 py-5">Matricule Officiel</th>
                        <th class="px-8 py-5">Rôle Système</th>
                        <th class="px-8 py-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $user)
                        <tr class="group hover:bg-saemape-gold/5 transition-all">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-saemape-blue to-blue-900 text-white flex items-center justify-center font-black shadow-lg">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-base font-extrabold text-gray-900 leading-none">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-400 font-medium mt-1">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-4 py-1.5 bg-saemape-red/10 text-saemape-red rounded-full font-black text-[10px] tracking-widest border border-saemape-red/20 uppercase">
                                    {{ $user->matricule }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-[10px] font-black uppercase text-blue-800 tracking-widest bg-blue-50 px-3 py-1 rounded-lg">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <button wire:click="editUser({{ $user->id }})" 
                                        class="w-10 h-10 rounded-xl bg-blue-50 text-saemape-blue flex items-center justify-center hover:bg-saemape-blue hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if($user->id !== auth()->id())
                                    <button wire:click="deleteUser({{ $user->id }})" 
                                        wire:confirm="Voulez-vous vraiment supprimer cet utilisateur ?"
                                        class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-gray-50 bg-gray-50/30">
            {{ $users->links() }}
        </div>
    </div>

    <!-- MODAL DE GESTION (Alpine.js) -->
    <div x-show="open" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-saemape-blue/70 backdrop-blur-md" x-cloak x-transition>
        <div @click.away="open = false" class="bg-white rounded-[2.5rem] shadow-2xl max-w-lg w-full overflow-hidden animate-reveal border border-white/20">
            
            <!-- Header Modal -->
            <div class="bg-saemape-blue p-8 text-white relative">
                <h2 class="text-2xl font-black uppercase tracking-tight flex items-center gap-3">
                    <i class="fas {{ $editingUser ? 'fa-user-edit' : 'fa-user-plus' }} text-saemape-gold"></i>
                    {{ $editingUser ? 'Modifier l\'acteur' : 'Nouvel Acteur' }}
                </h2>
                <p class="text-blue-200 text-[10px] mt-2 font-bold uppercase tracking-[0.2em]">Maintenance technique du système SAEMAPE</p>
                <button @click="open = false" class="absolute top-8 right-8 text-white/50 hover:text-white transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Body Modal -->
            <div class="p-8">
                <form wire:submit.prevent="save" class="space-y-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest block mb-1 ml-1">Nom Complet</label>
                            <input wire:model="name" type="text" class="w-full rounded-2xl border-gray-200 bg-gray-50 py-3 font-bold text-sm focus:ring-saemape-gold">
                            @error('name') <span class="text-[10px] text-red-500 font-bold ml-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest block mb-1 ml-1">Matricule</label>
                            <input wire:model="matricule" type="text" class="w-full rounded-2xl border-gray-200 bg-gray-50 py-3 font-bold text-sm focus:ring-saemape-gold">
                            @error('matricule') <span class="text-[10px] text-red-500 font-bold ml-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest block mb-1 ml-1">Adresse Email</label>
                        <input wire:model="email" type="email" class="w-full rounded-2xl border-gray-200 bg-gray-50 py-3 font-bold text-sm focus:ring-saemape-gold">
                        @error('email') <span class="text-[10px] text-red-500 font-bold ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest block mb-1 ml-1">Rôle (Chapitre 3.A)</label>
                        <select wire:model="role" class="w-full rounded-2xl border-gray-200 bg-gray-50 py-3 font-black text-sm uppercase tracking-tighter text-saemape-blue focus:ring-saemape-gold">
                            <option value="delegue">Délégué Association</option>
                            <option value="agent">Agent SAEMAPE (Vérificateur)</option>
                            <option value="directeur">Directeur Provincial (DIPRO)</option>
                            <option value="admin">Administrateur Système</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-saemape-blue uppercase tracking-widest block mb-1 ml-1">
                            {{ $editingUser ? 'Mot de passe (Laisser vide pour ne pas changer)' : 'Mot de passe initial' }}
                        </label>
                        <input wire:model="password" type="password" class="w-full rounded-2xl border-gray-200 bg-gray-50 py-3 font-bold text-sm focus:ring-saemape-gold" placeholder="••••••••">
                        @error('password') <span class="text-[10px] text-red-500 font-bold ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-6">
                        <button type="submit" 
                            class="w-full bg-saemape-blue text-white py-4 rounded-2xl font-black text-xs uppercase shadow-xl shadow-blue-900/30 hover:scale-[1.01] transition-all flex items-center justify-center gap-3">
                            <i class="fas fa-save text-saemape-gold"></i>
                            {{ $editingUser ? 'ENREGISTRER LES MODIFICATIONS' : 'CRÉER LE COMPTE ACTEUR' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>