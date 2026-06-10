@extends('user.layouts.master')

@section('user')

    {{-- Include jscolor library for advanced color picker --}}
    <script src="https://jscolor.com/releases/2.5.0/jscolor.js"></script>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
        <div>
            <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                Task Categories
            </h2>
            <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                Manage your task categories for better organization.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('user.tasks.index') }}"
                class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                Back to Tasks
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">

        {{-- Quick Add Category --}}
        <div class="dark:bg-white/[0.03] bg-gray-50 rounded-xl p-3.5 border dark:border-white/[0.06] border-black/[0.05]">
            <p class="text-[11px] font-bold dark:text-gray-400 text-gray-500 uppercase tracking-wider mb-2.5">
                <i class="fas fa-folder mr-1 text-orange-400"></i> Quick Add Category
            </p>
            <form action="{{ route('user.task-categories.store') }}" method="POST">
                @csrf
                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <input type="text" name="name" placeholder="Category name"
                        class="flex-1 px-3 py-2 rounded-[8px] text-[13px] outline-none
                    dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
                    dark:border dark:border-white/[0.1] border border-black/[0.1]">

                    {{-- Advanced Color Picker --}}
                    <input name="color"
                        class="jscolor {hash:true,closeButton:true,position:'right',borderColor:'#f97316',backgroundColor:'#fff',width:200,height:150}"
                        value="#f97316">

                    <button type="submit"
                        class="px-3 py-2 rounded-[8px] text-[13px] font-bold text-white
                    bg-gradient-to-r from-orange-500 to-pink-500 whitespace-nowrap">
                        + Add
                    </button>
                </div>
            </form>

            {{-- Existing categories --}}
            @if ($categories->count())
                <div class="flex flex-wrap gap-1.5 mt-2.5">
                    @foreach ($categories as $cat)
                        <span
                            class="flex items-center gap-1 px-2 py-1 rounded-md text-[11px]
                        dark:bg-white/[0.06] bg-white dark:text-gray-300 text-gray-600
                        border dark:border-white/[0.08] border-black/[0.06]">
                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $cat->color }}"></span>
                            {{ $cat->name }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Quick Add Label --}}
        <div class="dark:bg-white/[0.03] bg-gray-50 rounded-xl p-3.5 border dark:border-white/[0.06] border-black/[0.05]">
            <p class="text-[11px] font-bold dark:text-gray-400 text-gray-500 uppercase tracking-wider mb-2.5">
                <i class="fas fa-tag mr-1 text-orange-400"></i> Quick Add Label
            </p>
            <form action="{{ route('user.task-labels.store') }}" method="POST">
                @csrf
                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <input type="text" name="name" placeholder="Label name"
                        class="flex-1 px-3 py-2 rounded-[8px] text-[13px] outline-none
                    dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
                    dark:border dark:border-white/[0.1] border border-black/[0.1]">

                    {{-- Advanced Color Picker --}}
                    <input name="color"
                        class="jscolor {hash:true,closeButton:true,position:'right',borderColor:'#f97316',backgroundColor:'#fff',width:200,height:150}"
                        value="#f97316">

                    <button type="submit"
                        class="px-3 py-2 rounded-[8px] text-[13px] font-bold text-white
                    bg-gradient-to-r from-orange-500 to-pink-500 whitespace-nowrap">
                        + Add
                    </button>
                </div>
            </form>

            {{-- Existing labels --}}
            @if ($labels->count())
                <div class="flex flex-wrap gap-1.5 mt-2.5">
                    @foreach ($labels as $lbl)
                        <span
                            class="px-2 py-1 rounded-md text-[11px] font-semibold
                        dark:bg-white/[0.06] bg-white border"
                            style="color: {{ $lbl->color }}; border-color: {{ $lbl->color }}">
                            #{{ strtolower($lbl->name) }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection
