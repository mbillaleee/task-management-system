<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Veroa – One system. Infinite potential.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />


    <!-- Font Awesome Free CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        brand: {
                            orange: '#f97316',
                            pink: '#ec4899',
                            amber: '#f59e0b'
                        },
                        dark: {
                            page: '#0d0b14',
                            sidebar: '#100e1a',
                            card: '#17141f',
                            card2: '#1a1625',
                            border: 'rgba(255,255,255,0.07)',
                        },
                        light: {
                            page: '#f0e8dc',
                            sidebar: '#fdf6ee',
                            card: '#ffffff',
                            card2: '#fef8f2',
                            border: 'rgba(0,0,0,0.07)',
                        }
                    },
                    keyframes: {
                        floatY: {
                            '0%,100%': {
                                transform: 'translateY(0px)'
                            },
                            '50%': {
                                transform: 'translateY(-14px)'
                            }
                        },
                        pulseGlow: {
                            '0%,100%': {
                                opacity: '0.5'
                            },
                            '50%': {
                                opacity: '1'
                            }
                        },
                    },
                    animation: {
                        floatY: 'floatY 4s ease-in-out infinite',
                        pulseGlow: 'pulseGlow 5s ease-in-out infinite',
                    },
                    boxShadow: {
                        'orange-glow': '0 0 24px rgba(249,115,22,0.45)',
                        'pink-glow': '0 0 20px rgba(236,72,153,0.35)',
                        'card-dark': '0 4px 24px rgba(0,0,0,0.4)',
                        'card-light': '0 2px 16px rgba(0,0,0,0.08)',
                    }
                }
            }
        }
    </script>

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: rgba(249, 115, 22, 0.3);
            border-radius: 8px;
        }

        .light ::-webkit-scrollbar-thumb {
            background: rgba(234, 88, 12, 0.3);
            border-radius: 8px;
        }

        /* Gradient text */
        .grad-text-dark {
            background: linear-gradient(90deg, #f97316, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .grad-text-light {
            background: linear-gradient(90deg, #ea580c, #d97706);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Neon glow */
        .hero-svg-dark {
            filter: drop-shadow(0 0 28px rgba(249, 115, 22, 0.7)) drop-shadow(0 0 60px rgba(236, 72, 153, 0.4));
        }

        .hero-svg-light {
            filter: drop-shadow(0 0 26px rgba(245, 158, 11, 0.65)) drop-shadow(0 0 50px rgba(249, 115, 22, 0.4));
        }

        /* SVG ring transform */
        .ring-svg {
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        /* Sidebar mobile */
        @media (max-width: 1023px) {
            #sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                position: fixed;
            }

            #sidebar.open {
                transform: translateX(0);
            }
        }

        /* Sidebar active gradient line */
        .nav-active-dark {
            background: linear-gradient(90deg, rgba(249, 115, 22, 0.18) 0%, rgba(249, 115, 22, 0.04) 100%);
            border-left: 3px solid #f97316;
        }

        .nav-active-light {
            background: linear-gradient(90deg, rgba(234, 88, 12, 0.14) 0%, rgba(234, 88, 12, 0.03) 100%);
            border-left: 3px solid #ea580c;
        }

        /* Remove default nav border placeholder */
        .nav-item {
            border-left: 3px solid transparent;
        }

        /* Chart canvas fix */
        .chart-container {
            position: relative;
        }

        /* Upgrade card */
        .upgrade-dark {
            background: linear-gradient(135deg, #1c1030 0%, #1e110a 100%);
        }

        .upgrade-light {
            background: linear-gradient(135deg, #fff7ed 0%, #fef3c7 100%);
        }

        /* Hero bg */
        .hero-dark {
            background: linear-gradient(135deg, #1e0f35 0%, #130d24 50%, #1c0f14 100%);
        }

        .hero-light {
            background: linear-gradient(135deg, #fffaf4 0%, #fffbf5 60%, #fff8f0 100%);
        }

        /* Progress ring circle */
        .progress-circle {
            transition: stroke-dashoffset 0.8s ease;
        }

        /* Hover lift */
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
        }

        /* Btn transition */
        .btn-trans {
            transition: opacity 0.18s, transform 0.15s;
        }

        .btn-trans:hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }
    </style>
</head>

<body class="dark:bg-[#0d0b14] bg-[#f0e8dc] min-h-screen overflow-x-hidden transition-colors duration-300">

    <!-- ── Ambient Orbs (dark mode) ── -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden dark:block hidden">
        <div class="absolute w-[420px] h-[420px] rounded-full -top-20 left-1/3 animate-pulseGlow"
            style="background:radial-gradient(circle, rgba(249,115,22,0.18) 0%, transparent 65%); filter:blur(60px);">
        </div>
        <div class="absolute w-[360px] h-[360px] rounded-full bottom-1/4 right-1/4 animate-pulseGlow"
            style="background:radial-gradient(circle, rgba(236,72,153,0.14) 0%, transparent 65%); filter:blur(60px); animation-delay:2.5s;">
        </div>
    </div>

    <!-- ── Mobile overlay ── -->
    <div id="overlay" onclick="closeSidebar()"
        class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden backdrop-blur-sm"></div>

    <!-- ═══════════════════════════════════════
        SIDEBAR
    ═══════════════════════════════════════ -->
    @include('user.layouts.aside')

    <!-- ═══════════════════════════════════════
        MAIN WRAPPER
    ═══════════════════════════════════════ -->
    <div class="lg:ml-64 flex flex-col min-h-screen relative z-10">

        <!-- ─── HEADER ─── -->
        @include('user.layouts.navbar')

        <!-- ─── MAIN CONTENT ─── -->
        <main class="flex-1 p-4 sm:p-5 flex flex-col gap-4">

            @yield('user')

            <!-- bottom spacing -->
            <div class="h-5"></div>
        </main>
    </div>

    <script>
        let currentTheme = localStorage.getItem('veroa-theme') || 'dark';
        let prodChart = null;

        function getChartCfg() {
            const dark = document.documentElement.classList.contains('dark');

            return {
                grid: dark ? 'rgba(255,255,255,0.04)' : 'rgba(0,0,0,0.05)',
                tick: dark ? 'rgba(255,255,255,0.35)' : 'rgba(0,0,0,0.4)',
                line2: dark ? 'rgba(245,158,11,0.6)' : 'rgba(245,158,11,0.75)',
                tooltipBg: dark ? '#1a1625' : '#ffffff',
                tooltipColor: dark ? '#ffffff' : '#111827',
            };
        }

        function buildProductivityChart() {
            const canvas = document.getElementById('productivityChart');

            if (!canvas || typeof Chart === 'undefined') return;

            if (prodChart) {
                prodChart.destroy();
                prodChart = null;
            }

            const cfg = getChartCfg();
            const ctx = canvas.getContext('2d');

            const grad1 = ctx.createLinearGradient(0, 0, 0, 130);
            grad1.addColorStop(0, 'rgba(249,115,22,0.30)');
            grad1.addColorStop(1, 'rgba(249,115,22,0.01)');

            const grad2 = ctx.createLinearGradient(0, 0, 0, 130);
            grad2.addColorStop(0, 'rgba(245,158,11,0.22)');
            grad2.addColorStop(1, 'rgba(245,158,11,0.01)');

            prodChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                            label: 'This week',
                            data: [38, 52, 46, 64, 90, 70, 82],
                            borderColor: '#f97316',
                            backgroundColor: grad1,
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.45,
                            pointRadius: 3.5,
                            pointBackgroundColor: '#f97316',
                            pointBorderColor: 'transparent',
                            pointHoverRadius: 5,
                        },
                        {
                            label: 'Last week',
                            data: [28, 40, 35, 52, 60, 55, 62],
                            borderColor: cfg.line2,
                            backgroundColor: grad2,
                            borderWidth: 2,
                            fill: true,
                            tension: 0.45,
                            pointRadius: 2.5,
                            pointBackgroundColor: '#f59e0b',
                            pointBorderColor: 'transparent',
                            pointHoverRadius: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: cfg.tooltipBg,
                            titleColor: cfg.tooltipColor,
                            bodyColor: cfg.tooltipColor,
                            borderColor: 'rgba(249,115,22,0.3)',
                            borderWidth: 1,
                            padding: 10,
                            cornerRadius: 10,
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: cfg.grid,
                                drawBorder: false
                            },
                            ticks: {
                                color: cfg.tick,
                                font: {
                                    size: 11,
                                    family: 'Inter'
                                }
                            },
                            border: {
                                display: false
                            }
                        },
                        y: {
                            min: 0,
                            max: 100,
                            grid: {
                                color: cfg.grid,
                                drawBorder: false
                            },
                            ticks: {
                                color: cfg.tick,
                                stepSize: 25,
                                font: {
                                    size: 11,
                                    family: 'Inter'
                                }
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        function setTheme(mode) {
            currentTheme = mode;

            const html = document.documentElement;
            const upgradeCard = document.getElementById('upgradeCard');

            if (mode === 'dark') {
                html.classList.remove('light');
                html.classList.add('dark');

                if (upgradeCard) {
                    upgradeCard.classList.add('upgrade-dark');
                    upgradeCard.classList.remove('upgrade-light');
                }
            } else {
                html.classList.remove('dark');
                html.classList.add('light');

                if (upgradeCard) {
                    upgradeCard.classList.remove('upgrade-dark');
                    upgradeCard.classList.add('upgrade-light');
                }
            }

            localStorage.setItem('veroa-theme', mode);
            buildProductivityChart();
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            if (sidebar) sidebar.classList.toggle('open');
            if (overlay) overlay.classList.toggle('hidden');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            if (sidebar) sidebar.classList.remove('open');
            if (overlay) overlay.classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            setTheme(currentTheme);
        });
    </script>
</body>

</html>
