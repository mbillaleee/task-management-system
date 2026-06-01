@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    Pricing
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Choose the right plan for your productivity journey.
                </p>
            </div>

            <div class="flex items-center gap-2 p-1 rounded-[12px] dark:bg-white/[0.06] bg-gray-100">
                <button type="button" id="monthlyBtn" onclick="changePricing('monthly')"
                    class="pricing-toggle active px-4 py-2 rounded-[10px] text-[12px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500">
                    Monthly
                </button>

                <button type="button" id="yearlyBtn" onclick="changePricing('yearly')"
                    class="pricing-toggle px-4 py-2 rounded-[10px] text-[12px] font-bold dark:text-gray-400 text-gray-500">
                    Yearly
                </button>
            </div>
        </div>

        {{-- Hero --}}
        <div
            class="relative overflow-hidden rounded-2xl border dark:border-white/[0.07] border-black/[0.07]
        dark:bg-[#17141f] bg-white p-6 md:p-8 hover-lift">

            <div class="absolute top-0 right-0 w-72 h-72 bg-pink-500 blur-[100px] opacity-20"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-orange-500 blur-[100px] opacity-20"></div>

            <div class="relative z-10 max-w-2xl">
                <span
                    class="px-3 py-1 rounded-full text-[11px] font-bold
                bg-orange-500/[0.15] text-orange-400 border border-orange-500/20">
                    Simple & Transparent Pricing
                </span>

                <h1
                    class="text-[24px] sm:text-[32px] md:text-[44px] leading-tight font-extrabold tracking-[-1.4px] mt-5 dark:text-white text-gray-900">
                    Start free. <br>
                    <span class="bg-gradient-to-r from-orange-400 to-pink-500 bg-clip-text text-transparent">
                        Upgrade when you grow.
                    </span>
                </h1>

                <p class="text-[14px] md:text-[14px] dark:text-gray-400 text-gray-500 mt-4 leading-relaxed">
                    Manage your tasks, habits, notes, focus sessions and analytics with flexible plans for every workflow.
                </p>
            </div>
        </div>

        {{-- Pricing Cards --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Free --}}
            <div
                class="hover-lift relative overflow-hidden dark:bg-[#17141f] bg-white border dark:border-white/[0.07]
            border-black/[0.07] rounded-2xl p-[22px]">

                <div class="absolute top-0 right-0 w-24 h-24 bg-gray-500 blur-3xl opacity-20"></div>

                <div class="relative z-10">
                    <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900">Free</h3>
                    <p class="text-[14px] dark:text-gray-500 text-gray-500 mt-1">
                        Best for getting started.
                    </p>

                    <div class="mt-6">
                        <span class="text-[38px] font-extrabold dark:text-white text-gray-900">$0</span>
                        <span class="text-[12px] dark:text-gray-500 text-gray-500">/month</span>
                    </div>

                    <a href="{{ route('user.tasks.index') }}"
                        class="mt-6 block text-center px-4 py-2.5 rounded-[10px] text-[12.5px] font-bold
                    dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                        Start Free
                    </a>

                    <div class="space-y-3 mt-6">
                        @foreach (['Basic dashboard', 'Up to 20 tasks', 'Basic habit tracking', 'Simple notes', 'Light & dark mode'] as $feature)
                            <div class="flex items-center gap-2.5">
                                <span class="text-emerald-400 text-[13px]">✓</span>
                                <p class="text-[12.5px] dark:text-gray-400 text-gray-500">{{ $feature }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Pro --}}
            <div
                class="hover-lift relative overflow-hidden dark:bg-[#17141f] bg-white border border-orange-500/40
            rounded-2xl p-[22px] shadow-[0_0_40px_rgba(249,115,22,0.18)]">

                <div class="absolute top-0 right-0 w-32 h-32 bg-pink-500 blur-3xl opacity-25"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-orange-500 blur-3xl opacity-25"></div>

                <div
                    class="absolute top-4 right-4 px-2.5 py-[4px] rounded-lg text-[11px] font-bold
                bg-gradient-to-r from-orange-500 to-pink-500 text-white">
                    Popular
                </div>

                <div class="relative z-10">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900">Pro</h3>
                    <p class="text-[12.5px] dark:text-gray-500 text-gray-500 mt-1">
                        For serious productivity users.
                    </p>

                    <div class="mt-6">
                        <span id="proPrice" class="text-[38px] font-extrabold dark:text-white text-gray-900">$9</span>
                        <span id="proPeriod" class="text-[12px] dark:text-gray-500 text-gray-500">/month</span>
                    </div>

                    <a href="#"
                        class="mt-6 block text-center px-4 py-2.5 rounded-[10px] text-white text-[12.5px] font-bold
                    bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                        Upgrade to Pro
                    </a>

                    <div class="space-y-3 mt-6">
                        @foreach (['Unlimited tasks', 'Advanced habit tracking', 'Kanban & calendar view', 'Focus timer', 'XP levels & streaks', 'Advanced analytics', 'Priority support'] as $feature)
                            <div class="flex items-center gap-2.5">
                                <span class="text-orange-400 text-[13px]">✓</span>
                                <p class="text-[12.5px] dark:text-gray-300 text-gray-600">{{ $feature }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Team --}}
            <div
                class="hover-lift relative overflow-hidden dark:bg-[#17141f] bg-white border dark:border-white/[0.07]
            border-black/[0.07] rounded-2xl p-[22px]">

                <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500 blur-3xl opacity-20"></div>

                <div class="relative z-10">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900">Team</h3>
                    <p class="text-[12.5px] dark:text-gray-500 text-gray-500 mt-1">
                        For teams and workspaces.
                    </p>

                    <div class="mt-6">
                        <span id="teamPrice" class="text-[38px] font-extrabold dark:text-white text-gray-900">$19</span>
                        <span id="teamPeriod" class="text-[12px] dark:text-gray-500 text-gray-500">/month</span>
                    </div>

                    <a href="#"
                        class="mt-6 block text-center px-4 py-2.5 rounded-[10px] text-[12.5px] font-bold
                    dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                        Contact Sales
                    </a>

                    <div class="space-y-3 mt-6">
                        @foreach (['Everything in Pro', 'Team workspace', 'Shared projects', 'Team analytics', 'Role permissions', 'Cloud sync', 'Admin controls'] as $feature)
                            <div class="flex items-center gap-2.5">
                                <span class="text-emerald-400 text-[13px]">✓</span>
                                <p class="text-[12.5px] dark:text-gray-400 text-gray-500">{{ $feature }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        {{-- Compare / FAQ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[15px] font-bold dark:text-white text-gray-900 mb-4">
                    What’s included?
                </h3>

                <div class="space-y-3">
                    @foreach (['Task management with labels and subtasks', 'Habit streak and daily completion tracking', 'Focus sessions and productivity insights', 'XP progress, levels and activity history'] as $item)
                        <div
                            class="flex items-start gap-3 py-2 border-b last:border-b-0 dark:border-white/[0.06] border-black/[0.05]">
                            <span class="text-orange-400">✓</span>
                            <p class="text-[12.5px] dark:text-gray-400 text-gray-500">{{ $item }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[15px] font-bold dark:text-white text-gray-900 mb-4">
                    Frequently Asked
                </h3>

                <div class="space-y-3">
                    <div>
                        <p class="text-[12.5px] font-bold dark:text-gray-200 text-gray-800">
                            Can I start for free?
                        </p>
                        <p class="text-[12px] dark:text-gray-500 text-gray-500 mt-1">
                            Yes, the free plan is available for basic productivity tracking.
                        </p>
                    </div>

                    <div>
                        <p class="text-[12.5px] font-bold dark:text-gray-200 text-gray-800">
                            Can I upgrade later?
                        </p>
                        <p class="text-[12px] dark:text-gray-500 text-gray-500 mt-1">
                            Yes, you can upgrade to Pro anytime when you need advanced features.
                        </p>
                    </div>

                    <div>
                        <p class="text-[12.5px] font-bold dark:text-gray-200 text-gray-800">
                            Is my data private?
                        </p>
                        <p class="text-[12px] dark:text-gray-500 text-gray-500 mt-1">
                            Your tasks, notes and analytics stay protected inside your workspace.
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </section>


    <script>
        function changePricing(type) {
            const monthlyBtn = document.getElementById('monthlyBtn');
            const yearlyBtn = document.getElementById('yearlyBtn');

            const proPrice = document.getElementById('proPrice');
            const proPeriod = document.getElementById('proPeriod');
            const teamPrice = document.getElementById('teamPrice');
            const teamPeriod = document.getElementById('teamPeriod');

            const activeClass = 'text-white bg-gradient-to-r from-orange-500 to-pink-500';
            const inactiveClass = 'dark:text-gray-400 text-gray-500';

            if (type === 'monthly') {
                proPrice.innerText = '$9';
                proPeriod.innerText = '/month';

                teamPrice.innerText = '$19';
                teamPeriod.innerText = '/month';

                monthlyBtn.className = 'px-4 py-2 rounded-[10px] text-[12px] font-bold ' + activeClass;
                yearlyBtn.className = 'px-4 py-2 rounded-[10px] text-[12px] font-bold ' + inactiveClass;
            } else {
                proPrice.innerText = '$90';
                proPeriod.innerText = '/year';

                teamPrice.innerText = '$190';
                teamPeriod.innerText = '/year';

                yearlyBtn.className = 'px-4 py-2 rounded-[10px] text-[12px] font-bold ' + activeClass;
                monthlyBtn.className = 'px-4 py-2 rounded-[10px] text-[12px] font-bold ' + inactiveClass;
            }
        }
    </script>
@endsection
