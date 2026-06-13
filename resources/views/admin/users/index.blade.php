@extends('admin.layouts.master')

@section('admin')
    <section class="flex-1 p-4 sm:p-5 flex flex-col gap-5">

        {{-- ── Header ────────────────────────────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[22px] font-extrabold dark:text-white text-gray-900">
                    <i class="fas fa-users text-orange-500 mr-2"></i> User Management
                </h2>
                <p class="text-[13px] dark:text-gray-400 text-gray-500 mt-0.5">
                    Manage all users, roles, suspension, passwords and impersonation.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.users.create') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-[10px] text-white font-bold bg-gradient-to-r from-orange-500 to-pink-500 hover:opacity-90 transition text-[13px]">
                    <i class="fas fa-user-plus"></i> Add User
                </a>
                <a href="{{ route('admin.roles.index') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-[10px] text-white font-semibold bg-gradient-to-r from-amber-500 to-orange-500 hover:opacity-90 transition text-[13px]">
                    <i class="fas fa-user-shield"></i> Roles
                </a>
            </div>
        </div>

        {{-- ── Stats Cards ─────────────────────────────────────────────────────── --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @php
                $statsCards = [
                    ['icon' => 'fa-users', 'color' => 'orange', 'value' => $totalUsers, 'label' => 'Total Users'],
                    ['icon' => 'fa-circle-check', 'color' => 'emerald', 'value' => $activeUsers, 'label' => 'Active'],
                    ['icon' => 'fa-ban', 'color' => 'red', 'value' => $suspendedUsers, 'label' => 'Suspended'],
                    [
                        'icon' => 'fa-user-plus',
                        'color' => 'blue',
                        'value' => $newThisMonth,
                        'label' => 'New This Month',
                    ],
                ];
            @endphp
            @foreach ($statsCards as $card)
                <div
                    class="hover-lift p-4 rounded-2xl dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-{{ $card['color'] }}-500/15 flex items-center justify-center shrink-0">
                        <i class="fas {{ $card['icon'] }} text-{{ $card['color'] }}-500 text-[16px]"></i>
                    </div>
                    <div>
                        <div class="text-[20px] font-extrabold dark:text-white text-gray-900 leading-none">
                            {{ $card['value'] }}</div>
                        <div class="text-[11px] dark:text-gray-400 text-gray-500 mt-0.5">{{ $card['label'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ── Alerts ──────────────────────────────────────────────────────────── --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 text-[13px] font-semibold">
                <i class="fas fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div
                class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-500 text-[13px] font-semibold">
                <i class="fas fa-triangle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        {{-- ── Filter & Search ─────────────────────────────────────────────────── --}}
        <form method="GET" action="{{ route('admin.users.index') }}"
            class="p-4 rounded-2xl dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[180px]">
                <label
                    class="block text-[11px] font-semibold dark:text-gray-400 text-gray-500 mb-1 uppercase tracking-wide">Search</label>
                <div class="relative">
                    <i
                        class="fas fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[12px]"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email…"
                        class="w-full pl-9 pr-3 py-2 rounded-xl text-[13px] dark:bg-[#0f0c17] bg-gray-50 border dark:border-white/[0.07] border-gray-200 dark:text-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500/40">
                </div>
            </div>
            <div class="min-w-[140px]">
                <label
                    class="block text-[11px] font-semibold dark:text-gray-400 text-gray-500 mb-1 uppercase tracking-wide">Role</label>
                <select name="role"
                    class="w-full px-3 py-2 rounded-xl text-[13px] dark:bg-[#0f0c17] bg-gray-50 border dark:border-white/[0.07] border-gray-200 dark:text-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500/40">
                    <option value="">All Roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[140px]">
                <label
                    class="block text-[11px] font-semibold dark:text-gray-400 text-gray-500 mb-1 uppercase tracking-wide">Status</label>
                <select name="status"
                    class="w-full px-3 py-2 rounded-xl text-[13px] dark:bg-[#0f0c17] bg-gray-50 border dark:border-white/[0.07] border-gray-200 dark:text-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500/40">
                    <option value="">All Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            <button type="submit"
                class="px-5 py-2 rounded-xl bg-gradient-to-r from-orange-500 to-pink-500 text-white font-bold text-[13px] hover:opacity-90 transition">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>
            @if (request()->hasAny(['search', 'role', 'status']))
                <a href="{{ route('admin.users.index') }}"
                    class="px-4 py-2 rounded-xl dark:bg-white/[0.05] bg-gray-100 dark:text-gray-300 text-gray-600 font-semibold text-[13px] hover:opacity-80 transition">
                    <i class="fas fa-xmark mr-1"></i> Clear
                </a>
            @endif
        </form>

        {{-- ── Users Table ─────────────────────────────────────────────────────── --}}
        <div class="rounded-2xl dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-[13px]">
                    <thead>
                        <tr class="border-b dark:border-white/[0.06] border-gray-100">
                            <th class="text-left px-5 py-3.5 dark:text-gray-400 text-gray-500 font-semibold">#</th>
                            <th class="text-left px-5 py-3.5 dark:text-gray-400 text-gray-500 font-semibold">User</th>
                            <th class="text-left px-5 py-3.5 dark:text-gray-400 text-gray-500 font-semibold">Role</th>
                            <th class="text-left px-5 py-3.5 dark:text-gray-400 text-gray-500 font-semibold">Plan</th>
                            <th class="text-center px-5 py-3.5 dark:text-gray-400 text-gray-500 font-semibold">XP / Level
                            </th>
                            <th class="text-center px-5 py-3.5 dark:text-gray-400 text-gray-500 font-semibold">Status</th>
                            <th class="text-right px-5 py-3.5 dark:text-gray-400 text-gray-500 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-white/[0.04] divide-gray-50">
                        @forelse ($data as $user)
                            <tr class="hover:dark:bg-white/[0.02] hover:bg-gray-50/60 transition">
                                <td class="px-5 py-3.5 dark:text-gray-500 text-gray-400 font-mono">
                                    {{ $data->firstItem() + $loop->index }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        @if ($user->profile)
                                            <img src="{{ asset('storage/profile/' . $user->profile) }}" alt=""
                                                class="w-9 h-9 rounded-xl object-cover shrink-0">
                                        @else
                                            <div
                                                class="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-500 to-pink-500 flex items-center justify-center text-white font-bold text-[14px] shrink-0">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-semibold dark:text-white text-gray-900">{{ $user->name }}
                                            </div>
                                            <div class="text-[11px] dark:text-gray-500 text-gray-400">{{ $user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    @foreach ($user->getRoleNames() as $role)
                                        <span
                                            class="px-2 py-0.5 rounded-md text-[11px] font-bold
                                    {{ $role === 'super_admin' ? 'bg-purple-500/15 text-purple-400' : 'bg-orange-500/15 text-orange-400' }}">
                                            <i
                                                class="fas fa-{{ $role === 'super_admin' ? 'crown' : 'user' }} mr-1"></i>{{ $role }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-5 py-3.5">
                                    @if ($user->activeSubscription?->plan)
                                        <span
                                            class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-blue-500/15 text-blue-400">
                                            <i class="fas fa-gem mr-1"></i>{{ $user->activeSubscription->plan->name }}
                                        </span>
                                    @else
                                        <span class="text-[11px] dark:text-gray-600 text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    @if ($user->gamification)
                                        <div class="flex items-center justify-center gap-2">
                                            <span
                                                class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-amber-500/15 text-amber-400">
                                                <i
                                                    class="fas fa-bolt mr-1"></i>{{ number_format($user->gamification->xp) }}
                                                XP
                                            </span>
                                            <span
                                                class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-indigo-500/15 text-indigo-400">
                                                Lv.{{ $user->gamification->level }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-[11px] dark:text-gray-600 text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    @if ($user->status == 1)
                                        <span
                                            class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-500/15 text-emerald-500">
                                            <i class="fas fa-circle text-[7px] mr-1"></i> Active
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-500/15 text-red-500">
                                            <i class="fas fa-ban text-[10px] mr-1"></i> Suspended
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        {{-- View --}}
                                        <a href="{{ route('admin.users.show', $user->id) }}" title="View Details"
                                            class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-500 hover:bg-blue-500/20 flex items-center justify-center transition">
                                            <i class="fas fa-eye text-[12px]"></i>
                                        </a>
                                        {{-- Edit --}}
                                        <a href="{{ route('admin.users.edit', $user->id) }}" title="Edit User"
                                            class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-500 hover:bg-amber-500/20 flex items-center justify-center transition">
                                            <i class="fas fa-pen text-[12px]"></i>
                                        </a>
                                        {{-- Suspend / Activate --}}
                                        <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST"
                                            class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                title="{{ $user->status == 1 ? 'Suspend User' : 'Activate User' }}"
                                                class="w-8 h-8 rounded-lg {{ $user->status == 1 ? 'bg-orange-500/10 text-orange-500 hover:bg-orange-500/20' : 'bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500/20' }} flex items-center justify-center transition">
                                                <i
                                                    class="fas fa-{{ $user->status == 1 ? 'ban' : 'circle-check' }} text-[12px]"></i>
                                            </button>
                                        </form>
                                        {{-- Impersonate --}}
                                        @unless ($user->hasRole('super_admin'))
                                            <form action="{{ route('admin.users.impersonate', $user->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit" title="Login as User"
                                                    class="w-8 h-8 rounded-lg bg-purple-500/10 text-purple-500 hover:bg-purple-500/20 flex items-center justify-center transition">
                                                    <i class="fas fa-right-to-bracket text-[12px]"></i>
                                                </button>
                                            </form>
                                        @endunless
                                        {{-- Delete --}}
                                        @unless ($user->id === auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" title="Delete User"
                                                    class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500/20 flex items-center justify-center transition">
                                                    <i class="fas fa-trash text-[12px]"></i>
                                                </button>
                                            </form>
                                        @endunless
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-gray-100 dark:bg-white/[0.05] flex items-center justify-center">
                                            <i class="fas fa-users-slash text-gray-400 text-[22px]"></i>
                                        </div>
                                        <div class="text-[14px] font-semibold dark:text-gray-400 text-gray-500">No users
                                            found</div>
                                        <div class="text-[12px] dark:text-gray-600 text-gray-400">Try adjusting your search
                                            or filters</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($data->hasPages())
                <div
                    class="px-5 py-4 border-t dark:border-white/[0.06] border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="text-[12px] dark:text-gray-500 text-gray-400">
                        Showing {{ $data->firstItem() }}–{{ $data->lastItem() }} of {{ $data->total() }} users
                    </div>
                    <div class="flex items-center gap-1">
                        @if ($data->onFirstPage())
                            <span
                                class="px-3 py-1.5 rounded-lg text-[12px] dark:text-gray-600 text-gray-400 cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $data->previousPageUrl() }}"
                                class="px-3 py-1.5 rounded-lg text-[12px] dark:bg-white/[0.05] bg-gray-100 dark:text-gray-300 text-gray-600 hover:opacity-80 transition">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        @foreach ($data->getUrlRange(max(1, $data->currentPage() - 2), min($data->lastPage(), $data->currentPage() + 2)) as $page => $url)
                            <a href="{{ $url }}"
                                class="px-3 py-1.5 rounded-lg text-[12px] font-semibold transition
                           {{ $page == $data->currentPage() ? 'bg-gradient-to-r from-orange-500 to-pink-500 text-white' : 'dark:bg-white/[0.05] bg-gray-100 dark:text-gray-300 text-gray-600 hover:opacity-80' }}">
                                {{ $page }}
                            </a>
                        @endforeach

                        @if ($data->hasMorePages())
                            <a href="{{ $data->nextPageUrl() }}"
                                class="px-3 py-1.5 rounded-lg text-[12px] dark:bg-white/[0.05] bg-gray-100 dark:text-gray-300 text-gray-600 hover:opacity-80 transition">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span
                                class="px-3 py-1.5 rounded-lg text-[12px] dark:text-gray-600 text-gray-400 cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

    </section>
@endsection
