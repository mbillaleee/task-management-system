@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">

        {{-- Header --}}
        <div class="flex items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-800">
                    <i class="fas fa-plus mr-1"></i> Create Habit
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    Add a positive or negative habit with daily or weekly frequency.
                </p>
            </div>
            <a href="{{ route('user.habits.index') }}"
                class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white
                dark:text-white text-gray-800 border dark:border-white/[0.08] border-black/[0.08]">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
        </div>

        {{-- ─── Quick Add Category (separate form, outside main form) ── --}}
        <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-4">
            <p class="text-[11px] font-bold dark:text-white text-gray-800 uppercase tracking-wider mb-3">
                <i class="fas fa-folder mr-1 text-orange-400"></i> Quick Add Category
            </p>

            <form action="{{ route('user.habit-categories.store') }}" method="POST">
                @csrf
                <div class="flex items-center gap-2">
                    <input type="text" name="name" placeholder="Category name"
                        class="flex-1 min-w-0 px-3 py-2 rounded-[8px] text-[13px] outline-none
                        dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800
                        dark:border dark:border-white/[0.1] border border-black/[0.1]">

                    {{-- Color picker --}}
                    <div class="relative flex-shrink-0" title="Pick color">
                        <div id="catColorPreview"
                            class="w-9 h-9 rounded-[8px] border dark:border-white/[0.15] border-black/[0.1]
                            cursor-pointer flex items-center justify-center"
                            style="background-color:#f97316" onclick="document.getElementById('catColorInput').click()">
                            <i class="fas fa-eyedropper text-white text-[11px]"></i>
                        </div>
                        <input type="color" id="catColorInput" name="color" value="#f97316"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            oninput="document.getElementById('catColorPreview').style.backgroundColor=this.value">
                    </div>

                    <button type="submit"
                        class="flex-shrink-0 px-4 py-2 rounded-[8px] text-[13px] font-bold text-white
                        bg-gradient-to-r from-orange-500 to-pink-500 whitespace-nowrap">
                        <i class="fas fa-plus mr-1"></i> Add
                    </button>
                </div>
            </form>

            {{-- Existing categories preview --}}
            @if ($categories->count())
                <div class="flex flex-wrap gap-1.5 mt-3 pt-3 border-t dark:border-white/[0.06] border-black/[0.05]">
                    @foreach ($categories as $cat)
                        <span
                            class="flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[12px]
                            dark:bg-white/[0.06] bg-gray-50 dark:text-white text-gray-800
                            border dark:border-white/[0.08] border-black/[0.06]">
                            <span class="w-2 h-2 rounded-full flex-shrink-0"
                                style="background-color:{{ $cat->color ?? '#888' }}"></span>
                            {{ $cat->name }}
                        </span>
                    @endforeach
                </div>
            @else
                <p class="text-[12px] dark:text-gray-600 text-gray-400 mt-2 italic">No categories yet — add one above.</p>
            @endif
        </div>

        {{-- ─── Main Habit Form ─────────────────────────────────────── --}}
        <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
            <form action="{{ route('user.habits.store') }}" method="POST">
                @csrf
                @include('user.habits.partials.form', ['buttonText' => 'Save Habit'])
            </form>
        </div>

    </section>
@endsection
