<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <title>Focus Mode</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#0f0c16] text-white overflow-hidden">

    @php
        $seconds = max(1, $focus->duration_minutes * 60);
    @endphp

    <section class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-3xl text-center space-y-8">

            <div>
                <p class="text-[14px] text-gray-500 font-bold uppercase tracking-[3px]">
                    Distraction Free Focus Mode
                </p>

                <h1 class="text-[32px] md:text-[42px] font-extrabold mt-3">
                    {{ $focus->title ?? 'Untitled Session' }}
                </h1>

                <p class="text-[15px] text-gray-400 mt-2">
                    {{ ucwords(str_replace('_', ' ', $focus->type)) }} •
                    {{ ucwords(str_replace('_', ' ', $focus->ambient_sound ?? 'none')) }}
                </p>
            </div>

            <div
                class="relative mx-auto w-[260px] h-[260px] md:w-[340px] md:h-[340px] rounded-full border border-white/[0.08] bg-white/[0.04] flex items-center justify-center shadow-[0_0_80px_rgba(249,115,22,0.18)]">
                <div
                    class="absolute inset-0 rounded-full bg-gradient-to-r from-orange-500 to-pink-500 blur-3xl opacity-20">
                </div>

                <div class="relative z-10">
                    <h2 id="timerText" class="text-[54px] md:text-[72px] font-extrabold tracking-[-2px]">
                        {{ str_pad($focus->duration_minutes, 2, '0', STR_PAD_LEFT) }}:00
                    </h2>
                    <p class="text-[14px] text-gray-500 font-bold mt-2">
                        {{ ucfirst($focus->status) }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap justify-center gap-3">
                <button onclick="startTimer()"
                    class="px-6 py-3 rounded-[12px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    Start
                </button>

                <button onclick="pauseTimer()"
                    class="px-6 py-3 rounded-[12px] text-[14px] font-bold bg-white/[0.07] text-gray-300">
                    Pause
                </button>

                <button onclick="resetTimer()"
                    class="px-6 py-3 rounded-[12px] text-[14px] font-bold bg-white/[0.07] text-gray-300">
                    Reset
                </button>

                <a href="{{ route('user.focus.show', $focus->id) }}"
                    class="px-6 py-3 rounded-[12px] text-[14px] font-bold bg-red-500/[0.15] text-red-400">
                    Exit
                </a>
            </div>

            @if ($focus->ambient_sound && $focus->ambient_sound !== 'none')
                <div class="max-w-md mx-auto">
                    <audio controls loop class="w-full">
                        <source src="{{ asset('sounds/' . str_replace('_', '-', $focus->ambient_sound) . '.mp3') }}">
                    </audio>
                </div>
            @endif

        </div>
    </section>

    <script>
        let totalSeconds = {{ $seconds }};
        let remainingSeconds = totalSeconds;
        let timer = null;

        function renderTimer() {
            let minutes = Math.floor(remainingSeconds / 60);
            let seconds = remainingSeconds % 60;

            document.getElementById('timerText').innerText =
                String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
        }

        function startTimer() {
            if (timer) return;

            timer = setInterval(() => {
                if (remainingSeconds > 0) {
                    remainingSeconds--;
                    renderTimer();
                } else {
                    clearInterval(timer);
                    timer = null;
                }
            }, 1000);
        }

        function pauseTimer() {
            clearInterval(timer);
            timer = null;
        }

        function resetTimer() {
            clearInterval(timer);
            timer = null;
            remainingSeconds = totalSeconds;
            renderTimer();
        }
    </script>

</body>

</html>
