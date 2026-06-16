@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-tags mr-2"></i> Journal Categories
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Manage your journal categories for daily logs, reflections and gratitude entries.
                </p>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('user.journals.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Journals
                </a>

                <button type="button" onclick="openCreateCategoryModal()"
                    class="flex items-center justify-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                    <i class="fas fa-plus mr-1"></i> Create Category
                </button>
            </div>
        </div>

        {{-- Category List --}}
        <div
            class="hover-lift dark:border-pink-500/15 bg-[#f7e4c3]/75
            dark:bg-[#080612]  backdrop-blur-xl  p-6  space-y-6
            shadow-[inset_0_1px_0_rgba(255,255,255,.65),0_20px_50px_rgba(180,95,20,.12),0_8px_20px_rgba(255,140,20,.08)]
            dark:shadow-[inset_0_1px_0_rgba(255,255,255,.03)] rounded-2xl p-[18px]">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900">
                        All Categories
                    </h3>
                    <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-1">
                        Create, edit and delete journal categories.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                @forelse($categories as $category)
                    @php
                        $categoryColor = $category->color ?? '#f97316';
                    @endphp

                    <div class="relative overflow-hidden hover-lift veroa-card rounded-2xl p-4">

                        <div class="absolute top-0 right-0 w-24 h-24 blur-3xl opacity-20"
                            style="background: {{ $categoryColor }}"></div>

                        <div class="relative z-10 flex items-start justify-between gap-3">
                            <div>
                                <h4 class="text-[16px] font-bold dark:text-white text-gray-900">
                                    {{ $category->name }}
                                </h4>

                                <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-1">
                                    {{ $category->journals_count ?? $category->journals->count() }} journals
                                </p>
                            </div>

                            <span class="px-2.5 py-[4px] rounded-lg text-[12px] font-bold border"
                                style="background: {{ $categoryColor }}22; color: {{ $categoryColor }}; border-color: {{ $categoryColor }}55;">
                                {{ $categoryColor }}
                            </span>
                        </div>

                        <div
                            class="relative z-10 flex items-center justify-between mt-5 pt-4 border-t dark:border-white/[0.06] border-black/[0.05]">
                            <button type="button"
                                onclick="openEditCategoryModal(
                                    '{{ $category->id }}',
                                    '{{ addslashes($category->name) }}',
                                    '{{ $categoryColor }}'
                                )"
                                class="px-3 py-2 rounded-lg text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>

                            <form action="{{ route('user.journal.categories.destroy', $category) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this category?')"
                                    class="px-3 py-2 rounded-lg text-[14px] font-bold dark:bg-red-500/[0.15] bg-red-50 text-red-500">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full dark:bg-white/[0.03] bg-gray-50 border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-10 text-center">
                        <h3 class="text-[18px] font-bold dark:text-white text-gray-900">
                            No categories found
                        </h3>
                        <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-1">
                            Create your first journal category.
                        </p>

                        <button type="button" onclick="openCreateCategoryModal()"
                            class="mt-4 px-5 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                            <i class="fas fa-plus mr-1"></i> Create Category
                        </button>
                    </div>
                @endforelse
            </div>

            @if (method_exists($categories, 'links'))
                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

        {{-- Create Modal --}}
        <div id="createCategoryModal"
            class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center px-4">
            <div class="w-full max-w-md veroa-card rounded-2xl p-5 shadow-2xl">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900">
                            <i class="fas fa-plus mr-2"></i> Create Journal Category
                        </h3>
                        <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-1">
                            Add a new category for journal entries.
                        </p>
                    </div>

                    <button type="button" onclick="closeCreateCategoryModal()"
                        class="w-9 h-9 rounded-lg dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700 font-bold">
                        ✕
                    </button>
                </div>

                <form action="{{ route('user.journal.categories.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
                            Category Name
                        </label>
                        <input type="text" name="name" placeholder="Example: Daily, Reflection, Gratitude"
                            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
                    </div>

                    <div>
                        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
                            Category Color
                        </label>

                        <input type="color" name="color" value="#f97316"
                            class="w-full h-12 rounded-[10px] cursor-pointer outline-none
                            dark:bg-[#1a1625] bg-white
                            dark:border dark:border-white/[0.1] border border-black/[0.1]">
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" onclick="closeCreateCategoryModal()"
                            class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </button>

                        <button type="submit"
                            class="px-5 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                            <i class="fas fa-save mr-1"></i> Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Edit Modal --}}
        <div id="editCategoryModal"
            class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center px-4">
            <div class="w-full max-w-md veroa-card rounded-2xl p-5 shadow-2xl">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900">
                            <i class="fas fa-edit mr-2"></i> Edit Journal Category
                        </h3>
                        <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-1">
                            Update category name and color.
                        </p>
                    </div>

                    <button type="button" onclick="closeEditCategoryModal()"
                        class="w-9 h-9 rounded-lg dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700 font-bold">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="editCategoryForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
                            Category Name
                        </label>
                        <input type="text" id="editCategoryName" name="name"
                            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
                    </div>

                    <div>
                        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
                            Category Color
                        </label>

                        <input type="color" id="editCategoryColor" name="color" value="#f97316"
                            class="w-full h-12 rounded-[10px] cursor-pointer outline-none
                            dark:bg-[#1a1625] bg-white
                            dark:border dark:border-white/[0.1] border border-black/[0.1]">
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" onclick="closeEditCategoryModal()"
                            class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </button>

                        <button type="submit"
                            class="px-5 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                            <i class="fas fa-save mr-1"></i> Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </section>

    <script>
        function openCreateCategoryModal() {
            document.getElementById('createCategoryModal').classList.remove('hidden');
        }

        function closeCreateCategoryModal() {
            document.getElementById('createCategoryModal').classList.add('hidden');
        }

        function openEditCategoryModal(id, name, color) {
            const form = document.getElementById('editCategoryForm');

            form.action = `/user/journal-categories/${id}`;
            document.getElementById('editCategoryName').value = name;
            document.getElementById('editCategoryColor').value = color || '#f97316';

            document.getElementById('editCategoryModal').classList.remove('hidden');
        }

        function closeEditCategoryModal() {
            document.getElementById('editCategoryModal').classList.add('hidden');
        }
    </script>
@endsection
