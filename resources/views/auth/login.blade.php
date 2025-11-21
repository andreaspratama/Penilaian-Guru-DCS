<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>

        /* 🔮 Gradient Mesh Aesthetic */
        body {
            background: radial-gradient(circle at 20% 20%, #7c3aed, transparent 40%),
                        radial-gradient(circle at 80% 80%, #ec4899, transparent 45%),
                        radial-gradient(circle at 50% 50%, #4f46e5, transparent 40%),
                        #0f0f1a;
            background-size: 200% 200%;
            animation: bgMove 14s ease-in-out infinite;
        }

        @keyframes bgMove {
            0% { background-position: 0% 0%; }
            50% { background-position: 100% 100%; }
            100% { background-position: 0% 0%; }
        }

        /* 🌟 Floating Particles */
        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: white;
            border-radius: 50%;
            opacity: 0.7;
            animation: floatParticle 12s linear infinite;
        }

        @keyframes floatParticle {
            from { transform: translateY(0) translateX(0); opacity: 0.2; }
            to { transform: translateY(-100vh) translateX(20px); opacity: 0; }
        }

        /* 🫧 Glass card premium */
        .glass-card {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255,255,255,0.15);
            box-shadow: 0 10px 40px rgba(0, 0, 0, .4);
        }

        /* Neon glow button */
        .glow-btn {
            background: linear-gradient(135deg, #a855f7, #ec4899);
            box-shadow: 0 0 20px rgba(236, 72, 153, .7);
            transition: .3s;
        }
        .glow-btn:hover {
            box-shadow: 0 0 30px rgba(168, 85, 247, .9);
            transform: translateY(-3px);
        }

        /* Fade-in smooth */
        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(25px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeSlide 0.8s ease forwards;
        }

    </style>
</head>

<body class="min-h-screen flex items-center justify-center overflow-hidden relative">

    <!-- Particle Background -->
    @for ($i = 0; $i < 25; $i++)
        <div class="particle"
             style="left: {{ rand(0, 100) }}%; 
                    top: {{ rand(0, 100) }}%;
                    animation-duration: {{ rand(8, 15) }}s;
                    animation-delay: -{{ rand(0, 10) }}s;">
        </div>
    @endfor

    <!-- Login Card -->
    <div class="glass-card p-10 rounded-3xl w-full max-w-md fade-in">

        <h1 class="text-center text-4xl font-extrabold text-white tracking-wide mb-6 drop-shadow-lg">
            🔐 LOGIN SYSTEM
        </h1>

        @if (session('error'))
        <div class="mb-4 text-red-300 bg-red-900/40 p-3 rounded-lg border border-red-500/30">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{route('prosLogin')}}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="text-white tracking-wide">Username</label>
                <input type="username" name="email"
                       class="w-full mt-1 px-4 py-3 rounded-xl bg-white/10 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-pink-400/60"
                       placeholder="Masukkan username kamu" required>
            </div>

            <div>
                <label class="text-white tracking-wide">Password</label>
                <input type="password" name="password"
                       class="w-full mt-1 px-4 py-3 rounded-xl bg-white/10 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-purple-400/60"
                       placeholder="Masukkan password" required>
            </div>

            <button 
                class="w-full glow-btn py-3 rounded-xl text-white font-semibold tracking-wide text-lg">
                Login
            </button>
        </form>

        <p class="text-center text-white/60 text-sm mt-6">
            DCS • {{ date('Y') }}
        </p>

    </div>

</body>
</html>
