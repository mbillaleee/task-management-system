@extends('admin.layouts.master')

@section('admin')



    <section class="flex-1 p-4 sm:p-5 flex flex-col gap-4">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold dark:text-white text-gray-900">Role Management</h2>
                <p class="text-[14px] dark:text-gray-400 text-gray-500 mt-1">
                    Manage user roles with a clean and premium admin interface.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.roles.create') }}"
                    class="px-4 py-2 rounded-[10px] bg-gradient-to-r from-orange-500 to-pink-500 text-white font-bold hover:opacity-90 transition flex items-center gap-1">
                    <i class="fas fa-user-shield"></i> Create New Role
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="px-4 py-2 rounded-[10px] bg-gray-100 dark:bg-[#1a1625] dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#2a1f38] transition flex items-center gap-1">
                    <i class="fas fa-users"></i> Users
                </a>
                <a href="{{ route('admin.permissions.index') }}"
                    class="px-4 py-2 rounded-[10px] bg-gray-100 dark:bg-[#1a1625] dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#2a1f38] transition flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Permissions
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
            <div
                class="hover-lift p-4 rounded-2xl dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-orange-500/20 flex items-center justify-center mb-2">
                    <i class="fas fa-user-shield text-orange-500"></i>
                </div>
                <div class="text-[20px] font-bold dark:text-white text-gray-900">{{ $roles->total() ?? $roles->count() }}
                </div>
                <div class="text-[12px] dark:text-gray-400 text-gray-500">Total Roles</div>
            </div>
            <div
                class="hover-lift p-4 rounded-2xl dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-pink-500/20 flex items-center justify-center mb-2">
                    <i class="fas fa-layer-group text-pink-500"></i>
                </div>
                <div class="text-[20px] font-bold dark:text-white text-gray-900">{{ $roles->count() }}</div>
                <div class="text-[12px] dark:text-gray-400 text-gray-500">Current Page Items</div>
            </div>
            <div
                class="hover-lift p-4 rounded-2xl dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-amber-500/20 flex items-center justify-center mb-2">
                    <i class="fas fa-lock text-amber-500"></i>
                </div>
                <div class="text-[20px] font-bold dark:text-white text-gray-900">Active</div>
                <div class="text-[12px] dark:text-gray-400 text-gray-500">Role Access Control</div>
            </div>
        </div>

        <!-- Roles Table -->
        <div
            class="mt-5 overflow-x-auto rounded-2xl border dark:border-white/[0.07] border-gray-200 dark:bg-[#17141f] bg-white p-4 hover-lift">
            <div class="mb-3 flex justify-between items-center">
                <h3 class="text-[16px] font-bold dark:text-white text-gray-900">
                    <i class="fas fa-users-cog text-orange-500 mr-2"></i> Role List
                </h3>
                <input type="text" id="roleSearch" placeholder="Search role by name..."
                    class="px-3 py-2 rounded-lg border dark:border-white/20 border-gray-300 dark:bg-[#1a1625] dark:text-gray-300 focus:outline-none w-64">
            </div>

            @if ($roles->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left">
                        <thead
                            class="text-[12px] uppercase dark:text-gray-400 text-gray-500 border-b border-gray-200 dark:border-white/[0.1]">
                            <tr>
                                <th class="px-3 py-2 w-16">#</th>
                                <th class="px-3 py-2">Role Name</th>
                                <th class="px-3 py-2 w-32">Status</th>
                                <th class="px-3 py-2 text-center w-64">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="roleTable">
                            @foreach ($roles as $key => $role)
                                <tr
                                    class=" dark:text-white text-gray-500 border-b border-gray-200 dark:border-white/[0.05] hover:bg-gray-50 dark:hover:bg-white/5">
                                    <td class="px-3 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-3 py-2">
                                        <div class="font-semibold dark:text-white text-gray-900">{{ $role->name }}</div>
                                        <small class="text-gray-500 dark:text-gray-400">Access control role</small>
                                    </td>
                                    <td class="px-3 py-2">
                                        <span
                                            class="px-2 py-1 rounded-full text-[12px] font-semibold bg-green-100 dark:bg-green-700 text-green-600 dark:text-green-200">Active</span>
                                    </td>
                                    <td class="px-3 py-2 text-center flex justify-center gap-2">
                                        <a href="{{ route('admin.roles.show', $role->id) }}"
                                            class="text-blue-500 hover:text-blue-600"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                                            class="text-green-500 hover:text-green-600"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this role?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            <tr id="noSearchResultRow" style="display:none;">
                                <td colspan="4" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                    No matching role found. Try another keyword.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-6 text-center text-gray-500 dark:text-gray-400">
                    No roles found.
                </div>
            @endif

            <div class="mt-3 flex justify-end">
                {{ $roles->links() }}
            </div>
        </div>

    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('roleSearch');
            const tableRows = document.querySelectorAll('#roleTable tr');

            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                let visibleCount = 0;
                tableRows.forEach(row => {
                    if (row.id === 'noSearchResultRow') return;
                    const text = row.innerText.toLowerCase();
                    const match = text.includes(filter);
                    row.style.display = match ? '' : 'none';
                    if (match) visibleCount++;
                });
                document.getElementById('noSearchResultRow').style.display = visibleCount === 0 ? '' :
                    'none';
            });
        });
    </script>
@endsection
