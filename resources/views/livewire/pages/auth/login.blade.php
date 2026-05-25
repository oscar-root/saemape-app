<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;
    
    public bool $showPassword = false;
    public bool $isLoading = false;

    /**
     * Gère la tentative de connexion.
     */
    public function login(): void
    {
        $this->isLoading = true;

        try {
            // L'objet form s'occupe de la validation et de l'authentification
            $this->form->authenticate();
            
            Session::regenerate();

            // Redirection vers le dashboard (votre logique web.php prendra le relais)
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
            
        } catch (\Exception $e) {
            $this->isLoading = false;
            // On affiche l'erreur sur le champ email
            $this->addError('form.email', 'Ces identifiants ne correspondent pas à nos enregistrements.');
        }
    }
    
    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }
}; ?>

<div>
    <style>
        /* Gardez vos styles personnalisés SAEMAPE ici, ils sont excellents */
        :root { --saemape-blue: #1B4F72; --saemape-orange: #D35400; --saemape-red: #E74C3C; }
        .login-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; padding: 1rem; }
        .animated-background { position: fixed; inset: 0; background: linear-gradient(135deg, #1B4F72 0%, #0D3B5E 100%); z-index: 0; }
        .login-card { position: relative; z-index: 10; max-width: 400px; width: 100%; background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.3); }
        .card-header { background: #1B4F72; padding: 1.5rem; text-align: center; color: white; }
        .logo-container { background: white; width: 60px; height: 60px; border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; }
        .logo-container img { width: 45px; }
        .card-body { padding: 2rem; }
        .form-input { width: 100%; padding: 0.7rem 1rem 0.7rem 2.5rem; border: 1px solid #ddd; border-radius: 12px; margin-top: 5px; }
        .btn-login { width: 100%; background: #1B4F72; color: white; padding: 0.8rem; border-radius: 12px; font-weight: bold; cursor: pointer; margin-top: 1rem; border: none; }
        .btn-login:disabled { opacity: 0.5; }
        .error-message { color: #E74C3C; font-size: 0.7rem; margin-top: 5px; }
    </style>

    <div class="login-wrapper">
        <div class="animated-background"></div>
        
        <div class="login-card">
            <div class="card-header">
                <div class="logo-container">
                    <img src="{{ asset('images/saemape.png') }}" alt="Logo">
                </div>
                <h2 class="text-xl font-bold">SAEMAPE HL</h2>
                <p class="text-xs opacity-70">Portail de Gestion Digitalisé</p>
            </div>

            <div class="card-body">
                <form wire:submit="login">
                    <!-- EMAIL : Notez le form.email -->
                    <div class="mb-4">
                        <label class="text-xs font-bold text-blue-900 uppercase">Email</label>
                        <div class="relative">
                            <input wire:model="form.email" type="email" class="form-input @error('form.email') border-red-500 @enderror" placeholder="nom@saemape.cd" required>
                        </div>
                        @error('form.email') <p class="error-message">{{ $message }}</p> @enderror
                    </div>

                    <!-- PASSWORD : Notez le form.password -->
                    <div class="mb-4">
                        <label class="text-xs font-bold text-blue-900 uppercase">Mot de passe</label>
                        <div class="relative">
                            <input wire:model="form.password" type="{{ $showPassword ? 'text' : 'password' }}" class="form-input @error('form.password') border-red-500 @enderror" placeholder="••••••••" required>
                        </div>
                        @error('form.password') <p class="error-message">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <label class="flex items-center text-xs">
                            <input wire:model="form.remember" type="checkbox" class="mr-2"> Se souvenir
                        </label>
                    </div>

                    <button type="submit" class="btn-login" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="login">CONNEXION</span>
                        <span wire:loading wire:target="login">CHARGEMENT...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>