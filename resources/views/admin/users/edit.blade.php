@extends('admin.layouts.master')

@section('admin')


    <section class="flex-1 p-4 sm:p-5 flex flex-col gap-4">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[24px] font-extrabold dark:text-white text-gray-900">Edit User</h2>
                <p class="text-[13px] dark:text-gray-400 text-gray-500 mt-1">
                    Update user account details and assigned roles.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-[10px] bg-gray-100 dark:bg-[#1a1625] dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#2a1f38] transition">
                    <i class="fas fa-arrow-left"></i> Back to Users List
                </a>
            </div>
        </div>

        <!-- Error Alert -->
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
                <i class="fas fa-user-edit text-orange-500 mr-2"></i> Update User Information
            </h3>

            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data"
                class="flex flex-col gap-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <!-- Name -->
                    <div>
                        <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">Name <span
                                class="text-red-500">*</span></label>
                        <div
                            class="flex items-center border rounded-lg overflow-hidden dark:border-white/20 border-gray-300">
                            <span class="px-3 text-gray-400 dark:text-gray-500"><i class="fas fa-user"></i></span>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full px-3 py-2 dark:bg-[#1a1625] dark:text-white focus:outline-none"
                                placeholder="Enter full name">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">Email <span
                                class="text-red-500">*</span></label>
                        <div
                            class="flex items-center border rounded-lg overflow-hidden dark:border-white/20 border-gray-300">
                            <span class="px-3 text-gray-400 dark:text-gray-500"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-3 py-2 dark:bg-[#1a1625] dark:text-white focus:outline-none"
                                placeholder="Enter email address">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">Password</label>
                        <div
                            class="flex items-center border rounded-lg overflow-hidden dark:border-white/20 border-gray-300">
                            <span class="px-3 text-gray-400 dark:text-gray-500"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password"
                                class="w-full px-3 py-2 dark:bg-[#1a1625] dark:text-white focus:outline-none"
                                placeholder="Enter new password">
                        </div>
                        <small class="text-[11px] text-gray-500 dark:text-gray-400">Leave blank if you don't want to change
                            the password.</small>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">Confirm
                            Password</label>
                        <div
                            class="flex items-center border rounded-lg overflow-hidden dark:border-white/20 border-gray-300">
                            <span class="px-3 text-gray-400 dark:text-gray-500"><i class="fas fa-shield-alt"></i></span>
                            <input type="password" name="confirm-password"
                                class="w-full px-3 py-2 dark:bg-[#1a1625] dark:text-white focus:outline-none"
                                placeholder="Confirm new password">
                        </div>
                    </div>

                    <!-- Profile Picture -->
                    <div>
                        <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">Profile
                            Picture</label>
                        <div
                            class="flex items-center border rounded-lg overflow-hidden dark:border-white/20 border-gray-300">
                            <span class="px-3 text-gray-400 dark:text-gray-500"><i class="fas fa-user"></i></span>
                            <input type="file" name="profile"
                                class="w-full px-3 py-2 dark:bg-[#1a1625] dark:text-white focus:outline-none"
                                accept="image/*" onchange="previewProfileImage(event)">
                        </div>
                        <small class="text-[11px] text-gray-500 dark:text-gray-400">Upload a profile picture.</small>
                        <img id="profilePreview"
                            src="{{ $user->profile ? asset('storage/profile/' . $user->profile) : asset('images/default-user.webp') }}"
                            alt="Profile Preview"
                            class="mt-2 w-24 h-24 rounded-xl object-cover border border-gray-200 dark:border-white/20">
                    </div>

                    <!-- Roles -->
                    <div class="md:col-span-3">
                        <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700 mb-1">Assign Role
                            <span class="text-red-500">*</span></label>
                        <select name="role"
                            class="w-full rounded-lg border dark:border-white/20 border-gray-300 px-3 py-2 dark:bg-[#1a1625] dark:text-white">
                            <option value="" disabled>Select a role</option>
                            @foreach ($roles as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('role', $user->role ?? '') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-[11px] text-gray-500 dark:text-gray-400">Assign a single role to this
                            user.</small>
                    </div>

                </div>

                <!-- Form Buttons -->
                <div class="flex flex-wrap justify-between mt-5 gap-2">
                    <a href="{{ route('admin.users.index') }}"
                        class="px-4 py-2 rounded-[10px] border bg-gray-100 dark:bg-[#1a1625] dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#2a1f38] transition flex items-center gap-1">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 rounded-[10px] bg-gradient-to-r from-orange-500 to-pink-500 text-white font-bold hover:opacity-90 transition flex items-center gap-1">
                        <i class="fas fa-save"></i> Update User
                    </button>
                </div>
            </form>
        </div>

    </section>

    <script>
        function previewProfileImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('profilePreview').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
