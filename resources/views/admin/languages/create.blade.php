@extends('admin.layouts.master')

@section('admin')
    <section class="space-y-6">
        <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] border rounded-2xl p-6">
            <h2 class="text-[20px] font-extrabold dark:text-white text-gray-800 mb-4"> <i class="fas fa-plus"></i> Create
                Language</h2>

            <form action="{{ route('admin.language.store') }}" method="POST">
                @csrf
                <div class="space-y-5">

                    <!-- INPUT ROW -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <!-- Title -->
                        <div>
                            <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">
                                Title
                            </label>

                            <input type="text" name="title" value="{{ old('title') }}" placeholder="Language title"
                                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
                border border-black/[0.1] dark:border-white/[0.1]">

                            @error('title')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Language Code -->
                        <div>
                            <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">
                                Language Code
                            </label>

                            <input type="text" name="language_code" value="{{ old('language_code') }}"
                                placeholder="e.g. en, bn, de"
                                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
                border border-black/[0.1] dark:border-white/[0.1]">

                            @error('language_code')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- BUTTON ROW -->
                    <div class="flex justify-between items-center pt-3">

                        <!-- LEFT (optional info / can remove) -->
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">
                            Please fill all required fields carefully
                        </p>

                        <!-- RIGHT BUTTONS -->
                        <div class="flex gap-2">
                            <a href="{{ route('admin.languages') }}"
                                class="px-4 py-2 rounded-[10px] text-[14px] font-bold
                dark:bg-white/[0.07] bg-gray-100
                dark:text-white text-gray-800">
                                <i class="fas fa-times"></i> Cancel
                            </a>

                            <button type="submit"
                                class="px-5 py-2 rounded-[10px] text-white text-[14px] font-bold
                bg-gradient-to-r from-orange-500 to-pink-500
                shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </section>
@endsection
