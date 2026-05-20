@extends('admin.layouts.master')

@section('admin')


    {{-- 
    Role Show Page
    ----------------
    This page displays the selected role details and all assigned permissions.
    - Light & dark mode compatible
    - Hover lift effect on cards
    - Gradient badges for assigned permissions
    - Responsive grid layout for role info and permissions
    - English labels in code, design guidelines described in comments
--}}

    <section class="flex-1 p-4 sm:p-5 flex flex-col gap-4">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[24px] font-extrabold dark:text-white text-gray-900">Show Role</h2>
                <p class="text-[13px] dark:text-gray-400 text-gray-500 mt-1">
                    View the selected role details and all currently assigned permissions.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.roles.index') }}"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-[10px] bg-gray-100 dark:bg-[#1a1625] dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#2a1f38] transition">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <!-- Summary Strip -->
        <div class="flex items-center gap-2 px-4 py-2 mb-4 rounded-lg bg-orange-50 dark:bg-[#2a1f38] text-orange-500">
            <i class="fas fa-info-circle"></i>
            This page displays the selected role name and all assigned permissions.
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            <!-- Role Info Card -->
            <div
                class="hover-lift relative dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 rounded-2xl p-5 text-center">
                {{-- Gradient overlay --}}
                <div
                    class="absolute inset-0 rounded-2xl bg-gradient-to-br from-orange-500 to-pink-500 opacity-5 pointer-events-none">
                </div>

                {{-- Icon --}}
                <div class="text-[32px] mb-3 text-gray-500 dark:text-gray-300">
                    <i class="fas fa-user-shield"></i>
                </div>

                {{-- Role Name --}}
                <div class="font-semibold text-[12px] text-gray-500 dark:text-gray-400">Role</div>
                <h4 class="text-[18px] font-bold dark:text-white text-gray-900 mb-3">{{ $role->name }}</h4>

                <hr class="border-gray-200 dark:border-white/[0.1] my-3">

                {{-- Permission Count --}}
                <div
                    class="inline-flex items-center gap-2 px-2 py-1 rounded-full bg-green-100 dark:bg-green-800 text-green-600 dark:text-green-200 text-[12px] font-semibold">
                    <i class="fas fa-key"></i>
                    {{ !empty($rolePermissions) ? count($rolePermissions) : 0 }} Permissions
                </div>
            </div>

            <!-- Permissions List -->
            <div
                class="lg:col-span-2 hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-gray-200 rounded-2xl p-5">
                <h3 class="text-[16px] font-bold dark:text-white text-gray-900 mb-4">
                    <i class="fas fa-shield-alt text-orange-500 mr-2"></i> Assigned Permissions
                </h3>

                <div class="flex flex-wrap gap-2">
                    @if (!empty($rolePermissions) && count($rolePermissions) > 0)
                        @foreach ($rolePermissions as $v)
                            <span
                                class="px-3 py-1 rounded-full text-[12px] font-semibold bg-gradient-to-r from-orange-500 to-pink-500 text-white flex items-center gap-1">
                                <i class="fas fa-check-circle"></i> {{ $v->name }}
                            </span>
                        @endforeach
                    @else
                        <div
                            class="py-6 text-center w-full text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-white/[0.1] rounded-lg">
                            <i class="fas fa-folder-open text-[18px] mb-1"></i>
                            <div class="font-semibold">No permissions assigned</div>
                            <small>This role currently does not have any assigned permissions.</small>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Design Guideline --}}
        <div class="mt-6 text-sm text-gray-600 dark:text-gray-400">
            <p>
                Design Guidelines:
                - All text labels in code are in English.
                - The card and badges use gradient styles consistent with Veroa dashboard.
                - Hover lift is applied to cards for interactive feedback.
                - Light and dark mode support is implemented via Tailwind classes.
                - Responsive layout ensures proper alignment on mobile and desktop screens.
            </p>
        </div>

    </section>
@endsection
