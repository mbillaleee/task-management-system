@extends('admin.layouts.master')

@section('admin')
    <section class="flex-1 p-4 sm:p-5 flex flex-col gap-4">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[24px] font-extrabold dark:text-white text-gray-900">Update Profile & Password</h2>
                <p class="text-[13px] dark:text-gray-400 text-gray-500 mt-1">Manage your account information and password
                    securely.</p>
            </div>
        </div>

        <!-- Profile Update Form -->
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 rounded-2xl p-5 mt-4">
            <form method="POST" action="{{ route('profile.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                @method('patch')

                <!-- Name -->
                <div>
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus
                        class="mt-1 block w-full px-3 py-2 rounded-lg border dark:border-white/20 dark:bg-[#1a1625] dark:text-white focus:outline-none"
                        placeholder="Enter your name">
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="mt-1 block w-full px-3 py-2 rounded-lg border dark:border-white/20 dark:bg-[#1a1625] dark:text-white focus:outline-none"
                        placeholder="Enter your email">
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit"
                        class="px-4 py-2 rounded-[10px] bg-gradient-to-r from-orange-500 to-pink-500 text-white font-bold hover:opacity-90 transition flex items-center gap-1">
                        <i class="fas fa-save"></i> Update Profile
                    </button>
                </div>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm dark:text-gray-400 text-gray-600 mt-2">
                        Profile updated successfully.
                    </p>
                @endif
            </form>
        </div>

        <!-- Password Update Form -->
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 rounded-2xl p-5 mt-4">
            <form method="POST" action="{{ route('password.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                @method('put')

                <!-- Current Password -->
                <div>
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">Current Password</label>
                    <input type="password" name="current_password" autocomplete="current-password"
                        class="mt-1 block w-full px-3 py-2 rounded-lg border dark:border-white/20 dark:bg-[#1a1625] dark:text-white focus:outline-none"
                        placeholder="Enter current password">
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <!-- New Password -->
                <div>
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">New Password</label>
                    <input type="password" name="password" autocomplete="new-password"
                        class="mt-1 block w-full px-3 py-2 rounded-lg border dark:border-white/20 dark:bg-[#1a1625] dark:text-white focus:outline-none"
                        placeholder="Enter new password">
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" autocomplete="new-password"
                        class="mt-1 block w-full px-3 py-2 rounded-lg border dark:border-white/20 dark:bg-[#1a1625] dark:text-white focus:outline-none"
                        placeholder="Confirm new password">
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit"
                        class="px-4 py-2 rounded-[10px] bg-gradient-to-r from-orange-500 to-pink-500 text-white font-bold hover:opacity-90 transition flex items-center gap-1">
                        <i class="fas fa-save"></i> Update Password
                    </button>
                </div>

                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm dark:text-gray-400 text-gray-600 mt-2">
                        Password updated successfully.
                    </p>
                @endif
            </form>
        </div>

    </section>
@endsection
