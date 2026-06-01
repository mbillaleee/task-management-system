@extends('admin.layouts.master')

@section('admin')
    <section class="flex-1 p-4 sm:p-5 flex flex-col gap-4">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold dark:text-white text-gray-900">Users Management</h2>
                <p class="text-[14px] dark:text-gray-400 text-gray-500 mt-1">Manage system users, roles, and permissions.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.users.create') }}"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-[10px] text-white font-bold bg-gradient-to-r from-orange-500 to-pink-500 hover:opacity-90 transition">
                    <i class="fas fa-user-plus"></i> Create User
                </a>
                <a href="{{ route('admin.roles.index') }}"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-[10px] text-white font-semibold bg-gradient-to-r from-amber-500 to-orange-500 hover:opacity-90 transition">
                    <i class="fas fa-user-shield"></i> Roles
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
            @php
                $totalUsers = \App\Models\User::count();
                $currentPageCount = $data->count();
            @endphp

            <div
                class="hover-lift p-4 rounded-2xl dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-orange-500/20 flex items-center justify-center mb-2">
                    <i class="fas fa-users text-orange-500"></i>
                </div>
                <div class="text-[20px] font-bold dark:text-white text-gray-900">{{ $totalUsers }}</div>
                <div class="text-[12px] dark:text-gray-400 text-gray-500">Total Users</div>
            </div>

            <div
                class="hover-lift p-4 rounded-2xl dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-pink-500/20 flex items-center justify-center mb-2">
                    <i class="fas fa-user-check text-pink-500"></i>
                </div>
                <div class="text-[20px] font-bold dark:text-white text-gray-900">{{ $currentPageCount }}</div>
                <div class="text-[12px] dark:text-gray-400 text-gray-500">Current Page Items</div>
            </div>

            <div
                class="hover-lift p-4 rounded-2xl dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-amber-500/20 flex items-center justify-center mb-2">
                    <i class="fas fa-user-shield text-amber-500"></i>
                </div>
                <div class="text-[20px] font-bold dark:text-white text-gray-900">Role Based</div>
                <div class="text-[12px] dark:text-gray-400 text-gray-500">Access Control</div>
            </div>
        </div>

        <!-- Users Table -->
        <div
            class="mt-5 overflow-x-auto rounded-2xl border dark:border-white/[0.07] border-black/[0.07] dark:bg-[#17141f] bg-white p-4 hover-lift">
            <div class="mb-3 flex justify-between items-center">
                <h3 class="text-[16px] font-bold dark:text-white text-gray-900"><i
                        class="fas fa-list text-orange-500 mr-2"></i> Users List</h3>
                <input type="text" id="userSearch" placeholder="Search by name, email or role..."
                    class="px-3 py-2 rounded-lg border dark:border-white/[0.1] border-gray-300 dark:bg-[#1a1625] dark:text-gray-300 focus:outline-none focus:ring-1 focus:ring-orange-500 w-64">
            </div>
            <table class="min-w-full text-left">
                <thead
                    class="text-[12px] uppercase dark:text-gray-400 text-gray-500 border-b border-gray-200 dark:border-white/[0.1]">
                    <tr>
                        <th class="px-3 py-2">No</th>
                        <th class="px-3 py-2">Name</th>
                        <th class="px-3 py-2">Email</th>
                        <th class="px-3 py-2">Roles</th>
                        <th class="px-3 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTable">
                    @foreach ($data as $key => $user)
                        <tr
                            class="border-b border-gray-200 dark:border-white/[0.05] hover:bg-gray-50 dark:hover:bg-white/5">
                            <td class="px-3 py-2 text-white dark:text-white">{{ $key + 1 }}</td>
                            <td class="px-3 py-2 text-white dark:text-white">{{ $user->name }}</td>
                            <td class="px-3 py-2 text-white dark:text-white">{{ $user->email }}</td>
                            <td class="px-3 py-2 text-white dark:text-white">
                                @foreach ($user->getRoleNames() as $role)
                                    <span
                                        class="px-2 py-1 rounded-lg bg-gradient-to-r from-orange-500 to-pink-500 text-white text-[12px] font-semibold mr-1">{{ $role }}</span>
                                @endforeach
                            </td>
                            <td class="px-3 py-2 text-center flex justify-center gap-2">
                                <a href="{{ route('admin.users.show', $user->id) }}"
                                    class="text-blue-500 hover:text-blue-600"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="text-green-500 hover:text-green-600"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600"><i
                                            class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($data->count() == 0)
                <div class="py-6 text-center text-gray-500 dark:text-gray-400">
                    No users found.
                </div>
            @endif

            <div class="mt-3 flex justify-end">
                {!! $data->links() !!}
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('userSearch');
            const tableRows = document.querySelectorAll('#usersTable tr');

            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                let visibleCount = 0;
                tableRows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    const match = text.includes(filter);
                    row.style.display = match ? '' : 'none';
                    if (match) visibleCount++;
                });
            });
        });
    </script>
@endsection
