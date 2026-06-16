<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veroa Authentication</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    <style>
        .veroa-card {
            background: rgba(255, 239, 213, 0.55);
            border: 1px solid rgba(255, 150, 30, 0.18);
            box-shadow: 0 18px 45px rgba(180, 95, 20, 0.10), inset 0 1px 0 rgba(255, 255, 255, .35);
            backdrop-filter: blur(18px);
        }

        .dark .veroa-card {
            background: #0f0a1c;
            border: 1px solid rgba(236, 72, 153, 0.16);
            box-shadow: none;
        }

        .veroa-panel {
            background: rgba(255, 238, 210, 0.42);
            border: 1px solid rgba(255, 160, 40, 0.18);
            backdrop-filter: blur(22px);
        }

        .dark .veroa-panel {
            background: rgba(8, 7, 19, 0.72);
            border: 1px solid rgba(255, 47, 168, 0.15);
        }
    </style>
</head>

<body
    class="transition-colors duration-500 bg-gray-50 dark:border-pink-500/15 bg-[#f7e4c3]/75
            dark:bg-[#080612]  backdrop-blur-xl  p-6  space-y-6
            shadow-[inset_0_1px_0_rgba(255,255,255,.65),0_20px_50px_rgba(180,95,20,.12),0_8px_20px_rgba(255,140,20,.08)]
            dark:shadow-[inset_0_1px_0_rgba(255,255,255,.03)] flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-10 bg-white veroa-card rounded-2xl shadow-2xl transition-colors duration-500">

        <img src="{{ asset('images/logo.png') }}" alt="" style="width: 100px; height: auto;"
            class="mx-auto mb-6">
        <form id="registerForm" class="flex flex-col gap-5" action="{{ route('register') }}" method="POST">
            @csrf
            <h2 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white text-center">Create Account</h2>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1 font-semibold">Name</label>
                <input type="text" placeholder="Enter your full name" name="name" required
                    class="w-full px-5 py-3 rounded-xl border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-orange-400 focus:outline-none transition-colors">
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1 font-semibold">Email address</label>
                <input type="email" placeholder="Enter your email" name="email" required
                    class="w-full px-5 py-3 rounded-xl border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-orange-400 focus:outline-none transition-colors">
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1 font-semibold">Password</label>
                <div class="relative">
                    <input id="passwordInput" type="password" placeholder="Enter password" name="password" required
                        class="w-full px-5 py-3 pr-12 rounded-xl border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-orange-400 focus:outline-none transition-colors">

                    <button type="button" onclick="togglePassword('passwordInput', 'passwordIcon')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-400 transition-colors">
                        <i id="passwordIcon" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1 font-semibold">Confirm Password</label>
                <div class="relative">
                    <input id="confirmPasswordInput" type="password" placeholder="Confirm password"
                        name="password_confirmation" required
                        class="w-full px-5 py-3 pr-12 rounded-xl border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-orange-400 focus:outline-none transition-colors">

                    <button type="button" onclick="togglePassword('confirmPasswordInput', 'confirmPasswordIcon')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-400 transition-colors">
                        <i id="confirmPasswordIcon" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full py-3 mt-4 bg-gradient-to-r from-orange-400 to-pink-500 text-white rounded-xl font-semibold shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                Register
            </button>

            <p class="text-center text-gray-500 mt-4 text-sm">Already have an account?
                <a href="{{ route('welcome') }}" id="showLogin" class="text-orange-500 font-semibold cursor-pointer">Log
                    in</a>
            </p>
        </form>
    </div>

    <script>
        // Force dark mode
        document.documentElement.classList.add('dark');
    </script>

    <script>
        document.documentElement.classList.add('dark');

        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            const isPassword = input.type === 'password';

            input.type = isPassword ? 'text' : 'password';

            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    </script>

</body>

</html>
