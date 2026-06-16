@extends('user.layouts.master')

@section('user')
    <div class="space-y-5">

        <section class="relative veroa-card px-6 py-6 rounded-2xl border">
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

                    <a href="{{ route('user.note-categories.index') }}"
                        class="px-6 py-3 rounded-xl text-[15px] font-bold
                dark:bg-white/[0.07] bg-white
                dark:text-gray-300 text-gray-700
                border dark:border-white/[0.08] border-black/[0.08]">
                        <i class="fas fa-list"></i> Categories
                    </a>

                    <button type="button" onclick="openCreateFolderModal()"
                        class="px-6 py-3 rounded-xl text-white text-[15px] font-bold
                bg-gradient-to-r from-orange-500 to-pink-500
                shadow-[0_0_28px_rgba(249,115,22,.45)]">
                        <i class="fas fa-plus"></i> Create Folder
                    </button>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5">
            <div class="hover-lift veroa-card rounded-2xl p-[18px]">
                <p class="text-[15px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Total Folders</p>
                <h3 class="text-[36px] font-extrabold dark:text-white text-gray-900 leading-none">
                    {{ $totalFolders }}
                </h3>
                <p class="text-[14px] text-orange-400 mt-2">Folder spaces</p>
            </div>

            <div class="hover-lift veroa-card rounded-2xl p-[18px]">
                <p class="text-[15px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Current Page</p>
                <h3 class="text-[36px] font-extrabold text-pink-500 leading-none">
                    {{ $folders->count() }}
                </h3>
                <p class="text-[14px] text-pink-400 mt-2">Visible folders</p>
            </div>

            <div class="hover-lift veroa-card rounded-2xl p-[18px]">
                <p class="text-[15px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Notes Linked</p>
                <h3 class="text-[36px] font-extrabold text-amber-500 leading-none">
                    {{ $folders->sum('notes_count') }}
                </h3>
                <p class="text-[14px] text-amber-500 mt-2">On this page</p>
            </div>
        </div>

        <section
            class="rounded-2xl border dark:border-pink-500/15 bg-[#f7e4c3]/75
            dark:bg-[#080612]  backdrop-blur-xl  p-6  space-y-6
            shadow-[inset_0_1px_0_rgba(255,255,255,.65),0_20px_50px_rgba(180,95,20,.12),0_8px_20px_rgba(255,140,20,.08)]
            dark:shadow-[inset_0_1px_0_rgba(255,255,255,.03)] p-6">

            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
                <div>
                    <h2 class="text-[22px] font-extrabold dark:text-white text-gray-900">All Folders</h2>
                    <p class="text-[13px] dark:text-gray-500 text-gray-500 mt-1">
                        Search, create, update and manage your note folders.
                    </p>
                </div>

                <form method="GET" action="{{ route('user.note-folders.index') }}"
                    class="flex flex-col md:flex-row gap-2.5 w-full xl:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search folders..."
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

            @if (session('success'))
                <div
                    class="rounded-xl px-4 py-3 text-[14px] font-semibold
                bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="rounded-xl px-4 py-3 text-[14px] font-semibold
                bg-red-500/10 text-red-500 border border-red-500/20">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @forelse($folders as $folder)
                    <div
                        class="group hover-lift relative overflow-hidden rounded-2xl p-5
                    veroa-card border dark:border-white/[0.08] border-orange-200
                    transition-all duration-300">


                        <div class="relative z-10">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div
                                        class="w-12 h-12 rounded-xl flex items-center justify-center mb-4
                                    bg-gradient-to-r from-orange-500/20 to-pink-500/20
                                    border border-orange-500/20 text-[24px]">
                                        📁
                                    </div>

                                    <h3 class="text-[19px] font-extrabold dark:text-white text-gray-900">
                                        {{ $folder->name }}
                                    </h3>

                                    <p class="text-[13px] dark:text-gray-500 text-gray-500 mt-1">
                                        Slug: {{ $folder->slug }}
                                    </p>
                                </div>

                                <span
                                    class="px-3 py-1 rounded-lg text-[12px] font-bold
                                dark:bg-orange-500/[0.14] bg-orange-50 text-orange-500
                                border dark:border-orange-500/[0.22] border-orange-200">
                                    {{ $folder->notes_count }} Notes
                                </span>
                            </div>

                            <div
                                class="flex items-center justify-between mt-5 pt-4 border-t dark:border-white/[0.06] border-black/[0.05]">
                                <p class="text-[12px] dark:text-gray-500 text-gray-400">
                                    {{ $folder->created_at->format('d M Y') }}
                                </p>

                                <div class="flex items-center gap-2">
                                    <button type="button"
                                        onclick="openEditFolderModal({{ $folder->id }}, @js($folder->name), '{{ route('user.note-folders.update', $folder) }}')"
                                        class="px-3 py-2 rounded-lg text-[12px] font-bold text-white
                                    bg-gradient-to-r from-orange-500 to-pink-500">
                                        Edit
                                    </button>

                                    <form action="{{ route('user.note-folders.destroy', $folder) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('Delete this folder? Notes inside this folder will not be deleted, only folder relation will be removed.')"
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
                        <div
                            class="rounded-2xl p-10 text-center dark:bg-[#17141f] bg-white border dark:border-white/[0.08] border-orange-100">
                            <div class="text-[52px] mb-3">📁</div>
                            <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900">No folders found</h3>
                            <p class="text-[14px] dark:text-gray-500 text-gray-500 mt-2">Create your first note folder.</p>

                            <button type="button" onclick="openCreateFolderModal()"
                                class="inline-flex mt-5 px-6 py-3 rounded-xl text-white text-[14px] font-bold
                            bg-gradient-to-r from-orange-500 to-pink-500">
                                + Create Folder
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>

            <div>
                {{ $folders->links() }}
            </div>
        </section>
    </div>

    <!-- Create Folder Modal -->
    <div id="createFolderModal"
        class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/70 backdrop-blur-sm px-4">
        <div
            class="w-full max-w-md rounded-2xl dark:bg-[#17141f] bg-white border dark:border-orange-500/[0.22] border-orange-200 p-5 shadow-[0_0_40px_rgba(249,115,22,.25)]">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900">Create Folder</h3>
                <button type="button" onclick="closeCreateFolderModal()"
                    class="text-[24px] dark:text-gray-400 text-gray-500">×</button>
            </div>

            <form action="{{ route('user.note-folders.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-[14px] font-bold dark:text-gray-300 text-gray-700 mb-2">Folder Name</label>
                    <input type="text" name="name" placeholder="Example: Work Notes"
                        class="w-full px-4 py-3 rounded-xl text-[14px] outline-none
                    dark:bg-[#100b18] bg-orange-50/60
                    dark:text-white text-gray-900
                    border dark:border-white/[0.1] border-orange-200
                    focus:border-orange-400 focus:ring-2 focus:ring-orange-500/20"
                        required>
                </div>

                <button
                    class="w-full px-5 py-3.5 rounded-xl text-white text-[15px] font-extrabold
                bg-gradient-to-r from-orange-500 to-pink-500
                shadow-[0_4px_22px_rgba(249,115,22,.42)]">
                    Save Folder
                </button>
            </form>
        </div>
    </div>

    <!-- Edit Folder Modal -->
    <div id="editFolderModal"
        class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/70 backdrop-blur-sm px-4">
        <div
            class="w-full max-w-md rounded-2xl dark:bg-[#17141f] bg-white border dark:border-orange-500/[0.22] border-orange-200 p-5 shadow-[0_0_40px_rgba(249,115,22,.25)]">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900">Update Folder</h3>
                <button type="button" onclick="closeEditFolderModal()"
                    class="text-[24px] dark:text-gray-400 text-gray-500">×</button>
            </div>

            <form id="editFolderForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[14px] font-bold dark:text-gray-300 text-gray-700 mb-2">Folder Name</label>
                    <input type="text" name="name" id="editFolderName"
                        class="w-full px-4 py-3 rounded-xl text-[14px] outline-none
                    dark:bg-[#100b18] bg-orange-50/60
                    dark:text-white text-gray-900
                    border dark:border-white/[0.1] border-orange-200
                    focus:border-orange-400 focus:ring-2 focus:ring-orange-500/20"
                        required>
                </div>

                <button
                    class="w-full px-5 py-3.5 rounded-xl text-white text-[15px] font-extrabold
                bg-gradient-to-r from-orange-500 to-pink-500
                shadow-[0_4px_22px_rgba(249,115,22,.42)]">
                    Update Folder
                </button>
            </form>
        </div>
    </div>

    <script>
        function openCreateFolderModal() {
            document.getElementById('createFolderModal').classList.remove('hidden');
            document.getElementById('createFolderModal').classList.add('flex');
        }

        function closeCreateFolderModal() {
            document.getElementById('createFolderModal').classList.add('hidden');
            document.getElementById('createFolderModal').classList.remove('flex');
        }

        function openEditFolderModal(id, name, actionUrl) {
            document.getElementById('editFolderName').value = name;
            document.getElementById('editFolderForm').action = actionUrl;

            document.getElementById('editFolderModal').classList.remove('hidden');
            document.getElementById('editFolderModal').classList.add('flex');
        }

        function closeEditFolderModal() {
            document.getElementById('editFolderModal').classList.add('hidden');
            document.getElementById('editFolderModal').classList.remove('flex');
        }
    </script>
@endsection
