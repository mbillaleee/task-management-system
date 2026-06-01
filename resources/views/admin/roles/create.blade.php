@extends('admin.layouts.master')

@section('admin')


    <section class="flex-1 p-4 sm:p-5 flex flex-col gap-4">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold dark:text-white text-gray-900">Create New Role</h2>
                <p class="text-[14px] dark:text-gray-400 text-gray-500 mt-1">
                    Create a new role and assign the appropriate permissions.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.roles.index') }}"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-[10px] bg-gray-100 dark:bg-[#1a1625] dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#2a1f38] transition">
                    <i class="fas fa-arrow-left"></i> Back to Role List
                </a>
            </div>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger p-3 rounded-lg bg-red-50 dark:bg-red-800 text-red-700 dark:text-red-300 mb-4">
                <strong><i class="fas fa-exclamation-circle mr-1"></i> Whoops!</strong> There were some problems with your
                input.
                <ul class="mt-2 ml-4 list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main Card -->
        <div class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 rounded-2xl p-5">
            <h3 class="text-[16px] font-bold dark:text-white text-gray-900 mb-4">
                <i class="fas fa-user-shield text-orange-500 mr-2"></i> Role Information
            </h3>

            <form method="POST" action="{{ route('admin.roles.store') }}" class="flex flex-col gap-4">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                    <!-- Role Name -->
                    <div>
                        <label class="block text-[14px] font-semibold dark:text-gray-300 text-gray-700">Role Name <span
                                class="text-red-500">*</span></label>
                        <div
                            class="flex items-center border rounded-lg overflow-hidden dark:border-white/20 border-gray-300">
                            <span class="px-3 text-gray-400 dark:text-gray-500"><i class="fas fa-user-tag"></i></span>
                            <input type="text" name="name" placeholder="Enter role name" value="{{ old('name') }}"
                                class="w-full px-3 py-2 dark:bg-[#1a1625] dark:text-white focus:outline-none">
                        </div>
                        <small class="text-[12px] text-gray-500 dark:text-gray-400">Example: Admin, Manager, Editor, Support
                            Agent</small>
                    </div>

                    <div
                        class="flex items-center bg-orange-50 dark:bg-[#2a1f38] p-3 rounded-lg text-[12px] dark:text-orange-400 text-orange-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Assign only the permissions this role really needs to keep your system secure.
                    </div>

                </div>

                <hr class="my-4 border-gray-200 dark:border-white/10">

                <!-- Permissions -->
                <div>
                    <h4 class="text-[14px] font-bold dark:text-white text-gray-900 mb-1"><i
                            class="fas fa-key text-yellow-500 mr-1"></i> Assign Permissions</h4>
                    <p class="text-[12px] dark:text-gray-400 text-gray-500 mb-2">Choose which permissions will be granted to
                        this role.</p>

                    <div class="flex flex-wrap justify-between mb-3 items-center">
                        <span class="text-[12px] dark:text-gray-400 text-gray-500">Available Permissions:
                            {{ count($permission) }}</span>
                        <div class="flex gap-2">
                            <button type="button" id="selectAllPermissions"
                                class="px-3 py-1 rounded-lg border border-blue-500 text-blue-500 text-[12px] hover:bg-blue-50 dark:hover:bg-blue-800 transition flex items-center gap-1">
                                <i class="fas fa-check-square"></i> Select All
                            </button>
                            <button type="button" id="unselectAllPermissions"
                                class="px-3 py-1 rounded-lg border border-gray-400 text-gray-500 text-[12px] hover:bg-gray-100 dark:hover:bg-gray-700 transition flex items-center gap-1">
                                <i class="far fa-square"></i> Unselect All
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($permission as $value)
                            <div class="hover-lift p-3 border dark:border-white/10 rounded-lg dark:bg-[#1a1625] bg-white">
                                <label
                                    class="flex items-center gap-2 cursor-pointer text-[14px] dark:text-white text-gray-900">
                                    <input type="checkbox" name="permission[{{ $value->id }}]"
                                        value="{{ $value->id }}" class="permission-checkbox" id="perm{{ $value->id }}"
                                        {{ old('permission.' . $value->id) ? 'checked' : '' }}>
                                    {{ $value->name }}
                                </label>
                                <small class="text-[12px] text-gray-500 dark:text-gray-400">System access permission</small>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-wrap justify-between mt-5 gap-2">
                    <a href="{{ route('admin.roles.index') }}"
                        class="px-4 py-2 rounded-[10px] border bg-gray-100 dark:bg-[#1a1625] dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#2a1f38] transition flex items-center gap-1">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 rounded-[10px] bg-gradient-to-r from-orange-500 to-pink-500 text-white font-bold hover:opacity-90 transition flex items-center gap-1">
                        <i class="fas fa-save"></i> Save Role
                    </button>
                </div>

            </form>
        </div>

    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllBtn = document.getElementById('selectAllPermissions');
            const unselectAllBtn = document.getElementById('unselectAllPermissions');
            const checkboxes = document.querySelectorAll('.permission-checkbox');

            selectAllBtn?.addEventListener('click', () => {
                checkboxes.forEach(cb => cb.checked = true);
            });

            unselectAllBtn?.addEventListener('click', () => {
                checkboxes.forEach(cb => cb.checked = false);
            });
        });
    </script>
@endsection
