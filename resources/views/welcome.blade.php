<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veroa Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>

<body class="transition-colors duration-500 bg-gray-50 dark:bg-gray-900">
    <div class="flex min-h-screen">
        <!-- Left side (promo) -->
        <div
            class="hidden lg:flex w-1/2 flex-col justify-center items-start p-16 bg-gradient-to-br from-orange-400 to-pink-500 dark:from-purple-900 dark:to-pink-700 text-white relative overflow-hidden">
            <h1 class="text-5xl font-extrabold mb-4">One system.<br><span class="text-yellow-400">Infinite
                    potential.</span></h1>
            <p class="mb-8 text-lg">Veroa is your all-in-one productivity hub.<br>Tasks, habits, notes, focus timers,
                tools & analytics – everything you need to become your best self.</p>

            <div class="flex flex-col gap-6">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-full bg-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">All-in-One</p>
                        <p class="text-sm">Everything you need in one powerful workspace.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-full bg-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Focus First</p>
                        <p class="text-sm">Built to eliminate distractions and help you go deep.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-full bg-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-6h6v6m-6 0V9h6v8" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Data Driven</p>
                        <p class="text-sm">Analytics that help you improve every day.</p>
                    </div>
                </div>
            </div>

            <!-- glowing blob -->
            <div
                class="absolute -bottom-16 -left-16 w-64 h-64 bg-gradient-to-tr from-yellow-300 to-pink-400 rounded-full opacity-30 blur-3xl animate-pulse">
            </div>
        </div>

        <!-- Right side (login form) -->
        <div class="flex-1 flex flex-col justify-center items-center p-10">
            <!-- Mode toggle -->
            <div class="flex justify-end w-full mb-8 gap-2">
                <button id="lightBtn"
                    class="px-4 py-2 rounded-full bg-yellow-400 text-white font-semibold shadow-lg hover:scale-105 transition-transform">Light</button>
                <button id="darkBtn"
                    class="px-4 py-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white font-semibold shadow-lg hover:scale-105 transition-transform">Dark</button>
            </div>

            <div
                class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-10 transition-colors duration-500">
                <h2 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">Welcome back 👋</h2>
                <p class="text-gray-500 dark:text-gray-300 mb-6">Log in to continue your productivity journey.</p>

                <form class="flex flex-col gap-5">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-1 font-semibold">Email address</label>
                        <input type="email" placeholder="Enter your email"
                            class="w-full px-5 py-3 rounded-xl border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-orange-400 focus:outline-none dark:bg-gray-700 dark:text-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-1 font-semibold">Password</label>
                        <div class="relative">
                            <input type="password" placeholder="Enter your password"
                                class="w-full px-5 py-3 rounded-xl border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-orange-400 focus:outline-none dark:bg-gray-700 dark:text-white transition-colors">
                            <span class="absolute right-4 top-3 cursor-pointer text-gray-400">👁️</span>
                        </div>
                        <a href="#" class="text-orange-500 text-sm mt-1 inline-block">Forgot password?</a>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="remember"
                            class="w-4 h-4 text-orange-400 border-gray-300 rounded focus:ring-orange-400">
                        <label for="remember" class="text-gray-700 dark:text-gray-300 text-sm">Remember me</label>
                    </div>

                    <button type="submit"
                        class="w-full py-3 mt-4 bg-gradient-to-r from-orange-400 to-pink-500 text-white rounded-xl font-semibold shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">Log
                        in</button>
                </form>

                <p class="text-center text-gray-400 my-5">or continue with</p>

                <div class="flex flex-col gap-3">
                    <button
                        class="w-full py-3 border rounded-xl flex items-center justify-center gap-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg"
                            class="w-5 h-5" /> Continue with Google
                    </button>
                    <button
                        class="w-full py-3 border rounded-xl flex items-center justify-center gap-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/apple/apple-original.svg"
                            class="w-5 h-5" /> Continue with Apple
                    </button>
                    <button
                        class="w-full py-3 border rounded-xl flex items-center justify-center gap-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/microsoft/microsoft-original.svg"
                            class="w-5 h-5" /> Continue with Microsoft
                    </button>
                </div>

                <p class="text-center text-gray-500 mt-6">Don't have an account? <a href="#"
                        class="text-orange-500 font-semibold">Sign up</a></p>
            </div>
        </div>
    </div>

    <script>
        const lightBtn = document.getElementById('lightBtn');
        const darkBtn = document.getElementById('darkBtn');
        const html = document.documentElement;

        lightBtn.addEventListener('click', () => html.classList.remove('dark'));
        darkBtn.addEventListener('click', () => html.classList.add('dark'));
    </script>
</body>

</html>
