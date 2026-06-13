{{--
    Impersonate Banner
    ─────────────────────────────────────────────────────────────
    Include this partial at the TOP of resources/views/user/layouts/master.blade.php
    or admin/layouts/master.blade.php — just inside the <body> tag.

    Example placement in master.blade.php:
        <body ...>
            @include('partials.impersonate_banner')
            ...rest of layout...
        </body>
--}}

@if (session()->has('impersonate.original_admin_id'))
    <div
        class="fixed top-0 left-0 right-0 z-[9999] flex items-center justify-between gap-4 px-5 py-2.5
            bg-gradient-to-r from-purple-600 to-indigo-600 text-white shadow-2xl">
        <div class="flex items-center gap-2.5 text-[13px] font-semibold">
            <i class="fas fa-right-to-bracket text-purple-200"></i>
            <span>
                You are currently logged in as
                <span class="font-black underline decoration-dotted">{{ auth()->user()->name }}</span>
                (Impersonation Mode)
            </span>
        </div>
        <form action="{{ route('impersonate.stop') }}" method="POST">
            @csrf
            <button type="submit"
                class="flex items-center gap-2 px-4 py-1.5 rounded-lg bg-white/20 hover:bg-white/30 transition font-bold text-[12px] border border-white/30">
                <i class="fas fa-right-from-bracket"></i> Stop Impersonating
            </button>
        </form>
    </div>
    <div class="h-10"></div>{{-- spacer so page content is not hidden behind banner --}}
@endif
