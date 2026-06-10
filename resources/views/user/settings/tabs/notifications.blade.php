@php $user = auth()->user(); @endphp

<form action="{{ route('user.settings.notifications') }}" method="POST" class="space-y-5">
    @csrf @method('PATCH')

    <div>
        <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-1 flex items-center gap-2">
            <i class="fa-solid fa-bell text-orange-400 text-[13px]"></i> Push Notifications
        </h4>
        <p class="text-[12px] dark:text-gray-500 text-gray-400 mb-5">Control which in-app reminders you receive.</p>

        <div class="space-y-1">
            @php
                $notifs = [
                    ['key' => 'notif_task_reminders',  'label' => 'Task reminders',     'sub' => 'Get notified before task deadlines', 'icon' => 'fa-list-check'],
                    ['key' => 'notif_habit_reminders', 'label' => 'Habit reminders',    'sub' => 'Daily nudge to complete your habits', 'icon' => 'fa-heart-pulse'],
                    ['key' => 'notif_goal_updates',    'label' => 'Goal milestones',    'sub' => 'Alerts when you hit a goal milestone','icon' => 'fa-bullseye'],
                    ['key' => 'notif_weekly_report',   'label' => 'Weekly report',      'sub' => 'Your weekly productivity summary',   'icon' => 'fa-chart-bar'],
                    ['key' => 'notif_xp_rewards',      'label' => 'XP & rewards',       'sub' => 'Level-ups, badges, and streak alerts','icon' => 'fa-trophy'],
                ];
            @endphp

            @foreach($notifs as $n)
                <div class="flex items-center justify-between p-4 rounded-xl dark:bg-[#1a1625] bg-gray-50
                    border dark:border-white/[0.06] border-black/[0.05] hover:border-orange-400/30 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-orange-500/10 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid {{ $n['icon'] }} text-orange-400 text-[13px]"></i>
                        </div>
                        <div>
                            <p class="text-[13px] font-bold dark:text-white text-gray-900">{{ $n['label'] }}</p>
                            <p class="text-[11.5px] dark:text-gray-500 text-gray-400">{{ $n['sub'] }}</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                        <input type="checkbox" name="{{ $n['key'] }}" value="1"
                            {{ ($user->{$n['key']} ?? true) ? 'checked' : '' }}
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

    {{-- Email notifications --}}
    <div>
        <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-1 flex items-center gap-2">
            <i class="fa-solid fa-envelope text-orange-400 text-[13px]"></i> Email Notifications
        </h4>
        <p class="text-[12px] dark:text-gray-500 text-gray-400 mb-4">Receive a copy of key alerts to your email.</p>

        <div class="flex items-center justify-between p-4 rounded-xl dark:bg-[#1a1625] bg-gray-50
            border dark:border-white/[0.06] border-black/[0.05]">
            <div>
                <p class="text-[13px] font-bold dark:text-white text-gray-900">Email digest</p>
                <p class="text-[11.5px] dark:text-gray-500 text-gray-400">Send weekly summary to {{ auth()->user()->email }}</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                <input type="checkbox" name="notif_email" value="1"
                    {{ ($user->notif_email ?? false) ? 'checked' : '' }}
                    class="sr-only peer">
                <div class="w-10 h-[22px] rounded-full transition-all
                    dark:bg-white/10 bg-black/10
                    peer-checked:bg-gradient-to-r peer-checked:from-orange-500 peer-checked:to-pink-500 relative">
                    <div class="absolute top-0.5 left-0.5 w-[18px] h-[18px] rounded-full bg-white shadow-sm transition-all
                        peer-checked:translate-x-[18px]"></div>
                </div>
            </label>
        </div>
    </div>

    <div class="flex justify-end pt-2 border-t dark:border-white/[0.06] border-black/[0.05]">
        <button type="submit"
            class="px-5 py-2.5 rounded-[10px] text-white text-[13px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 btn-trans">
            <i class="fa-solid fa-floppy-disk mr-1.5 text-[12px]"></i> Save Preferences
        </button>
    </div>
</form>
