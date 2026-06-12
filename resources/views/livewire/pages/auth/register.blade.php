<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $showPassword = false;
    public bool $showConfirmPassword = false;
    public bool $isLoading = false;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $this->isLoading = true;

        $validated = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ];

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
    
    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }
    
    public function toggleConfirmPassword()
    {
        $this->showConfirmPassword = !$this->showConfirmPassword;
    }
    
    public function updatedName()
    {
        $this->resetErrorBag('name');
    }
    
    public function updatedEmail()
    {
        $this->resetErrorBag('email');
    }
    
    public function updatedPassword()
    {
        $this->resetErrorBag('password');
        $this->resetErrorBag('password_confirmation');
    }
    
    public function updatedPasswordConfirmation()
    {
        $this->resetErrorBag('password_confirmation');
    }
}; ?>

<div>
    <style>
        :root {
            --cnss-blue: #0A5C8C;
            --cnss-blue-dark: #064663;
            --cnss-blue-light: #1a7ab0;
            --cnss-green: #2E7D32;
            --cnss-gold: #FFD700;
            --cnss-gold-dark: #E5C100;
            --cnss-red: #EF4444;
        }

        /* Conteneur principal */
        .register-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 1rem;
        }
        
        /* Fond animé */
        .animated-background {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #0A5C8C 0%, #064663 30%, #083C5C 70%, #0A5C8C 100%);
            background-size: 200% 200%;
            animation: gradientFlow 12s ease infinite;
            z-index: 0;
        }
        
        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Particules */
        .particles-container {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }
        
        .particle {
            position: absolute;
            background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: particleFloat 12s ease-in-out infinite;
        }
        
        @keyframes particleFloat {
            0%, 100% {
                transform: translateY(0) translateX(0) scale(1);
                opacity: 0.15;
            }
            33% {
                transform: translateY(-25px) translateX(15px) scale(1.08);
                opacity: 0.35;
            }
            66% {
                transform: translateY(15px) translateX(-10px) scale(0.92);
                opacity: 0.25;
            }
        }
        
        /* Carte principale */
        .register-card {
            position: relative;
            z-index: 10;
            max-width: 480px;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            border-radius: 28px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            overflow: hidden;
            border: 1px solid rgba(255, 215, 0, 0.2);
            transition: all 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        
        .register-card:hover {
            border-color: rgba(255, 215, 0, 0.35);
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.4);
            transform: translateY(-2px);
        }
        
        /* En-tête */
        .card-header {
            background: linear-gradient(135deg, #0A5C8C 0%, #074A6E 100%);
            padding: 1.8rem 1.5rem 1.3rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 215, 0, 0.12) 0%, transparent 70%);
            animation: headerGlow 3s ease-in-out infinite;
        }
        
        @keyframes headerGlow {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
        
        /* Logo */
        .logo-container {
            background: white;
            width: 68px;
            height: 68px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.9rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            position: relative;
            z-index: 1;
        }
        
        .logo-container:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.25);
        }
        
        .logo-container img {
            width: 48px;
            height: auto;
            transition: transform 0.3s ease;
        }
        
        .logo-container:hover img {
            transform: scale(1.05);
        }
        
        .card-header h2 {
            color: white;
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
            margin: 0;
        }
        
        .card-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.75rem;
            margin-top: 0.3rem;
            position: relative;
            z-index: 1;
        }
        
        /* Corps du formulaire */
        .card-body {
            padding: 1.8rem;
        }
        
        /* Groupes de champs */
        .form-group {
            margin-bottom: 1.2rem;
        }
        
        .form-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.7rem;
            font-weight: 700;
            color: #0A5C8C;
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            color: #9CA3AF;
            pointer-events: none;
            transition: all 0.25s ease;
            z-index: 2;
            font-size: 0.95rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.6rem;
            font-size: 0.9rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 14px;
            background: white;
            transition: all 0.25s ease;
            font-family: inherit;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--cnss-gold);
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
            transform: translateY(-1px);
        }
        
        .form-input.error {
            border-color: var(--cnss-red);
            animation: shake 0.4s ease;
        }
        
        .form-input.valid {
            border-color: #10B981;
            background: linear-gradient(white, #F0FDF4);
        }
        
        .input-wrapper:focus-within .input-icon {
            color: var(--cnss-gold);
            transform: scale(1.1);
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
            20%, 40%, 60%, 80% { transform: translateX(3px); }
        }
        
        /* Password toggle */
        .password-toggle {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            color: #9CA3AF;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: all 0.25s ease;
            z-index: 2;
            font-size: 0.95rem;
        }
        
        .password-toggle:hover {
            color: var(--cnss-gold);
            transform: scale(1.1);
        }
        
        /* Indicateur de force du mot de passe */
        .password-strength {
            margin-top: 0.75rem;
        }
        
        .strength-bars {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .strength-bar {
            flex: 1;
            height: 4px;
            background: #E5E7EB;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .strength-bar.active {
            background: var(--cnss-gold);
        }
        
        .strength-text {
            font-size: 0.7rem;
            color: #6B7280;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* Critères de sécurité */
        .criteria-list {
            margin-top: 0.75rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        
        .criteria-item {
            font-size: 0.65rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            color: #9CA3AF;
            transition: all 0.3s ease;
        }
        
        .criteria-item.valid {
            color: #10B981;
        }
        
        /* Message d'erreur */
        .error-message {
            font-size: 0.7rem;
            color: var(--cnss-red);
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            animation: fadeSlide 0.3s ease;
        }
        
        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Indicateur de correspondance */
        .match-indicator {
            font-size: 0.7rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            animation: fadeSlide 0.3s ease;
        }
        
        .match-indicator.valid {
            color: #10B981;
        }
        
        .match-indicator.invalid {
            color: var(--cnss-red);
        }
        
        /* Bouton principal */
        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, #0A5C8C 0%, #074A6E 100%);
            border: none;
            padding: 0.85rem;
            border-radius: 14px;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            transition: all 0.3s ease;
            font-family: inherit;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(10, 92, 140, 0.3);
            margin-top: 0.5rem;
        }
        
        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.25), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-register:hover::before {
            left: 100%;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px -8px rgba(10, 92, 140, 0.5);
        }
        
        .btn-register:active {
            transform: translateY(0);
        }
        
        .btn-register:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        
        .btn-register.loading {
            pointer-events: none;
        }
        
        .btn-register.loading .btn-text {
            visibility: hidden;
        }
        
        .btn-register.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Lien de connexion */
        .login-link {
            text-align: center;
            margin-top: 1.2rem;
            font-size: 0.8rem;
            color: #6B7280;
        }
        
        .login-link a {
            color: #0A5C8C;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.25s ease;
            position: relative;
        }
        
        .login-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1.5px;
            background: var(--cnss-gold);
            transition: width 0.25s ease;
        }
        
        .login-link a:hover {
            color: var(--cnss-gold);
        }
        
        .login-link a:hover::after {
            width: 100%;
        }
        
        /* Footer */
        .card-footer {
            background: #F8FAFC;
            padding: 0.9rem 1.5rem;
            text-align: center;
            border-top: 1px solid #EEF2F6;
        }
        
        .card-footer p {
            font-size: 0.6rem;
            color: #6B7280;
            letter-spacing: 0.5px;
            font-weight: 500;
            margin: 0;
        }
        
        /* Badge de version */
        .version-badge {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.6rem;
            color: rgba(255, 255, 255, 0.7);
            z-index: 20;
            font-family: monospace;
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .register-card {
                max-width: 100%;
                border-radius: 24px;
            }
            
            .card-body {
                padding: 1.4rem;
            }
            
            .logo-container {
                width: 56px;
                height: 56px;
            }
            
            .logo-container img {
                width: 40px;
            }
            
            .card-header h2 {
                font-size: 1.35rem;
            }
            
            .criteria-list {
                flex-direction: column;
                gap: 0.4rem;
            }
        }
    </style>

    <div class="register-wrapper">
        <!-- Fond animé -->
        <div class="animated-background"></div>
        
        <!-- Particules -->
        <div class="particles-container">
            <div class="particle" style="width: 280px; height: 280px; top: -100px; left: -100px; animation-duration: 10s;"></div>
            <div class="particle" style="width: 200px; height: 200px; bottom: -60px; right: -60px; animation-duration: 13s;"></div>
            <div class="particle" style="width: 140px; height: 140px; top: 20%; right: 5%; animation-duration: 8s; animation-delay: 0.5s;"></div>
            <div class="particle" style="width: 100px; height: 100px; bottom: 25%; left: 3%; animation-duration: 11s; animation-delay: 1s;"></div>
            <div class="particle" style="width: 170px; height: 170px; top: 60%; right: -50px; animation-duration: 9s;"></div>
            <div class="particle" style="width: 80px; height: 80px; top: 75%; left: 10%; animation-duration: 7s; animation-delay: 0.3s;"></div>
        </div>

        <!-- Carte d'inscription -->
        <div class="register-card">
            <!-- En-tête -->
            <div class="card-header">
                <div class="logo-container">
                    <img src="{{ asset('images/saemape.png') }}" alt="SAEMAPE">
                </div>
                <h2>Créer un compte</h2>
                <p>Inscrivez-vous pour accéder à la plateforme</p>
            </div>

            <!-- Corps -->
            <div class="card-body">
                <form wire:submit="register" id="registerForm">
                    <!-- Nom complet -->
                    <div class="form-group">
                        <label class="form-label" for="name">
                            <i class="fas fa-user"></i>
                            Nom complet
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input wire:model.live="name" id="name" 
                                   class="form-input @error('name') error @enderror @if(!empty($name) && !$errors->has('name')) valid @endif" 
                                   type="text" name="name" required autofocus autocomplete="name"
                                   placeholder="Jean Dupont">
                        </div>
                        @error('name')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label" for="email">
                            <i class="fas fa-envelope"></i>
                            Email professionnel
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input wire:model.live="email" id="email" 
                                   class="form-input @error('email') error @enderror @if(!empty($email) && !$errors->has('email')) valid @endif" 
                                   type="email" name="email" required autocomplete="username"
                                   placeholder="vanessa@saemape.cd">
                        </div>
                        @error('email')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Mot de passe -->
                    <div class="form-group">
                        <label class="form-label" for="password">
                            <i class="fas fa-lock"></i>
                            Mot de passe
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-key input-icon"></i>
                            <input wire:model.live="password" id="password" 
                                   class="form-input @error('password') error @enderror @if(!empty($password) && !$errors->has('password')) valid @endif"
                                   type="{{ $showPassword ? 'text' : 'password' }}" name="password" required 
                                   autocomplete="new-password" placeholder="Créez un mot de passe sécurisé">
                            <button type="button" class="password-toggle" wire:click="togglePassword">
                                <i class="fas {{ $showPassword ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                            </button>
                        </div>
                        
                        <!-- Indicateur de force (visible uniquement quand le champ n'est pas vide) -->
                        @if(!empty($password))
                            <div class="password-strength" id="strengthIndicator">
                                <div class="strength-bars">
                                    <div class="strength-bar" id="bar1"></div>
                                    <div class="strength-bar" id="bar2"></div>
                                    <div class="strength-bar" id="bar3"></div>
                                    <div class="strength-bar" id="bar4"></div>
                                </div>
                                <div class="strength-text">
                                    <i class="fas fa-chart-line"></i>
                                    <span id="strengthText">Force du mot de passe</span>
                                </div>
                            </div>
                            
                            <!-- Critères de sécurité -->
                            <div class="criteria-list" id="criteriaList">
                                <div class="criteria-item" id="lengthCriteria">
                                    <i class="far fa-circle"></i>
                                    <span>Minimum 8 caractères</span>
                                </div>
                                <div class="criteria-item" id="upperCriteria">
                                    <i class="far fa-circle"></i>
                                    <span>Lettre majuscule</span>
                                </div>
                                <div class="criteria-item" id="lowerCriteria">
                                    <i class="far fa-circle"></i>
                                    <span>Lettre minuscule</span>
                                </div>
                                <div class="criteria-item" id="numberCriteria">
                                    <i class="far fa-circle"></i>
                                    <span>Chiffre</span>
                                </div>
                                <div class="criteria-item" id="specialCriteria">
                                    <i class="far fa-circle"></i>
                                    <span>Caractère spécial (!@#$%^&*)</span>
                                </div>
                            </div>
                        @endif
                        
                        @error('password')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Confirmation mot de passe -->
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">
                            <i class="fas fa-check-circle"></i>
                            Confirmer le mot de passe
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-check-double input-icon"></i>
                            <input wire:model.live="password_confirmation" id="password_confirmation" 
                                   class="form-input @error('password_confirmation') error @enderror @if(!empty($password_confirmation) && !$errors->has('password_confirmation')) valid @endif"
                                   type="{{ $showConfirmPassword ? 'text' : 'password' }}" name="password_confirmation" required 
                                   autocomplete="new-password" placeholder="Répétez votre mot de passe">
                            <button type="button" class="password-toggle" wire:click="toggleConfirmPassword">
                                <i class="fas {{ $showConfirmPassword ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                            </button>
                        </div>
                        
                        <!-- Indicateur de correspondance -->
                        @if(!empty($password_confirmation) && !empty($password))
                            <div class="match-indicator {{ $password === $password_confirmation ? 'valid' : 'invalid' }}">
                                <i class="fas {{ $password === $password_confirmation ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
                                <span>{{ $password === $password_confirmation ? 'Les mots de passe correspondent' : 'Les mots de passe ne correspondent pas' }}</span>
                            </div>
                        @endif
                        
                        @error('password_confirmation')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Bouton d'inscription -->
                    <button type="submit" class="btn-register" id="submitBtn" 
                            wire:loading.attr="disabled" wire:target="register"
                            wire:loading.class="loading">
                        <i class="fas fa-user-plus"></i>
                        <span class="btn-text">S'inscrire</span>
                    </button>
                    
                    <!-- Lien de connexion -->
                    <div class="login-link">
                        Vous avez déjà un compte ? 
                        <a href="{{ route('login') }}" wire:navigate>
                            Connectez-vous
                        </a>
                    </div>
                </form>
            </div>

            <!-- Pied de page -->
            <div class="card-footer">
                <p>SAEMAPE H-L • Direction Provinciale • Gestion des associations minières</p>
            </div>
        </div>
        
        <!-- Badge de version -->
        <div class="version-badge">
            <i class="fas fa-code-branch"></i> v3.0 - Sécurisé
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', function() {
            // Fonction pour mettre à jour l'indicateur de force du mot de passe
            function updatePasswordStrength() {
                const password = document.getElementById('password')?.value || '';
                
                if (password.length === 0) return;
                
                const checks = {
                    length: password.length >= 8,
                    upper: /[A-Z]/.test(password),
                    lower: /[a-z]/.test(password),
                    number: /[0-9]/.test(password),
                    special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
                };
                
                // Mise à jour des critères
                const lengthCriteria = document.getElementById('lengthCriteria');
                const upperCriteria = document.getElementById('upperCriteria');
                const lowerCriteria = document.getElementById('lowerCriteria');
                const numberCriteria = document.getElementById('numberCriteria');
                const specialCriteria = document.getElementById('specialCriteria');
                
                function updateCriteria(element, isValid) {
                    if (element) {
                        if (isValid) {
                            element.classList.add('valid');
                            element.innerHTML = '<i class="fas fa-check-circle"></i> ' + element.innerHTML.split('</i>')[1];
                        } else {
                            element.classList.remove('valid');
                            if (!element.innerHTML.includes('far fa-circle')) {
                                element.innerHTML = '<i class="far fa-circle"></i> ' + element.innerHTML.split('</i>')[1];
                            }
                        }
                    }
                }
                
                updateCriteria(lengthCriteria, checks.length);
                updateCriteria(upperCriteria, checks.upper);
                updateCriteria(lowerCriteria, checks.lower);
                updateCriteria(numberCriteria, checks.number);
                updateCriteria(specialCriteria, checks.special);
                
                // Calcul du score
                let score = 0;
                if (checks.length) score++;
                if (checks.upper) score++;
                if (checks.lower) score++;
                if (checks.number) score++;
                if (checks.special) score++;
                
                // Mise à jour des barres
                const bars = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3'), document.getElementById('bar4')];
                bars.forEach((bar, index) => {
                    if (bar) {
                        if (index < score) {
                            bar.classList.add('active');
                        } else {
                            bar.classList.remove('active');
                        }
                    }
                });
                
                // Texte et couleur
                const strengthText = document.getElementById('strengthText');
                if (strengthText) {
                    let text = '';
                    let color = '';
                    if (score <= 2) {
                        text = 'Faible';
                        color = '#EF4444';
                    } else if (score <= 3) {
                        text = 'Moyen';
                        color = '#F59E0B';
                    } else if (score <= 4) {
                        text = 'Fort';
                        color = '#10B981';
                    } else {
                        text = 'Très fort';
                        color = '#10B981';
                    }
                    strengthText.innerHTML = `<i class="fas fa-chart-line"></i> Force du mot de passe : <strong style="color: ${color}">${text}</strong>`;
                }
            }
            
            // Écouter les changements sur le champ mot de passe
            const passwordInput = document.getElementById('password');
            if (passwordInput) {
                passwordInput.addEventListener('input', updatePasswordStrength);
                // Initialiser si déjà rempli
                if (passwordInput.value) {
                    updatePasswordStrength();
                }
            }
            
            // Animation de validation en temps réel
            const inputs = document.querySelectorAll('.form-input');
            
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('error');
                    
                    if (this.value.trim() !== '') {
                        this.classList.add('valid');
                    } else {
                        this.classList.remove('valid');
                    }
                });
                
                input.addEventListener('focus', function() {
                    this.classList.remove('error');
                });
                
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.remove('valid');
                    }
                });
            });
            
            // Animation du bouton de chargement
            const form = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');
            
            if (form && submitBtn) {
                form.addEventListener('submit', function() {
                    submitBtn.disabled = true;
                });
            }
            
            // Animation d'apparition de la carte
            const card = document.querySelector('.register-card');
            if (card) {
                card.style.opacity = '0';
                card.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1)';
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                }, 100);
            }
        });
        
        // Gestion des erreurs de soumission
        document.addEventListener('livewire:navigating', () => {
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.disabled = true;
            }
        });
        
        document.addEventListener('livewire:navigated', () => {
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('loading');
            }
        });
    </script>
    @endpush
</div>