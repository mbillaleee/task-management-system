@extends('admin.layouts.master')

@section('admin')

    <section class="flex-1 p-4 sm:p-5 flex flex-col gap-4">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold dark:text-white text-gray-900">Show User</h2>
                <p class="text-[14px] dark:text-gray-400 text-gray-500 mt-1">View user details and assigned roles.</p>
            </div>
            <div>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-[10px] bg-gray-100 dark:bg-[#1a1625] dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#2a1f38] transition">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <!-- Summary Strip -->
        <div class="flex items-center gap-2 px-4 py-2 mb-4 rounded-lg bg-orange-50 dark:bg-[#2a1f38] text-orange-500">
            <i class="fas fa-info-circle"></i> This page displays the selected user’s profile information and current role
            assignments.
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            <!-- User Profile -->
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 rounded-2xl p-4 text-center">
                <div
                    class="w-24 h-24 mx-auto rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-300 text-[32px]">
                    <i class="fas fa-user"></i>
                </div>
                <h3 class="mt-3 text-[18px] font-bold dark:text-white text-gray-900">{{ $user->name }}</h3>
                <p class="text-[14px] dark:text-gray-400 text-gray-600">{{ $user->email }}</p>
                <div
                    class="mt-2 px-2 py-1 inline-flex items-center gap-1 text-[12px] font-semibold text-green-600 bg-green-100 dark:bg-green-800 rounded-full">
                    <i class="fas fa-user-shield"></i> {{ count($user->getRoleNames()) }} Roles Assigned
                </div>
            </div>

            <!-- User Details -->
            <div
                class="lg:col-span-2 hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 rounded-2xl p-4">
                <h3 class="text-[16px] font-bold dark:text-white text-gray-900 mb-3">
                    <i class="fas fa-id-card text-orange-500 mr-2"></i> User Details
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="flex flex-col">
                        <span class="text-[12px] font-semibold dark:text-gray-400 text-gray-500">Full Name</span>
                        <span class="mt-1 text-[14px] dark:text-white text-gray-900">{{ $user->name }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-[12px] font-semibold dark:text-gray-400 text-gray-500">Email Address</span>
                        <span class="mt-1 text-[14px] dark:text-white text-gray-900">{{ $user->email }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-[12px] font-semibold dark:text-gray-400 text-gray-500">Status</span>
                        <span class="mt-1">
                            @if ($user->status == 1)
                                <span
                                    class="px-2 py-1 text-[12px] font-semibold text-white bg-green-500 rounded-full">Active</span>
                            @else
                                <span
                                    class="px-2 py-1 text-[12px] font-semibold text-white bg-gray-500 rounded-full">Inactive</span>
                            @endif
                        </span>
                    </div>

                    <div class="flex flex-col md:col-span-2">
                        <span class="text-[12px] font-semibold dark:text-gray-400 text-gray-500 mb-1">Assigned Roles</span>
                        <div class="flex flex-wrap gap-2">
                            @if (!empty($user->getRoleNames()) && count($user->getRoleNames()) > 0)
                                @foreach ($user->getRoleNames() as $role)
                                    <span
                                        class="px-2 py-1 rounded-full text-[12px] font-semibold bg-gradient-to-r from-orange-500 to-pink-500 text-white inline-flex items-center gap-1">
                                        <i class="fas fa-check-circle"></i>{{ $role }}
                                    </span>
                                @endforeach
                            @else
                                <div
                                    class="px-3 py-2 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-white/[0.1] rounded-lg flex flex-col items-center">
                                    <i class="fas fa-user-slash text-[18px] mb-1"></i>
                                    <span class="font-semibold">No roles assigned</span>
                                    <small>This user currently does not have any assigned role.</small>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection
