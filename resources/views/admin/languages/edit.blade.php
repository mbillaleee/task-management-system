@extends('admin.layouts.master')

@section('admin')
    <section class="space-y-6">
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-6">
            <h2 class="text-[20px] font-extrabold dark:text-white text-gray-900 mb-4"> <i class="fas fa-edit"></i> Edit
                Language</h2>

            <form action="{{ route('admin.language.update', $language) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Title</label>
                        <input type="text" name="title" value="{{ $language->title }}" placeholder="Language title"
                            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 border border-black/[0.1] dark:border-white/[0.1]">
                        @error('title')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Language
                            Code</label>
                        <input type="text" name="language_code" value="{{ $language->language_code }}"
                            placeholder="e.g. en, bn, de"
                            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 border border-black/[0.1] dark:border-white/[0.1]">
                        @error('language_code')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="active" {{ $language->active ? 'checked' : '' }}>
                            Active
                        </label>
                    </div>

                    <div class="flex justify-end gap-2 pt-3">
                        <a href="{{ route('admin.languages') }}"
                            class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit"
                            class="px-5 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
