@extends('admin.layouts.master')

@section('admin')
    <section class="flex-1 p-4 sm:p-5 flex flex-col gap-4">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold dark:text-white text-gray-900">Permission Management</h2>
                <p class="text-[14px] dark:text-gray-400 text-gray-500 mt-1">
                    Manage application permissions with a cleaner and user-friendly admin interface.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="button" onclick="openModal('addPermissionModal')"
                    class="px-4 py-2 rounded-[10px] bg-gradient-to-r from-orange-500 to-pink-500 text-white font-bold hover:opacity-90 transition flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Add Permission
                </button>
                <a href="{{ route('admin.roles.index') }}"
                    class="px-4 py-2 rounded-[10px] bg-gray-100 dark:bg-[#1a1625] dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#2a1f38] transition flex items-center gap-1">
                    <i class="fas fa-user-shield"></i> Roles
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="px-4 py-2 rounded-[10px] bg-gray-100 dark:bg-[#1a1625] dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#2a1f38] transition flex items-center gap-1">
                    <i class="fas fa-user"></i> Users
                </a>
            </div>
        </div>

        <!-- Permissions Table & Actions -->
        <div class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 rounded-2xl p-4">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-[16px] font-bold dark:text-white text-gray-900">
                    <i class="fas fa-shield-alt text-orange-500 mr-2"></i> Permission List
                </h3>
                <button type="button" onclick="openModal('addPermissionModal')"
                    class="px-4 py-2 rounded-[10px] bg-gradient-to-r from-orange-500 to-pink-500 text-white font-bold hover:opacity-90 flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Add Permission
                </button>
            </div>

            <!-- Table (same as before) -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-left" id="permissionTable">
                    <thead
                        class="text-[12px] uppercase dark:text-white text-gray-500 border-b border-gray-200 dark:border-white/[0.1]">
                        <tr>
                            <th class="px-3 py-2 w-16">#</th>
                            <th class="px-3 py-2">Permission Name</th>
                            <th class="px-3 py-2 w-32">Guard</th>
                            <th class="px-3 py-2 text-center w-64">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $permission)
                            <tr
                                class=" dark:text-white text-gray-500 border-b border-gray-200 dark:border-white/[0.05] hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="px-3 py-2">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2">{{ $permission->name }}</td>
                                <td class="px-3 py-2">{{ $permission->guard_name ?? 'web' }}</td>
                                <td class="px-3 py-2 text-center flex justify-center gap-2">
                                    <button type="button"
                                        onclick="openEditModal({{ $permission->id }}, '{{ $permission->name }}')"
                                        class="px-3 py-1 rounded-lg bg-gradient-to-r from-orange-500 to-pink-500 text-white flex items-center gap-1">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 rounded-lg bg-red-500 text-white flex items-center gap-1">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Permission Modal -->
        <div id="addPermissionModal" class="fixed inset-0 hidden items-center justify-center z-50 bg-black/40">
            <div class="bg-white dark:bg-[#17141f] rounded-2xl w-96 p-5 hover-lift">
                <h5 class="text-[16px] font-bold dark:text-white text-gray-900 mb-4">
                    <i class="fas fa-plus-circle text-green-500 mr-2"></i> Add New Permission
                </h5>
                <form method="POST" action="{{ route('admin.permissions.store') }}">
                    @csrf
                    <label class="block text-[14px] font-semibold dark:text-gray-300 text-gray-700 mb-1">Permission
                        Name</label>
                    <input type="text" name="name" required
                        class="w-full px-3 py-2 rounded-lg border dark:border-white/20 dark:bg-[#1a1625] dark:text-white mb-3">
                    <input type="hidden" name="guard_name" value="web">
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal('addPermissionModal')"
                            class="px-4 py-2 rounded-lg border bg-gray-100 dark:bg-[#1a1625] dark:text-gray-300">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-gradient-to-r from-orange-500 to-pink-500 text-white font-bold">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Permission Modal -->
        <div id="editPermissionModal" class="fixed inset-0 hidden items-center justify-center z-50 bg-black/40">
            <div class="bg-white dark:bg-[#17141f] rounded-2xl w-96 p-5 hover-lift">
                <h5 class="text-[16px] font-bold dark:text-white text-gray-900 mb-4">
                    <i class="fas fa-edit text-orange-500 mr-2"></i> Update Permission
                </h5>
                <form method="POST" id="editPermissionForm">
                    @csrf
                    @method('PUT')
                    <label class="block text-[14px] font-semibold dark:text-gray-300 text-gray-700 mb-1">Permission
                        Name</label>
                    <input type="text" name="name" id="editPermissionName" required
                        class="w-full px-3 py-2 rounded-lg border dark:border-white/20 dark:bg-[#1a1625] dark:text-white mb-3">
                    <input type="hidden" name="guard_name" value="web">
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal('editPermissionModal')"
                            class="px-4 py-2 rounded-lg border bg-gray-100 dark:bg-[#1a1625] dark:text-gray-300">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-gradient-to-r from-orange-500 to-pink-500 text-white font-bold">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </section>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('flex');
            document.getElementById(id).classList.add('hidden');
        }

        function openEditModal(id, name) {
            const form = document.getElementById('editPermissionForm');
            form.action = '/admin/permissions/' + id; // Laravel PUT route
            document.getElementById('editPermissionName').value = name;
            openModal('editPermissionModal');
        }

        // Search filter
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('permissionSearch');
            const tableRows = document.querySelectorAll('#permissionTable tr');

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
