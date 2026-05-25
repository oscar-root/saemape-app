<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAEMAPE | Excellence Minière Haut-Lomami - Gestion Digitalisée des Associations</title>
    <meta name="description" content="Plateforme officielle de gestion des associations minières du Haut-Lomami. Digitalisation, transparence et traçabilité des productions.">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        /* ========== ANIMATIONS ========== */
        @keyframes shine {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes floatBadge {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes glowPulse {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.1); }
        }

        @keyframes borderGlow {
            0% { border-color: rgba(255, 215, 0, 0.2); box-shadow: 0 0 0px rgba(255, 215, 0, 0); }
            50% { border-color: rgba(255, 215, 0, 0.6); box-shadow: 0 0 20px rgba(255, 215, 0, 0.2); }
            100% { border-color: rgba(255, 215, 0, 0.2); box-shadow: 0 0 0px rgba(255, 215, 0, 0); }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideRight {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* ========== CLASSES ========== */
        .section-bg {
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .overlay-gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 50%, rgba(0, 0, 0, 0.5) 100%);
        }

        .glass-premium {
            background: rgba(10, 15, 25, 0.65);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 215, 0, 0.25);
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.3, 1.1);
        }

        .glass-premium:hover {
            border-color: rgba(255, 215, 0, 0.5);
            transform: translateY(-5px);
            box-shadow: 0 25px 40px -15px rgba(0, 0, 0, 0.4);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 215, 0, 0.15);
            transition: all 0.4s ease;
        }

        .glass-card:hover {
            border-color: rgba(255, 215, 0, 0.4);
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.08);
        }

        .text-reveal {
            background: linear-gradient(120deg, #FFD700, #FFA500, #FFD700, #FFA500, #FFD700);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: shine 3s linear infinite;
        }

        .animate-float {
            animation: float 5s ease-in-out infinite;
        }

        .animate-float-badge {
            animation: floatBadge 4s ease-in-out infinite;
        }

        .animate-glow {
            animation: glowPulse 3s ease-in-out infinite;
        }

        .animate-border-glow {
            animation: borderGlow 3s ease-in-out infinite;
        }

        /* Révélation au scroll */
        .reveal-up {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.2, 0.9, 0.3, 1.1);
        }

        .reveal-right {
            opacity: 0;
            transform: translateX(-40px);
            transition: all 0.8s cubic-bezier(0.2, 0.9, 0.3, 1.1);
        }

        .reveal-up.visible, .reveal-right.visible {
            opacity: 1;
            transform: translateY(0) translateX(0);
        }

        .delay-100 { transition-delay: 0.1s; }
        .delay-200 { transition-delay: 0.2s; }
        .delay-300 { transition-delay: 0.3s; }
        .delay-400 { transition-delay: 0.4s; }

        /* Background images */
        .bg-img-1 { background-image: url('{{ asset("images/img5.PNG") }}'); }
        .bg-img-2 { background-image: url('{{ asset("images/img2.PNG") }}'); }
        .bg-img-3 { background-image: url('{{ asset("images/img3.PNG") }}'); }
        .bg-img-4 { background-image: url('{{ asset("images/img4.PNG") }}'); }
        .bg-img-5 { background-image: url('{{ asset("images/img1.PNG") }}'); }
        .bg-img-6 { background-image: url('{{ asset("images/img6.PNG") }}'); }
        .bg-img-7 { background-image: url('{{ asset("images/img7.PNG") }}'); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0a0f1a; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(135deg, #FFD700, #FFA500); border-radius: 3px; }

        /* Navigation active */
        .nav-link.active {
            color: #FFD700;
            position: relative;
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 2px;
            background: #FFD700;
            border-radius: 2px;
        }
    </style>
</head>
<body class="antialiased">

    <!-- ========== NAVBAR PREMIUM ========== -->
    <nav class="fixed top-0 w-full z-[100] transition-all duration-500 py-5" id="navbar">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="glass-premium rounded-2xl px-5 py-2 flex justify-between items-center">
                <a href="#hero" class="flex items-center gap-3 group cursor-pointer">
                    <div class="p-1.5 bg-white/10 rounded-xl transition-transform group-hover:scale-105">
                        <img src="{{ asset('images/saemape.png') }}" class="h-9 w-auto" alt="Logo">
                    </div>
                    <div class="hidden lg:block">
                        <span class="block text-sm font-extrabold uppercase leading-none text-white">SAEMAPE</span>
                        <span class="text-[7px] font-black text-yellow-500 uppercase tracking-[0.3em]">Haut-Lomami</span>
                    </div>
                </a>

                <!-- Menu navigation -->
                <div class="hidden lg:flex items-center gap-6">
                    <a href="#hero" class="nav-link text-[10px] font-black uppercase tracking-wider text-gray-300 hover:text-yellow-500 transition-colors">Accueil</a>
                    <a href="#identification" class="nav-link text-[10px] font-black uppercase tracking-wider text-gray-300 hover:text-yellow-500 transition-colors">Délégués</a>
                    <a href="#homologation" class="nav-link text-[10px] font-black uppercase tracking-wider text-gray-300 hover:text-yellow-500 transition-colors">Agents</a>
                    <a href="#stats" class="nav-link text-[10px] font-black uppercase tracking-wider text-gray-300 hover:text-yellow-500 transition-colors">Statistiques</a>
                    <a href="#contact" class="nav-link text-[10px] font-black uppercase tracking-wider text-gray-300 hover:text-yellow-500 transition-colors">Contact</a>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2 bg-gradient-to-r from-yellow-500 to-orange-500 text-black font-black text-xs rounded-xl hover:shadow-lg hover:shadow-yellow-500/30 transition-all uppercase">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:block text-sm font-semibold text-gray-300 hover:text-yellow-500 transition">Connexion</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white font-black text-xs rounded-xl hover:shadow-lg hover:shadow-red-500/30 transition-all uppercase">S'enregistrer</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ========== SECTION 1 : HERO ========== -->
    <section id="hero" class="section-bg bg-img-1 min-h-screen relative">
        <div class="overlay-gradient"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 w-full">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-yellow-500/20 border border-yellow-500/30 reveal-right delay-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                        <span class="text-[9px] font-black uppercase text-yellow-500">Plateforme Digitale Officielle</span>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black leading-[1.1] tracking-tighter reveal-right delay-200">
                        <span class="text-white">L'Avenir de la</span><br>
                        <span class="text-reveal">Mine Artisanale.</span>
                    </h1>
                    <p class="text-white/80 text-base md:text-lg max-w-lg leading-relaxed border-l-4 border-yellow-500 pl-5 reveal-right delay-300">
                        Digitalisation, Transparence et Encadrement pour le développement minier responsable du Haut-Lomami.
                    </p>
                    <div class="reveal-right delay-400">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-3 px-8 py-3.5 bg-gradient-to-r from-yellow-500 to-orange-500 text-black font-black rounded-xl hover:shadow-2xl hover:shadow-yellow-500/40 transition-all group">
                            <span>ACCÉDER AU PORTAIL</span>
                            <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
                <div class="flex justify-center items-center reveal-right delay-200">
                    <img src="{{ asset('images/saemape.png') }}" class="w-full max-w-md animate-float drop-shadow-2xl" alt="SAEMAPE">
                </div>
            </div>
        </div>
        
        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 hidden lg:block">
            <div class="w-6 h-10 border-2 border-yellow-500/50 rounded-full flex justify-center">
                <div class="w-1 h-2 bg-yellow-500 rounded-full mt-2 animate-pulse"></div>
            </div>
        </div>
    </section>

    <!-- ========== SECTION 2 : DÉLÉGUÉS (IDENTIFICATION) ========== -->
    <section id="identification" class="section-bg bg-img-2 relative">
        <div class="overlay-gradient"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 w-full">
            <div class="max-w-xl p-8 glass-premium rounded-2xl reveal-up">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center mb-6 shadow-lg">
                    <i class="fas fa-fingerprint text-2xl text-black"></i>
                </div>
                <h2 class="text-3xl md:text-4xl font-black uppercase mb-4 text-white tracking-tighter">Identification</h2>
                <p class="text-gray-200 text-base leading-relaxed font-medium">
                    "Chaque entité minière dispose désormais d'une identité numérique infalsifiable rattachée à son RCCM, garantissant une traçabilité totale et une gestion transparente des associations."
                </p>
                <div class="mt-6 flex items-center gap-2 text-yellow-500 text-xs font-bold">
                    <span>Pilier 1</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SECTION 3 : AGENTS (HOMOLOGATION) ========== -->
    <section id="homologation" class="section-bg bg-img-3 relative">
        <div class="overlay-gradient" style="background: linear-gradient(135deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.7) 100%);"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 w-full flex justify-end">
            <div class="max-w-xl p-8 glass-premium rounded-2xl text-right reveal-up">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-6 ml-auto shadow-lg">
                    <i class="fas fa-check-double text-2xl text-white"></i>
                </div>
                <h2 class="text-3xl md:text-4xl font-black uppercase mb-4 text-white tracking-tighter">Homologation</h2>
                <p class="text-gray-200 text-base leading-relaxed font-medium">
                    "Vérification rigoureuse des flux de production par nos experts pour une traçabilité certifiée à 100% et une validation conforme aux normes en vigueur."
                </p>
                <div class="mt-6 flex items-center justify-end gap-2 text-blue-400 text-xs font-bold">
                    <i class="fas fa-arrow-left"></i>
                    <span>Pilier 2</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SECTION 4 : STATISTIQUES ========== -->
    <section id="stats" class="section-bg bg-img-5 relative">
        <div class="overlay-gradient"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 w-full">
            <div class="text-center mb-12 reveal-up">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-yellow-500/20 border border-yellow-500/30 mb-4">
                    <span class="text-[9px] font-black text-yellow-500 uppercase">Impact mesurable</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-black text-white">Chiffres clés de la <span class="text-reveal">digitalisation</span></h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="glass-card rounded-xl p-6 text-center reveal-up delay-100">
                    <div class="w-16 h-16 rounded-full bg-yellow-500/20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-2xl text-yellow-500"></i>
                    </div>
                    <div class="text-4xl font-black text-yellow-500 mb-1">150+</div>
                    <p class="text-xs font-black uppercase tracking-wider text-gray-300">Associations enregistrées</p>
                </div>
                <div class="glass-card rounded-xl p-6 text-center reveal-up delay-200">
                    <div class="w-16 h-16 rounded-full bg-blue-500/20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-2xl text-blue-400"></i>
                    </div>
                    <div class="text-4xl font-black text-blue-400 mb-1">100%</div>
                    <p class="text-xs font-black uppercase tracking-wider text-gray-300">Traçabilité certifiée</p>
                </div>
                <div class="glass-card rounded-xl p-6 text-center reveal-up delay-300">
                    <div class="w-16 h-16 rounded-full bg-green-500/20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-alt text-2xl text-green-400"></i>
                    </div>
                    <div class="text-4xl font-black text-green-400 mb-1">0%</div>
                    <p class="text-xs font-black uppercase tracking-wider text-gray-300">Fraude documentaire</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SECTION 5 : VALEURS AJOUTÉES ========== -->
    <section class="relative py-20 px-6 lg:px-8 bg-gradient-to-b from-saemape-dark/95 to-saemape-dark">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-black text-white">Pourquoi <span class="text-reveal">SAEMAPE</span> ?</h2>
                <p class="text-gray-400 text-sm mt-3">Une plateforme pensée pour les acteurs du secteur minier artisanal</p>
            </div>
            <div class="grid md:grid-cols-4 gap-5">
                <div class="glass-card rounded-xl p-5 text-center reveal-up delay-100">
                    <i class="fas fa-shield-alt text-2xl text-yellow-500 mb-3"></i>
                    <h3 class="text-sm font-black text-white mb-1">Sécurité maximale</h3>
                    <p class="text-xs text-gray-400">Données protégées par chiffrement AES-256</p>
                </div>
                <div class="glass-card rounded-xl p-5 text-center reveal-up delay-200">
                    <i class="fas fa-clock text-2xl text-yellow-500 mb-3"></i>
                    <h3 class="text-sm font-black text-white mb-1">Temps réel</h3>
                    <p class="text-xs text-gray-400">Mise à jour instantanée des données</p>
                </div>
                <div class="glass-card rounded-xl p-5 text-center reveal-up delay-300">
                    <i class="fas fa-chart-simple text-2xl text-yellow-500 mb-3"></i>
                    <h3 class="text-sm font-black text-white mb-1">Rapports analytiques</h3>
                    <p class="text-xs text-gray-400">Tableaux de bord personnalisés</p>
                </div>
                <div class="glass-card rounded-xl p-5 text-center reveal-up delay-400">
                    <i class="fas fa-headset text-2xl text-yellow-500 mb-3"></i>
                    <h3 class="text-sm font-black text-white mb-1">Support dédié</h3>
                    <p class="text-xs text-gray-400">Assistance technique 24/7</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== FOOTER : CONTACT ========== -->
    <footer id="contact" class="section-bg bg-img-7 relative py-16 px-6 lg:px-8">
        <div class="absolute inset-0 bg-gradient-to-b from-saemape-blue/95 to-saemape-blue/98 backdrop-blur-sm"></div>
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-white/10">
                <div class="space-y-4">
                    <div class="bg-white/10 p-2 rounded-xl w-fit">
                        <img src="{{ asset('images/saemape.png') }}" class="h-12 w-auto" alt="SAEMAPE">
                    </div>
                    <p class="text-[9px] font-bold uppercase leading-relaxed tracking-wider text-gray-300">
                        Service d'Animation et d'Encadrement de l'Exploitation Minière Artisanale et à Petite Échelle.
                    </p>
                </div>
                <div class="space-y-4">
                    <h4 class="text-yellow-500 font-black text-xs uppercase tracking-widest border-l-3 border-yellow-500 pl-3">Localisation</h4>
                    <p class="text-xs text-gray-300 leading-relaxed">
                        Direction Provinciale<br>
                        Av. Lubilanji, N°13<br>
                        Centre-ville de Kamina, RDC
                    </p>
                </div>
                <div class="space-y-4">
                    <h4 class="text-yellow-500 font-black text-xs uppercase tracking-widest border-l-3 border-yellow-500 pl-3">Contact</h4>
                    <p class="text-xs text-gray-300">
                        <i class="fas fa-envelope mr-2 text-yellow-500"></i> contact@saemape.cd<br>
                        <i class="fas fa-phone mr-2 text-yellow-500"></i> +243 123 456 789
                    </p>
                </div>
                <div class="space-y-4">
                    <h4 class="text-yellow-500 font-black text-xs uppercase tracking-widest border-l-3 border-yellow-500 pl-3">Horaires</h4>
                    <p class="text-xs text-gray-300 bg-white/5 p-3 rounded-xl">
                        Lun - Ven : 08h00 - 16h30<br>
                        Sam : 08h00 - 12h00
                    </p>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-8">
                <span class="text-[8px] font-black uppercase tracking-[0.3em] text-gray-400">© {{ date('Y') }} SAEMAPE Haut-Lomami</span>
                <div class="flex gap-4">
                    <i class="fab fa-facebook-f text-gray-400 hover:text-yellow-500 transition cursor-pointer text-xs"></i>
                    <i class="fab fa-twitter text-gray-400 hover:text-yellow-500 transition cursor-pointer text-xs"></i>
                    <i class="fab fa-linkedin-in text-gray-400 hover:text-yellow-500 transition cursor-pointer text-xs"></i>
                </div>
                <span class="text-[8px] font-black uppercase tracking-[0.2em] text-yellow-500">Sagesse • Analyse • Modernisation</span>
            </div>
        </div>
    </footer>

    <script>
        // ========== NAVBAR SCROLL EFFECT ==========
        const navbar = document.getElementById('navbar');
        const navLinks = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('section');

        window.addEventListener('scroll', () => {
            // Navbar effect
            if (window.scrollY > 50) {
                navbar.querySelector('.glass-premium').classList.add('bg-black/60', 'backdrop-blur-xl');
            } else {
                navbar.querySelector('.glass-premium').classList.remove('bg-black/60', 'backdrop-blur-xl');
            }

            // Active link detection
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (window.scrollY >= (sectionTop - 200)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').includes(current)) {
                    link.classList.add('active');
                }
            });
        });

        // ========== REVEAL ON SCROLL ==========
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

        document.querySelectorAll('.reveal-up, .reveal-right').forEach(el => observer.observe(el));

        // ========== SMOOTH SCROLL FOR NAV LINKS ==========
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.getAttribute('href');
                const target = document.querySelector(targetId);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // ========== PAGE LOAD FADE IN ==========
        document.body.style.opacity = '0';
        document.body.style.transition = 'opacity 0.4s ease';
        window.addEventListener('load', () => { document.body.style.opacity = '1'; });
        setTimeout(() => { document.body.style.opacity = '1'; }, 100);
    </script>
</body>
</html>