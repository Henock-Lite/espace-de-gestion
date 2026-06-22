<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="min-h-screen bg-[#07130c] flex items-center justify-center p-6">

        <!-- Background Blur -->
        <div class="absolute w-72 h-72 bg-green-500/20 rounded-full blur-3xl top-10 left-10"></div>
        <div class="absolute w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl bottom-10 right-10"></div>

        <!-- Login Card -->
        <div
            class="relative w-full max-w-md overflow-hidden rounded-[32px] border border-white/10 bg-white/5 backdrop-blur-2xl shadow-[0_0_60px_rgba(0,255,120,0.15)]">

            <!-- Top Accent -->
            <div class="h-2 w-full bg-gradient-to-r from-green-400 via-emerald-500 to-green-600"></div>
            <div class="p-10">
                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-green-400 blur-xl opacity-40 rounded-full"></div>
                        <div 
                            class="relative w-20 h-20 rounded-3xl bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center shadow-2xl shadow-green-500/30">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>

                        </div>

                    </div>

                </div>

                <!-- Text -->
                <div class="text-center mb-8">

                    <h1 class="text-4xl font-extrabold text-white tracking-tight">
                        Espace Pharmacie
                    </h1>

                    <p class="text-green-100/70 mt-3 text-sm">
                        Connexion sécurisée à votre plateforme
                    </p>

                </div>

                <!-- Form -->
                <form class="space-y-5">
                    <!-- Email -->
                    <div>
                        <label class="block text-sm text-green-100 mb-2">
                            Adresse e‑mail
                        </label>

                        <div class="relative">
                            <input type="email" placeholder="admin@pharmacy.com"
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-5 py-4 text-white placeholder:text-green-100/40 outline-none transition focus:border-green-400 focus:ring-4 focus:ring-green-500/20">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm text-green-100 mb-2">
                            Mot de passe
                        </label>

                        <input type="password" placeholder="••••••••"
                            class="w-full rounded-2xl border border-white/10 bg-white/5 px-5 py-4 text-white placeholder:text-green-100/40 outline-none transition focus:border-green-400 focus:ring-4 focus:ring-green-500/20">
                    </div>

                    <!-- Row -->
                    {{-- <div class="flex items-center justify-between text-sm">

          <label class="flex items-center gap-2 text-green-100/80">

            <input
              type="checkbox"
              class="checkbox checkbox-success checkbox-sm"
            >

            Remember me

          </label>

          <a
            href="#"
            class="text-green-300 hover:text-green-200 transition"
          >
            Forgot Password?
          </a>

        </div> --}}

                    <!-- Button -->
                    <button
                        class="group relative w-full overflow-hidden rounded-2xl bg-gradient-to-r from-green-500 to-emerald-600 py-4 font-semibold text-white transition duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-green-500/30 cursor-pointer">

                        <span class="relative z-10">
                            Se connecter
                        </span>

                        <div class="absolute inset-0 bg-white/10 opacity-0 transition group-hover:opacity-100"></div>

                    </button>

                </form>

            </div>

        </div>

    </div>
</body>

</html>
