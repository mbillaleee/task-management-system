@extends('admin.layouts.master')

@section('admin')
    <section class="flex-1 p-4 sm:p-5 flex flex-col gap-5">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[22px] font-extrabold dark:text-white text-gray-900">
                    <i class="fas fa-user-circle text-orange-500 mr-2"></i> User Profile
                </h2>
                <p class="text-[14px] dark:text-gray-400 text-gray-500 mt-1">
                    View selected user profile, account settings and assigned roles.
                </p>
            </div>

            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-[10px] bg-gray-100 dark:bg-[#1a1625] dark:text-gray-300 text-gray-700 hover:bg-gray-200 dark:hover:bg-[#2a1f38] transition">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        {{-- Profile Header --}}
        <div
            class="relative overflow-hidden rounded-2xl border dark:border-white/[0.07] border-gray-200 dark:bg-[#17141f] bg-white">
            <div class="h-32 bg-gradient-to-r from-orange-500 via-pink-500 to-purple-600"></div>

            <div class="p-5 sm:p-6 -mt-16 flex flex-col md:flex-row md:items-end justify-between gap-5">
                <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                    @if ($user->profile)
                        <img src="{{ $user->profile ? asset('storage/profile/' . $user->profile) : asset('images/default-user.webp') }}"
                            alt="{{ $user->name }}'s Profile Picture"
                            class="w-28 h-28 rounded-2xl object-cover border-4 border-white dark:border-[#17141f] shadow-xl">
                    @else
                        <div
                            class="w-28 h-28 rounded-2xl bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-300 text-[42px] border-4 border-white dark:border-[#17141f] shadow-xl">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif

                    <div>
                        <h3 class="text-[24px] font-black dark:text-white text-gray-900">
                            {{ $user->name }}
                        </h3>
                        <p class="text-[14px] dark:text-gray-400 text-gray-500 mt-1">
                            <i class="fas fa-envelope mr-1 text-orange-500"></i> {{ $user->email }}
                        </p>

                        <div class="flex flex-wrap items-center gap-2 mt-3">
                            @if ($user->status == 1)
                                <span
                                    class="px-3 py-1 rounded-full text-[12px] font-bold bg-emerald-500/15 text-emerald-500">
                                    <i class="fas fa-circle-check mr-1"></i> Active
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-[12px] font-bold bg-gray-500/15 text-gray-500">
                                    <i class="fas fa-circle-xmark mr-1"></i> Inactive
                                </span>
                            @endif

                            <span class="px-3 py-1 rounded-full text-[12px] font-bold bg-orange-500/15 text-orange-500">
                                <i class="fas fa-user-shield mr-1"></i>
                                {{ count($user->getRoleNames()) }} Role{{ count($user->getRoleNames()) > 1 ? 's' : '' }}
                            </span>

                            <span class="px-3 py-1 rounded-full text-[12px] font-bold bg-blue-500/15 text-blue-500">
                                <i class="fas fa-calendar-plus mr-1"></i>
                                Joined {{ $user->created_at ? $user->created_at->format('d M, Y') : 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

            {{-- Left Column --}}
            <div class="space-y-5">

                {{-- Roles --}}
                <div class="rounded-2xl p-5 border dark:border-white/[0.07] border-gray-200 dark:bg-[#17141f] bg-white">
                    <h4 class="text-[16px] font-bold dark:text-white text-gray-900 mb-4">
                        <i class="fas fa-user-shield text-orange-500 mr-2"></i> Assigned Roles
                    </h4>

                    <div class="flex flex-wrap gap-2">
                        @forelse ($user->getRoleNames() as $role)
                            <span
                                class="px-3 py-1.5 rounded-full text-[12px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 text-white">
                                <i class="fas fa-check-circle mr-1"></i> {{ ucfirst($role) }}
                            </span>
                        @empty
                            <p class="text-[14px] dark:text-gray-400 text-gray-500">
                                <i class="fas fa-user-slash mr-1"></i> No roles assigned.
                            </p>
                        @endforelse
                    </div>
                </div>

                {{-- Bio --}}
                <div class="rounded-2xl p-5 border dark:border-white/[0.07] border-gray-200 dark:bg-[#17141f] bg-white">
                    <h4 class="text-[16px] font-bold dark:text-white text-gray-900 mb-3">
                        <i class="fas fa-align-left text-orange-500 mr-2"></i> Bio
                    </h4>
                    <p class="text-[14px] leading-6 dark:text-gray-300 text-gray-600">
                        {{ $user->bio ?: 'No bio added yet.' }}
                    </p>
                </div>

                {{-- Account Settings --}}
                <div class="rounded-2xl p-5 border dark:border-white/[0.07] border-gray-200 dark:bg-[#17141f] bg-white">
                    <h4 class="text-[16px] font-bold dark:text-white text-gray-900 mb-4">
                        <i class="fas fa-sliders text-orange-500 mr-2"></i> Account Preferences
                    </h4>

                    <div class="space-y-3">
                        @php
                            $preferences = [
                                [
                                    'icon' => 'fas fa-moon',
                                    'label' => 'Theme',
                                    'value' => ucfirst($user->theme ?? 'dark'),
                                ],
                                [
                                    'icon' => 'fas fa-palette',
                                    'label' => 'Accent Color',
                                    'value' => $user->accent_color ?? '#f97316',
                                ],
                                [
                                    'icon' => 'fas fa-language',
                                    'label' => 'Language',
                                    'value' => strtoupper($user->language ?? 'en'),
                                ],
                                [
                                    'icon' => 'fas fa-bars-staggered',
                                    'label' => 'Compact Sidebar',
                                    'value' => $user->sidebar_compact ? 'Enabled' : 'Disabled',
                                ],
                                [
                                    'icon' => 'fas fa-lock',
                                    'label' => 'Two Factor Auth',
                                    'value' => $user->two_factor_enabled ? 'Enabled' : 'Disabled',
                                ],
                            ];
                        @endphp

                        @foreach ($preferences as $item)
                            <div
                                class="flex items-center justify-between gap-3 p-3 rounded-xl dark:bg-white/[0.04] bg-gray-50">
                                <span class="text-[13px] font-semibold dark:text-gray-400 text-gray-500">
                                    <i class="{{ $item['icon'] }} text-orange-500 mr-2"></i> {{ $item['label'] }}
                                </span>
                                <span class="text-[13px] font-bold dark:text-white text-gray-900">
                                    {{ $item['value'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="xl:col-span-2 space-y-5">

                {{-- User Details --}}
                <div class="rounded-2xl p-5 border dark:border-white/[0.07] border-gray-200 dark:bg-[#17141f] bg-white">
                    <h4 class="text-[16px] font-bold dark:text-white text-gray-900 mb-4">
                        <i class="fas fa-id-card text-orange-500 mr-2"></i> Personal Information
                    </h4>

                    @php
                        $details = [
                            ['icon' => 'fas fa-user', 'label' => 'Full Name', 'value' => $user->name],
                            ['icon' => 'fas fa-envelope', 'label' => 'Email Address', 'value' => $user->email],
                            ['icon' => 'fas fa-phone', 'label' => 'Phone', 'value' => $user->phone],
                            ['icon' => 'fas fa-at', 'label' => 'Username', 'value' => $user->username],
                            ['icon' => 'fas fa-venus-mars', 'label' => 'Gender', 'value' => $user->gender],
                            [
                                'icon' => 'fas fa-cake-candles',
                                'label' => 'Date of Birth',
                                'value' => $user->date_of_birth
                                    ? \Carbon\Carbon::parse($user->date_of_birth)->format('d M, Y')
                                    : null,
                            ],
                            ['icon' => 'fas fa-globe', 'label' => 'Country', 'value' => $user->country],
                            ['icon' => 'fas fa-city', 'label' => 'City', 'value' => $user->city],
                            ['icon' => 'fas fa-clock', 'label' => 'Timezone', 'value' => $user->timezone],
                            [
                                'icon' => 'fas fa-user-tag',
                                'label' => 'Default Role',
                                'value' => ucfirst($user->role ?? 'N/A'),
                            ],
                            [
                                'icon' => 'fas fa-calendar-check',
                                'label' => 'Email Verified',
                                'value' => $user->email_verified_at
                                    ? $user->email_verified_at->format('d M, Y h:i A')
                                    : 'Not Verified',
                            ],
                            [
                                'icon' => 'fas fa-clock-rotate-left',
                                'label' => 'Last Updated',
                                'value' => $user->updated_at ? $user->updated_at->format('d M, Y h:i A') : null,
                            ],
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach ($details as $detail)
                            <div class="flex items-start gap-3 p-3 rounded-xl dark:bg-white/[0.04] bg-gray-50">
                                <div
                                    class="w-10 h-10 rounded-xl flex items-center justify-center bg-orange-500/10 text-orange-500">
                                    <i class="{{ $detail['icon'] }}"></i>
                                </div>

                                <div>
                                    <p class="text-[12px] font-semibold dark:text-gray-400 text-gray-500">
                                        {{ $detail['label'] }}
                                    </p>
                                    <p class="text-[14px] font-bold dark:text-white text-gray-900 mt-0.5">
                                        {{ $detail['value'] ?: 'Not provided' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Notification Settings --}}
                <div class="rounded-2xl p-5 border dark:border-white/[0.07] border-gray-200 dark:bg-[#17141f] bg-white">
                    <h4 class="text-[16px] font-bold dark:text-white text-gray-900 mb-4">
                        <i class="fas fa-bell text-orange-500 mr-2"></i> Notification Settings
                    </h4>

                    @php
                        $notifications = [
                            ['label' => 'Task Reminders', 'value' => $user->notif_task_reminders],
                            ['label' => 'Habit Reminders', 'value' => $user->notif_habit_reminders],
                            ['label' => 'Goal Updates', 'value' => $user->notif_goal_updates],
                            ['label' => 'Weekly Report', 'value' => $user->notif_weekly_report],
                            ['label' => 'XP Rewards', 'value' => $user->notif_xp_rewards],
                            // ['label' => 'Email Notifications', 'value' => $user->notif_email],
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach ($notifications as $notification)
                            <div class="flex items-center justify-between p-3 rounded-xl dark:bg-white/[0.04] bg-gray-50">
                                <span class="text-[13px] font-semibold dark:text-gray-300 text-gray-600">
                                    {{ $notification['label'] }}
                                </span>

                                @if ($notification['value'])
                                    <span
                                        class="px-2 py-1 rounded-full text-[11px] font-bold bg-emerald-500/15 text-emerald-500">
                                        <i class="fas fa-toggle-on mr-1"></i> On
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-[11px] font-bold bg-gray-500/15 text-gray-500">
                                        <i class="fas fa-toggle-off mr-1"></i> Off
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Visibility Settings --}}
                {{-- <div class="rounded-2xl p-5 border dark:border-white/[0.07] border-gray-200 dark:bg-[#17141f] bg-white">
                    <h4 class="text-[16px] font-bold dark:text-white text-gray-900 mb-4">
                        <i class="fas fa-eye text-orange-500 mr-2"></i> Profile Visibility
                    </h4>

                    @php
                        $visibility = [
                            ['label' => 'Profile Public', 'value' => $user->profile_public],
                            ['label' => 'Show Streak', 'value' => $user->show_streak],
                            ['label' => 'Show XP', 'value' => $user->show_xp],
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        @foreach ($visibility as $item)
                            <div class="p-4 rounded-xl dark:bg-white/[0.04] bg-gray-50 text-center">
                                <p class="text-[13px] font-bold dark:text-gray-300 text-gray-600">
                                    {{ $item['label'] }}
                                </p>

                                @if ($item['value'])
                                    <p class="text-emerald-500 font-black mt-2">
                                        <i class="fas fa-circle-check mr-1"></i> Enabled
                                    </p>
                                @else
                                    <p class="text-gray-500 font-black mt-2">
                                        <i class="fas fa-circle-xmark mr-1"></i> Disabled
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div> --}}

            </div>
        </div>

    </section>
@endsection
