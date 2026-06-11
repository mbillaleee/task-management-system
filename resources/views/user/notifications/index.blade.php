@extends('user.layouts.master')

@section('user')
@php
    $filterLabels = [
        'all'    => 'All',
        'unread' => 'Unread',
        'task'   => 'Tasks',
        'habit'  => 'Habits',
        'goal'   => 'Goals',
        'focus'  => 'Focus',
    ];
    $filterIcons = [
        'all'    => 'fa-bell',
        'unread' => 'fa-circle-dot',
        'task'   => 'fa-list-check',
        'habit'  => 'fa-heart-pulse',
        'goal'   => 'fa-bullseye',
        'focus'  => 'fa-stopwatch',
    ];
@endphp

<section class="space-y-5">

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
        <div>
            <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900 flex items-center gap-2.5">
                Notifications
                @if($unreadCount > 0)
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500">
                        {{ $unreadCount }}
                    </span>
                @endif
            </h2>
            <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">Reminders, alerts, and smart updates.</p>
        </div>
        <div class="flex gap-2">
            @if($unreadCount > 0)
                <form action="{{ route('user.notifications.mark-all-read') }}" method="POST">
                    @csrf @method('PATCH')
                    <button class="px-4 py-2 rounded-[10px] text-[13px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08] hover:border-orange-400 transition">
                        <i class="fa-solid fa-check-double mr-1.5 text-[12px]"></i> Mark All Read
                    </button>
                </form>
            @endif
            <form action="{{ route('user.notifications.clear-read') }}" method="POST"
                onsubmit="return confirm('Clear all read notifications?')">
                @csrf @method('DELETE')
                <button class="px-4 py-2 rounded-[10px] text-[13px] font-bold dark:bg-red-500/[0.1] bg-red-50 text-red-500 border border-red-500/20">
                    <i class="fa-solid fa-trash-can mr-1.5 text-[12px]"></i> Clear Read
                </button>
            </form>
        </div>
    </div>

    {{-- ── Alert ── --}}
    @if(session('success'))
        <div class="px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[13px] font-bold flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ── Stats Row ── --}}
    <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
        @foreach($filterLabels as $key => $label)
            <a href="{{ route('user.notifications.index', ['filter' => $key]) }}"
                class="flex flex-col items-center gap-1 p-3 rounded-xl border transition
                {{ $filter === $key
                    ? 'dark:bg-orange-500/10 bg-orange-50 border-orange-500/30 text-orange-500'
                    : 'dark:bg-[#17141f] bg-white dark:border-white/[0.07] border-black/[0.07] dark:text-gray-400 text-gray-500 dark:hover:border-white/20 hover:border-black/20' }}">
                <i class="fa-solid {{ $filterIcons[$key] }} text-[14px]"></i>
                <span class="text-[11px] font-bold">{{ $label }}</span>
                <span class="text-[13px] font-extrabold {{ $filter === $key ? 'text-orange-500' : 'dark:text-white text-gray-900' }}">
                    {{ $stats[$key] ?? 0 }}
                </span>
            </a>
        @endforeach
    </div>

    {{-- ── Notifications List ── --}}
    <div class="dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl overflow-hidden">

        @if($notifications->isEmpty())
            <div class="py-16 text-center">
                <div class="text-5xl mb-3">🔔</div>
                <p class="text-[16px] font-bold dark:text-white text-gray-900">All clear!</p>
                <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-1">
                    {{ $filter === 'unread' ? 'No unread notifications.' : 'No notifications yet.' }}
                </p>
            </div>
        @else
            <ul class="divide-y dark:divide-white/[0.04] divide-black/[0.04]">
                @foreach($notifications as $notif)
                    @php
                        $data    = $notif->data;
                        $isRead  = !is_null($notif->read_at);
                        $icon    = $data['icon']    ?? '🔔';
                        $title   = $data['title']   ?? 'Notification';
                        $message = $data['message'] ?? '';
                        $url     = $data['url']     ?? '#';
                        $type    = $data['type']    ?? 'general';

                        $typeMeta = match(true) {
                            str_contains($type, 'task')    => ['color' => 'text-blue-400',   'bg' => 'bg-blue-500/10'],
                            str_contains($type, 'habit')   => ['color' => 'text-orange-400', 'bg' => 'bg-orange-500/10'],
                            str_contains($type, 'goal')    => ['color' => 'text-purple-400', 'bg' => 'bg-purple-500/10'],
                            str_contains($type, 'focus')   => ['color' => 'text-cyan-400',   'bg' => 'bg-cyan-500/10'],
                            str_contains($type, 'deadline')=> ['color' => 'text-red-400',    'bg' => 'bg-red-500/10'],
                            default                        => ['color' => 'text-gray-400',   'bg' => 'bg-gray-500/10'],
                        };
                    @endphp

                    <li class="group flex items-start gap-3 px-4 py-4 transition hover:dark:bg-white/[0.02] hover:bg-gray-50
                        {{ !$isRead ? 'dark:bg-orange-500/[0.03] bg-orange-50/30' : '' }}">

                        {{-- Unread dot --}}
                        <div class="flex-shrink-0 mt-1 w-2">
                            @if(!$isRead)
                                <span class="block w-2 h-2 rounded-full bg-orange-500 mt-0.5"></span>
                            @endif
                        </div>

                        {{-- Icon --}}
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl {{ $typeMeta['bg'] }} flex items-center justify-center text-lg">
                            {{ $icon }}
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <p class="text-[13.5px] font-bold {{ !$isRead ? 'dark:text-white text-gray-900' : 'dark:text-gray-300 text-gray-700' }}">
                                        {{ $title }}
                                    </p>
                                    <p class="text-[12.5px] dark:text-gray-400 text-gray-500 mt-0.5 leading-relaxed">
                                        {{ $message }}
                                    </p>

                                    {{-- Extra meta for tasks --}}
                                    @if(isset($data['priority']))
                                        <span class="mt-1.5 inline-block px-2 py-0.5 rounded-md text-[10px] font-bold
                                            {{ match($data['priority']) {
                                                'high'   => 'bg-red-500/10 text-red-400',
                                                'medium' => 'bg-yellow-500/10 text-yellow-400',
                                                default  => 'bg-gray-500/10 text-gray-400',
                                            } }}">
                                            {{ ucfirst($data['priority']) }} priority
                                        </span>
                                    @endif
                                    @if(isset($data['due_date']))
                                        <span class="mt-1.5 ml-1 inline-block px-2 py-0.5 rounded-md text-[10px] font-bold dark:bg-white/[0.06] bg-gray-100 dark:text-gray-400 text-gray-500">
                                            Due {{ \Carbon\Carbon::parse($data['due_date'])->format('M d') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-1.5 flex-shrink-0">
                                    <span class="text-[11px] dark:text-gray-600 text-gray-400 whitespace-nowrap">
                                        {{ $notif->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>

                            {{-- Action buttons --}}
                            <div class="flex items-center gap-2 mt-2.5">
                                @if($url !== '#')
                                    <form action="{{ route('user.notifications.read', $notif->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="px-3 py-1.5 rounded-lg text-[11.5px] font-bold text-orange-500 dark:bg-orange-500/[0.1] bg-orange-50 border border-orange-500/20 hover:border-orange-400 transition">
                                            View →
                                        </button>
                                    </form>
                                @endif
                                @if(!$isRead)
                                    <form action="{{ route('user.notifications.read', $notif->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="px-3 py-1.5 rounded-lg text-[11.5px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-400 text-gray-500 border dark:border-white/[0.08] border-black/[0.08] hover:border-orange-400 transition">
                                            Mark Read
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('user.notifications.destroy', $notif->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1.5 rounded-lg text-[11.5px] font-bold dark:bg-red-500/[0.08] bg-red-50 text-red-500 border border-red-500/15 hover:border-red-400 transition">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            {{-- Pagination --}}
            @if($notifications->hasPages())
                <div class="px-4 py-4 border-t dark:border-white/[0.06] border-black/[0.05]">
                    {{ $notifications->appends(['filter' => $filter])->links() }}
                </div>
            @endif
        @endif
    </div>

</section>
@endsection
