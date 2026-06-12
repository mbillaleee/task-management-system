@php
    $user = auth()->user();
    $currentTheme = $user->theme ?? 'dark';
    $currentAccent = $user->accent_color ?? '#f97316';

    $accents = [
        '#f97316' => 'Orange',
        '#ec4899' => 'Pink',
        '#8b5cf6' => 'Purple',
        '#06b6d4' => 'Cyan',
        '#10b981' => 'Emerald',
        '#f59e0b' => 'Amber',
        '#ef4444' => 'Red',
    ];
@endphp

<form action="{{ route('user.settings.appearance') }}" method="POST" class="space-y-6">
    @csrf @method('PATCH')

    {{-- ── Theme Mode ── --}}
    <div>
        <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-1 flex items-center gap-2">
            <i class="fa-solid fa-circle-half-stroke text-orange-400 text-[13px]"></i> Theme Mode
        </h4>
        <p class="text-[12px] dark:text-gray-500 text-gray-400 mb-4">Choose between dark and light interface.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            {{-- Dark --}}
            <label class="theme-option cursor-pointer">
                <input type="radio" name="theme" value="dark" {{ $currentTheme === 'dark' ? 'checked' : '' }}
                    class="sr-only peer" onchange="applyThemePreview('dark')">
                <div
                    class="relative p-4 rounded-xl border-2 transition-all
                    peer-checked:border-orange-500 peer-checked:dark:bg-orange-500/[0.06]
                    dark:border-white/[0.08] border-black/[0.08]
                    dark:bg-[#1a1625] bg-gray-50
                    hover:border-orange-400 dark:hover:border-orange-400">
                    {{-- Mini preview --}}
                    <div class="w-full h-20 rounded-lg bg-[#0d0b14] mb-3 overflow-hidden relative">
                        <div class="absolute left-0 top-0 h-full w-12 bg-[#100e1a]"></div>
                        <div class="absolute left-14 top-3 right-3 h-3 rounded-full bg-white/10"></div>
                        <div class="absolute left-14 top-8 right-8 h-2 rounded-full bg-white/6"></div>
                        <div class="absolute left-14 top-12 w-10 h-2 rounded-full bg-orange-500/60"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[13px] font-bold dark:text-white text-gray-900">Dark Mode</p>
                            <p class="text-[11.5px] dark:text-gray-500 text-gray-400">Easy on the eyes</p>
                        </div>
                        <div class="w-5 h-5 rounded-full border-2 dark:border-white/20 border-black/20 flex items-center justify-center peer-checked:bg-orange-500 peer-checked:border-orange-500"
                            id="darkRadioViz">
                            <div class="w-2.5 h-2.5 rounded-full {{ $currentTheme === 'dark' ? 'bg-orange-500' : '' }}"
                                id="darkDot"></div>
                        </div>
                    </div>
                </div>
            </label>

            {{-- Light --}}
            <label class="theme-option cursor-pointer">
                <input type="radio" name="theme" value="light" {{ $currentTheme === 'light' ? 'checked' : '' }}
                    class="sr-only peer" onchange="applyThemePreview('light')">
                <div
                    class="relative p-4 rounded-xl border-2 transition-all
                    peer-checked:border-orange-500 peer-checked:bg-orange-500/[0.04]
                    dark:border-white/[0.08] border-black/[0.08]
                    dark:bg-[#1a1625] bg-gray-50
                    hover:border-orange-400 dark:hover:border-orange-400">
                    {{-- Mini preview --}}
                    <div class="w-full h-20 rounded-lg bg-[#f0e8dc] mb-3 overflow-hidden relative">
                        <div class="absolute left-0 top-0 h-full w-12 bg-[#fdf6ee]"></div>
                        <div class="absolute left-14 top-3 right-3 h-3 rounded-full bg-black/10"></div>
                        <div class="absolute left-14 top-8 right-8 h-2 rounded-full bg-black/6"></div>
                        <div class="absolute left-14 top-12 w-10 h-2 rounded-full bg-orange-400/70"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[13px] font-bold dark:text-white text-gray-900">Light Mode</p>
                            <p class="text-[11.5px] dark:text-gray-500 text-gray-400">Clean and bright</p>
                        </div>
                        <div class="w-5 h-5 rounded-full border-2 dark:border-white/20 border-black/20 flex items-center justify-center"
                            id="lightRadioViz">
                            <div class="w-2.5 h-2.5 rounded-full {{ $currentTheme === 'light' ? 'bg-orange-500' : '' }}"
                                id="lightDot"></div>
                        </div>
                    </div>
                </div>
            </label>
        </div>
    </div>

    <div class="border-t dark:border-white/[0.06] border-black/[0.05]"></div>

    {{-- ── Accent Color ── --}}
    {{-- <div>
        <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-1 flex items-center gap-2">
            <i class="fa-solid fa-paintbrush text-orange-400 text-[13px]"></i> Accent Color
        </h4>
        <p class="text-[12px] dark:text-gray-500 text-gray-400 mb-4">Primary brand color across the interface.</p>

        <div class="flex flex-wrap gap-3">
            @foreach ($accents as $hex => $name)
                <label class="cursor-pointer group" title="{{ $name }}">
                    <input type="radio" name="accent_color" value="{{ $hex }}" class="sr-only peer"
                        {{ $currentAccent === $hex ? 'checked' : '' }}>
                    <div class="w-9 h-9 rounded-full border-2 transition-all
                        peer-checked:scale-110 peer-checked:ring-2 peer-checked:ring-offset-2 dark:peer-checked:ring-offset-[#17141f] peer-checked:ring-offset-white
                        border-transparent hover:scale-110"
                        style="background:{{ $hex }}; --tw-ring-color: {{ $hex }}">
                        <div
                            class="w-full h-full rounded-full flex items-center justify-center opacity-0 peer-checked:opacity-100 {{ $currentAccent === $hex ? 'opacity-100' : '' }}">
                            <i class="fa-solid fa-check text-white text-[11px]"></i>
                        </div>
                    </div>
                </label>
            @endforeach

            <label class="cursor-pointer" title="Custom color">
                <div
                    class="w-9 h-9 rounded-full border-2 dark:border-white/20 border-black/10 overflow-hidden hover:scale-110 transition-transform">
                    <input type="color" name="accent_color_custom" value="{{ $currentAccent }}"
                        class="w-12 h-12 -ml-1 -mt-1 cursor-pointer border-none"
                        onchange="document.querySelectorAll('[name=accent_color]').forEach(r=>r.checked=false); this.closest('form').querySelector('[name=accent_color]') || this.form.querySelector('[name=accent_color]').value=this.value">
                </div>
            </label>
        </div>
    </div> --}}

    <div class="border-t dark:border-white/[0.06] border-black/[0.05]"></div>

    {{-- ── Language ── --}}
    <div>
        <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-1 flex items-center gap-2">
            <i class="fa-solid fa-language text-orange-400 text-[13px]"></i> Language
        </h4>
        <p class="text-[12px] dark:text-gray-500 text-gray-400 mb-4">Interface display language.</p>

        <select name="language"
            class="w-full sm:w-64 px-3.5 py-2.5 rounded-[10px] text-[13.5px] outline-none transition
            dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800
            dark:border dark:border-white/[0.1] border border-black/[0.09]
            focus:border-orange-400">
            @foreach (\App\Models\Language::where('active', 1)->get() as $lang)
                <option value="{{ $lang->language_code }}"
                    {{ ($user->language ?? 'en') === $lang->language_code ? 'selected' : '' }}>
                    {{ $lang->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="border-t dark:border-white/[0.06] border-black/[0.05]"></div>

    {{-- ── Sidebar Compact ── --}}
    {{-- <div class="flex items-center justify-between">
        <div>
            <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900">Compact Sidebar</h4>
            <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-0.5">Show icons only, hide labels for more space.</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="sidebar_compact" value="1"
                {{ ($user->sidebar_compact ?? false) ? 'checked' : '' }}
                class="sr-only peer">
            <div class="w-11 h-6 rounded-full transition-all
                dark:bg-white/10 bg-black/10
                peer-checked:bg-gradient-to-r peer-checked:from-orange-500 peer-checked:to-pink-500">
                <div class="absolute top-0.5 left-0.5 w-5 h-5 rounded-full transition-all
                    dark:bg-white bg-white shadow-sm
                    peer-checked:translate-x-5"></div>
            </div>
        </label>
    </div> --}}

    {{-- Save --}}
    <div class="flex justify-end pt-2 border-t dark:border-white/[0.06] border-black/[0.05]">
        <button type="submit"
            class="px-5 py-2.5 rounded-[10px] text-white text-[13px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 btn-trans">
            <i class="fa-solid fa-floppy-disk mr-1.5 text-[12px]"></i> Save Appearance
        </button>
    </div>
</form>

<script>
    function applyThemePreview(mode) {
        // Live preview without page reload
        if (typeof setTheme === 'function') setTheme(mode);
        // Update radio dots visually
        document.getElementById('darkDot').classList.toggle('bg-orange-500', mode === 'dark');
        document.getElementById('lightDot').classList.toggle('bg-orange-500', mode === 'light');
    }
</script>
