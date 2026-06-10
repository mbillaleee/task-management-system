@php $user = auth()->user(); @endphp

<form action="{{ route('user.settings.privacy') }}" method="POST" class="space-y-5">
    @csrf @method('PATCH')

    {{-- ── Profile Visibility ── --}}
    <div>
        <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-1 flex items-center gap-2">
            <i class="fa-solid fa-eye text-orange-400 text-[13px]"></i> Profile Visibility
        </h4>
        <p class="text-[12px] dark:text-gray-500 text-gray-400 mb-4">Control what others can see on your profile.</p>

        <div class="space-y-1">
            @php
                $privacyToggles = [
                    ['key' => 'profile_public', 'label' => 'Public profile',   'sub' => 'Anyone can view your profile page',        'icon' => 'fa-globe'],
                    ['key' => 'show_streak',    'label' => 'Show streak',      'sub' => 'Display your habit streak publicly',        'icon' => 'fa-fire'],
                    ['key' => 'show_xp',        'label' => 'Show XP & level',  'sub' => 'Display your XP and level on your profile', 'icon' => 'fa-star'],
                ];
            @endphp

            @foreach($privacyToggles as $t)
                <div class="flex items-center justify-between p-4 rounded-xl dark:bg-[#1a1625] bg-gray-50
                    border dark:border-white/[0.06] border-black/[0.05] hover:border-orange-400/30 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-orange-500/10 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid {{ $t['icon'] }} text-orange-400 text-[13px]"></i>
                        </div>
                        <div>
                            <p class="text-[13px] font-bold dark:text-white text-gray-900">{{ $t['label'] }}</p>
                            <p class="text-[11.5px] dark:text-gray-500 text-gray-400">{{ $t['sub'] }}</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                        <input type="checkbox" name="{{ $t['key'] }}" value="1"
                            {{ ($user->{$t['key']} ?? false) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="w-10 h-[22px] rounded-full transition-all
                            dark:bg-white/10 bg-black/10
                            peer-checked:bg-gradient-to-r peer-checked:from-orange-500 peer-checked:to-pink-500 relative">
                            <div class="absolute top-0.5 left-0.5 w-[18px] h-[18px] rounded-full bg-white shadow-sm transition-all
                                peer-checked:translate-x-[18px]"></div>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <div class="border-t dark:border-white/[0.06] border-black/[0.05]"></div>

    {{-- ── Security ── --}}
    <div>
        <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-1 flex items-center gap-2">
            <i class="fa-solid fa-shield-halved text-orange-400 text-[13px]"></i> Security
        </h4>
        <p class="text-[12px] dark:text-gray-500 text-gray-400 mb-4">Protect your account with additional security layers.</p>

        {{-- 2FA --}}
        <div class="flex items-center justify-between p-4 rounded-xl dark:bg-[#1a1625] bg-gray-50
            border dark:border-white/[0.06] border-black/[0.05]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/10 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-mobile-screen-button text-emerald-400 text-[13px]"></i>
                </div>
                <div>
                    <p class="text-[13px] font-bold dark:text-white text-gray-900">Two-Factor Authentication</p>
                    <p class="text-[11.5px] dark:text-gray-500 text-gray-400">Require a code from your phone to log in</p>
                </div>
            </div>
            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                <input type="checkbox" name="two_factor_enabled" value="1"
                    {{ ($user->two_factor_enabled ?? false) ? 'checked' : '' }}
                    class="sr-only peer">
                <div class="w-10 h-[22px] rounded-full transition-all
                    dark:bg-white/10 bg-black/10
                    peer-checked:bg-emerald-500 relative">
                    <div class="absolute top-0.5 left-0.5 w-[18px] h-[18px] rounded-full bg-white shadow-sm transition-all
                        peer-checked:translate-x-[18px]"></div>
                </div>
            </label>
        </div>
    </div>

    <div class="border-t dark:border-white/[0.06] border-black/[0.05]"></div>

    {{-- ── Active Sessions ── --}}
    <div>
        <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-1 flex items-center gap-2">
            <i class="fa-solid fa-computer text-orange-400 text-[13px]"></i> Active Sessions
        </h4>
        <p class="text-[12px] dark:text-gray-500 text-gray-400 mb-4">Devices currently logged in to your account.</p>

        {{-- Current session --}}
        <div class="p-4 rounded-xl dark:bg-[#1a1625] bg-gray-50 border dark:border-white/[0.06] border-black/[0.05] flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-laptop text-blue-400 text-[13px]"></i>
                </div>
                <div>
                    <p class="text-[13px] font-bold dark:text-white text-gray-900 flex items-center gap-1.5">
                        This device
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span>
                    </p>
                    <p class="text-[11.5px] dark:text-gray-500 text-gray-400">
                        {{ request()->ip() }} · {{ request()->header('User-Agent') ? substr(request()->header('User-Agent'), 0, 40) . '...' : 'Unknown browser' }}
                    </p>
                </div>
            </div>
            <span class="text-[11px] font-bold text-emerald-400">Active now</span>
        </div>

        {{-- Logout all --}}
        <div class="mt-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="px-4 py-2 rounded-[10px] text-[12px] font-bold text-red-500 dark:bg-red-500/[0.08] bg-red-50 border border-red-500/20 hover:border-red-400 transition">
                    <i class="fa-solid fa-arrow-right-from-bracket mr-1.5 text-[11px]"></i>
                    Log out all sessions
                </button>
            </form>
        </div>
    </div>

    {{-- ── Data Export ── --}}
    <div class="border-t dark:border-white/[0.06] border-black/[0.05] pt-5">
        <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-1 flex items-center gap-2">
            <i class="fa-solid fa-download text-orange-400 text-[13px]"></i> Data & Export
        </h4>
        <p class="text-[12px] dark:text-gray-500 text-gray-400 mb-4">Download or manage your personal data.</p>

        <div class="flex flex-wrap gap-2">
            <button type="button" disabled
                class="px-4 py-2 rounded-[10px] text-[12px] font-bold dark:bg-white/[0.06] bg-gray-100 dark:text-gray-500 text-gray-400 cursor-not-allowed opacity-60">
                <i class="fa-solid fa-file-export mr-1.5 text-[11px]"></i> Export Data (coming soon)
            </button>
        </div>
    </div>

    <div class="flex justify-end pt-2 border-t dark:border-white/[0.06] border-black/[0.05]">
        <button type="submit"
            class="px-5 py-2.5 rounded-[10px] text-white text-[13px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 btn-trans">
            <i class="fa-solid fa-floppy-disk mr-1.5 text-[12px]"></i> Save Privacy Settings
        </button>
    </div>
</form>
