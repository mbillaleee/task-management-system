<div
    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-[16px] font-bold dark:text-white text-gray-900">
            Timer Controls
        </h3>

        <span
            class="px-2.5 py-[4px] rounded-lg text-[13px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
            {{ $focus->duration_minutes }} min
        </span>
    </div>

    <div class="flex flex-wrap gap-2">
        @if ($focus->status === 'pending' || $focus->status === 'paused')
            <form action="{{ route('user.focus.start', $focus->id) }}" method="POST">
                @csrf
                <button
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    Start
                </button>
            </form>
        @endif

        @if ($focus->status === 'running')
            <form action="{{ route('user.focus.pause', $focus->id) }}" method="POST">
                @csrf
                <button
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-yellow-500/[0.15] bg-yellow-50 text-yellow-500">
                    Pause
                </button>
            </form>

            <form action="{{ route('user.focus.complete', $focus->id) }}" method="POST">
                @csrf
                <button
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-emerald-500/[0.15] bg-emerald-50 text-emerald-500">
                    Complete
                </button>
            </form>
        @endif

        @if (!in_array($focus->status, ['completed', 'cancelled']))
            <form action="{{ route('user.focus.cancel', $focus->id) }}" method="POST">
                @csrf
                <button
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-red-500/[0.15] bg-red-50 text-red-500">
                    Cancel
                </button>
            </form>
        @endif
    </div>

    @if ($focus->audio_file)
        <div class="mt-5">
            <p class="text-[13px] font-bold dark:text-gray-300 text-gray-700 mb-2">
                Ambient Sound
            </p>

            <audio controls loop class="w-full">
                <source src="{{ asset('sounds/' . $focus->audio_file) }}" type="audio/mpeg">
            </audio>
        </div>
    @endif
</div>
