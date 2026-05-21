@extends('user.layouts.master')

@section('user')
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

        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 rounded-2xl p-5 mt-4">

            <form method="POST" action="{{ route('profile.update.account') }}" enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-4">

                @csrf
                @method('PATCH')


                <!-- Username -->
                <div>
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">
                        Username
                    </label>

                    <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}"
                        class="mt-1 block w-full px-3 py-2 rounded-lg border dark:border-white/20 border-gray-300 dark:bg-[#1a1625] dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                        placeholder="Enter username">

                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>


                <!-- Phone -->
                <div>
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">
                        Phone Number
                    </label>

                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                        class="mt-1 block w-full px-3 py-2 rounded-lg border dark:border-white/20 border-gray-300 dark:bg-[#1a1625] dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                        placeholder="Enter phone number">

                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">
                        Gender
                    </label>

                    <select name="gender"
                        class="mt-1 block w-full px-3 py-2 rounded-lg border dark:border-white/20 border-gray-300 dark:bg-[#1a1625] dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">

                        <option value="">Select Gender</option>

                        <option value="Male" {{ old('gender', auth()->user()->gender) == 'Male' ? 'selected' : '' }}>
                            Male
                        </option>

                        <option value="Female" {{ old('gender', auth()->user()->gender) == 'Female' ? 'selected' : '' }}>
                            Female
                        </option>

                        <option value="Other" {{ old('gender', auth()->user()->gender) == 'Other' ? 'selected' : '' }}>
                            Other
                        </option>

                    </select>

                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>

                <!-- Date of Birth -->
                <div>
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">
                        Date of Birth
                    </label>

                    <input type="date" name="date_of_birth"
                        value="{{ old('date_of_birth', auth()->user()->date_of_birth) }}"
                        class="mt-1 block w-full px-3 py-2 rounded-lg border dark:border-white/20 border-gray-300 dark:bg-[#1a1625] dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">

                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                </div>

                <!-- Country -->
                <div>
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">
                        Country
                    </label>

                    <input type="text" name="country" value="{{ old('country', auth()->user()->country) }}"
                        class="mt-1 block w-full px-3 py-2 rounded-lg border dark:border-white/20 border-gray-300 dark:bg-[#1a1625] dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                        placeholder="Enter country">

                    <x-input-error :messages="$errors->get('country')" class="mt-2" />
                </div>

                <!-- City -->
                <div>
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">
                        City
                    </label>

                    <input type="text" name="city" value="{{ old('city', auth()->user()->city) }}"
                        class="mt-1 block w-full px-3 py-2 rounded-lg border dark:border-white/20 border-gray-300 dark:bg-[#1a1625] dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                        placeholder="Enter city">

                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                </div>

                <!-- Timezone -->
                <div>
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">
                        Timezone
                    </label>

                    <input type="text" name="timezone" value="{{ old('timezone', auth()->user()->timezone) }}"
                        class="mt-1 block w-full px-3 py-2 rounded-lg border dark:border-white/20 border-gray-300 dark:bg-[#1a1625] dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                        placeholder="Enter timezone">

                    <x-input-error :messages="$errors->get('timezone')" class="mt-2" />
                </div>

                <!-- Profile Image -->
                <div class="md:col-span-2-">
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">
                        Profile Image
                    </label>

                    <input type="file" name="profile"
                        class="mt-1 block w-full px-3 py-2 rounded-lg border dark:border-white/20 border-gray-300 dark:bg-[#1a1625] dark:text-white focus:outline-none">

                    <x-input-error :messages="$errors->get('profile')" class="mt-2" />

                    @if (auth()->user()->profile)
                        <div class="mt-3">
                            <img src="{{ asset('storage/profile/' . auth()->user()->profile) }}" alt="Profile"
                                class="w-20 h-20 rounded-xl object-cover border dark:border-white/10">
                        </div>
                    @endif
                </div>

                <!-- Bio -->
                <div class="md:col-span-2">
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">
                        Bio
                    </label>

                    <textarea name="bio" rows="4"
                        class="mt-1 block w-full px-3 py-2 rounded-lg border dark:border-white/20 border-gray-300 dark:bg-[#1a1625] dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                        placeholder="Write something about yourself...">{{ old('bio', auth()->user()->bio) }}</textarea>

                    <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-2 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-pink-500 text-white font-semibold hover:opacity-90 transition">
                        Update Information
                    </button>
                </div>

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
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">Current
                        Password</label>
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
                    <label class="block text-[13px] font-semibold dark:text-gray-300 text-gray-700">Confirm
                        Password</label>
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
