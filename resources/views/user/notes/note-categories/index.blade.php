@extends('user.layouts.master')

@section('user')
<div class="space-y-5">

    <section
    class="relative overflow-hidden rounded-2xl border dark:border-orange-500/[0.18] border-orange-200/70
    dark:bg-[#100b18] bg-orange-50/70 px-6 py-6">

    <div class="absolute inset-0 opacity-40 pointer-events-none"
        style="background:
        radial-gradient(circle at 80% 30%, rgba(236,72,153,.35), transparent 35%),
        radial-gradient(circle at 20% 70%, rgba(249,115,22,.25), transparent 32%);">
    </div>

    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5">
        <div>
            <p class="text-[14px] font-semibold text-orange-400 mb-2"> Manage Categories.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('user.notes.index') }}"
                class="px-6 py-3 rounded-xl text-[15px] font-bold
                dark:bg-white/[0.07] bg-white
                dark:text-gray-300 text-gray-700
                border dark:border-white/[0.08] border-black/[0.08]">
                <i class="fas fa-list"></i> Notes
            </a>

            <a href="{{ route('user.note-folders.index') }}"
                class="px-6 py-3 rounded-xl text-[15px] font-bold
                dark:bg-white/[0.07] bg-white
                dark:text-gray-300 text-gray-700
                border dark:border-white/[0.08] border-black/[0.08]">
                <i class="fas fa-list"></i> Folders
            </a>

            <button type="button"  onclick="openCreateCategoryModal()"
                class="px-6 py-3 rounded-xl text-white text-[15px] font-bold
                bg-gradient-to-r from-orange-500 to-pink-500
                shadow-[0_0_28px_rgba(249,115,22,.45)]">
                <i class="fas fa-plus"></i> Create Category
            </button>
        </div>
    </div>
</section>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5">
        <div class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
            <p class="text-[15px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Total Categories</p>
            <h3 class="text-[36px] font-extrabold dark:text-white text-gray-900 leading-none">
                {{ $totalCategories }}
            </h3>
            <p class="text-[14px] text-orange-400 mt-2">Category groups</p>
        </div>

        <div class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
            <p class="text-[15px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Current Page</p>
            <h3 class="text-[36px] font-extrabold text-pink-500 leading-none">
                {{ $categories->count() }}
            </h3>
            <p class="text-[14px] text-pink-400 mt-2">Visible categories</p>
        </div>

        <div class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
            <p class="text-[15px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Notes Linked</p>
            <h3 class="text-[36px] font-extrabold text-amber-500 leading-none">
                {{ $categories->sum('notes_count') }}
            </h3>
            <p class="text-[14px] text-amber-500 mt-2">On this page</p>
        </div>
    </div>

    <section
        class="rounded-2xl border dark:border-orange-500/[0.18] border-orange-200
        dark:bg-[#0f0b18] bg-orange-50/50 p-5 space-y-5 shadow-[0_0_35px_rgba(249,115,22,.12)]">

        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
            <div>
                <h2 class="text-[22px] font-extrabold dark:text-white text-gray-900">All Categories</h2>
                <p class="text-[13px] dark:text-gray-500 text-gray-500 mt-1">
                    Search, create, update and manage your note categories.
                </p>
            </div>

            <form method="GET" action="{{ route('user.note-categories.index') }}" class="flex flex-col md:flex-row gap-2.5 w-full xl:w-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search categories..."
                    class="w-full md:w-[280px] px-4 py-3 rounded-xl text-[14px] outline-none
                    dark:bg-[#1a1625] bg-white dark:text-gray-200 text-gray-700
                    border dark:border-white/[0.1] border-orange-200
                    focus:border-orange-400 focus:ring-2 focus:ring-orange-500/20">

                <button
                    class="px-5 py-3 rounded-xl text-white text-[14px] font-bold
                    bg-gradient-to-r from-orange-500 to-pink-500
                    shadow-[0_4px_18px_rgba(249,115,22,.35)]">
                    Search
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="rounded-xl px-4 py-3 text-[14px] font-semibold
                bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="rounded-xl px-4 py-3 text-[14px] font-semibold
                bg-red-500/10 text-red-500 border border-red-500/20">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse($categories as $category)
                @php
                    $color = $category->color ?? '#f97316';
                @endphp

                <div
                    class="group hover-lift relative overflow-hidden rounded-2xl p-5
                    dark:bg-[#17141f] bg-white
                    border dark:border-pink-500/[0.18] border-orange-100
                    shadow-[0_0_25px_rgba(249,115,22,0.06)]
                    hover:shadow-[0_0_35px_rgba(236,72,153,0.16)]
                    transition-all duration-300">

                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-none"
                        style="background: radial-gradient(circle at 20% 25%, {{ $color }}24, transparent 35%),
                        radial-gradient(circle at 90% 70%, rgba(236,72,153,.12), transparent 35%);">
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 border text-[24px]"
                                    style="background: {{ $color }}18; border-color: {{ $color }}40; color: {{ $color }};">
                                    ●
                                </div>

                                <h3 class="text-[19px] font-extrabold dark:text-white text-gray-900">
                                    {{ $category->name }}
                                </h3>

                                <p class="text-[13px] dark:text-gray-500 text-gray-500 mt-1">
                                    Slug: {{ $category->slug }}
                                </p>
                            </div>

                            <span class="px-3 py-1 rounded-lg text-[12px] font-bold border"
                                style="background: {{ $color }}18; color: {{ $color }}; border-color: {{ $color }}40;">
                                {{ $category->notes_count }} Notes
                            </span>
                        </div>

                        <div class="mt-4 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-xl border border-white/10" style="background: {{ $color }}"></span>
                            <span class="text-[13px] font-semibold dark:text-gray-400 text-gray-500">
                                {{ $color }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between mt-5 pt-4 border-t dark:border-white/[0.06] border-black/[0.05]">
                            <p class="text-[12px] dark:text-gray-500 text-gray-400">
                                {{ $category->created_at->format('d M Y') }}
                            </p>

                            <div class="flex items-center gap-2">
                                <button type="button"
                                    onclick="openEditCategoryModal({{ $category->id }}, @js($category->name), @js($color), '{{ route('user.note-categories.update', $category) }}')"
                                    class="px-3 py-2 rounded-lg text-[12px] font-bold text-white
                                    bg-gradient-to-r from-orange-500 to-pink-500">
                                    Edit
                                </button>

                                <form action="{{ route('user.note-categories.destroy', $category) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete this category? Notes inside this category will not be deleted, only category relation will be removed.')"
                                        class="px-3 py-2 rounded-lg text-[12px] font-bold
                                        bg-red-500/10 text-red-500 border border-red-500/20">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 xl:col-span-3">
                    <div class="rounded-2xl p-10 text-center dark:bg-[#17141f] bg-white border dark:border-white/[0.08] border-orange-100">
                        <div class="text-[52px] mb-3">🏷️</div>
                        <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900">No categories found</h3>
                        <p class="text-[14px] dark:text-gray-500 text-gray-500 mt-2">Create your first note category.</p>

                        <button type="button" onclick="openCreateCategoryModal()"
                            class="inline-flex mt-5 px-6 py-3 rounded-xl text-white text-[14px] font-bold
                            bg-gradient-to-r from-orange-500 to-pink-500">
                            + Create Category
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <div>
            {{ $categories->links() }}
        </div>
    </section>
</div>

<!-- Create Category Modal -->
<div id="createCategoryModal" class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/70 backdrop-blur-sm px-4">
    <div class="w-full max-w-md rounded-2xl dark:bg-[#17141f] bg-white border dark:border-orange-500/[0.22] border-orange-200 p-5 shadow-[0_0_40px_rgba(249,115,22,.25)]">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900">Create Category</h3>
            <button type="button" onclick="closeCreateCategoryModal()" class="text-[24px] dark:text-gray-400 text-gray-500">×</button>
        </div>

        <form action="{{ route('user.note-categories.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-[14px] font-bold dark:text-gray-300 text-gray-700 mb-2">Category Name</label>
                <input type="text" name="name" placeholder="Example: Project Ideas"
                    class="w-full px-4 py-3 rounded-xl text-[14px] outline-none
                    dark:bg-[#100b18] bg-orange-50/60
                    dark:text-white text-gray-900
                    border dark:border-white/[0.1] border-orange-200
                    focus:border-orange-400 focus:ring-2 focus:ring-orange-500/20"
                    required>
            </div>

            <div>
                <label class="block text-[14px] font-bold dark:text-gray-300 text-gray-700 mb-2">Category Color</label>
                <input type="color" name="color" value="#f97316"
                    class="w-full h-12 rounded-xl cursor-pointer
                    dark:bg-[#100b18] bg-orange-50/60
                    border dark:border-white/[0.1] border-orange-200"
                    required>
            </div>

            <button class="w-full px-5 py-3.5 rounded-xl text-white text-[15px] font-extrabold
                bg-gradient-to-r from-orange-500 to-pink-500
                shadow-[0_4px_22px_rgba(249,115,22,.42)]">
                Save Category
            </button>
        </form>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="editCategoryModal" class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/70 backdrop-blur-sm px-4">
    <div class="w-full max-w-md rounded-2xl dark:bg-[#17141f] bg-white border dark:border-orange-500/[0.22] border-orange-200 p-5 shadow-[0_0_40px_rgba(249,115,22,.25)]">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900">Update Category</h3>
            <button type="button" onclick="closeEditCategoryModal()" class="text-[24px] dark:text-gray-400 text-gray-500">×</button>
        </div>

        <form id="editCategoryForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-[14px] font-bold dark:text-gray-300 text-gray-700 mb-2">Category Name</label>
                <input type="text" name="name" id="editCategoryName"
                    class="w-full px-4 py-3 rounded-xl text-[14px] outline-none
                    dark:bg-[#100b18] bg-orange-50/60
                    dark:text-white text-gray-900
                    border dark:border-white/[0.1] border-orange-200
                    focus:border-orange-400 focus:ring-2 focus:ring-orange-500/20"
                    required>
            </div>

            <div>
                <label class="block text-[14px] font-bold dark:text-gray-300 text-gray-700 mb-2">Category Color</label>
                <input type="color" name="color" id="editCategoryColor"
                    class="w-full h-12 rounded-xl cursor-pointer
                    dark:bg-[#100b18] bg-orange-50/60
                    border dark:border-white/[0.1] border-orange-200"
                    required>
            </div>

            <button class="w-full px-5 py-3.5 rounded-xl text-white text-[15px] font-extrabold
                bg-gradient-to-r from-orange-500 to-pink-500
                shadow-[0_4px_22px_rgba(249,115,22,.42)]">
                Update Category
            </button>
        </form>
    </div>
</div>

<script>
    function openCreateCategoryModal() {
        document.getElementById('createCategoryModal').classList.remove('hidden');
        document.getElementById('createCategoryModal').classList.add('flex');
    }

    function closeCreateCategoryModal() {
        document.getElementById('createCategoryModal').classList.add('hidden');
        document.getElementById('createCategoryModal').classList.remove('flex');
    }

    function openEditCategoryModal(id, name, color, actionUrl) {
        document.getElementById('editCategoryName').value = name;
        document.getElementById('editCategoryColor').value = color;
        document.getElementById('editCategoryForm').action = actionUrl;

        document.getElementById('editCategoryModal').classList.remove('hidden');
        document.getElementById('editCategoryModal').classList.add('flex');
    }

    function closeEditCategoryModal() {
        document.getElementById('editCategoryModal').classList.add('hidden');
        document.getElementById('editCategoryModal').classList.remove('flex');
    }
</script>
@endsection