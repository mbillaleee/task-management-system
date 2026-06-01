@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    Habit Details
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    View streak, completion logs and habit information.
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('user.habits.edit', $habit) }}"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    Edit Habit
                </a>

                <a href="{{ route('user.habits.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

            <div class="xl:col-span-2 space-y-4">

                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                    <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900">
                        {{ $habit->title }}
                    </h3>

                    <p class="text-[14px] dark:text-gray-400 text-gray-500 mt-3 leading-relaxed">
                        {{ $habit->description ?? 'No description added.' }}
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-5">
                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[14px] dark:text-gray-500 text-gray-400">Type</p>
                            <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                {{ ucfirst($habit->type) }}
                            </p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[14px] dark:text-gray-500 text-gray-400">Frequency</p>
                            <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                {{ ucfirst($habit->frequency) }}
                            </p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[14px] dark:text-gray-500 text-gray-400">Category</p>
                            <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                {{ $habit->category?->name ?? 'General' }}
                            </p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[14px] dark:text-gray-500 text-gray-400">Status</p>
                            <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                {{ $habit->status ? 'Active' : 'Inactive' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                    <div class="flex items-center justify-between mb-3.5">
                        <h3 class="text-[16px] font-bold dark:text-white text-gray-900">
                            Completion Logs
                        </h3>

                        @php
                            $typeClass =
                                $habit->type === 'positive'
                                    ? 'dark:bg-emerald-500/[0.15] bg-emerald-50 text-emerald-500 border-emerald-500/20'
                                    : 'dark:bg-red-500/[0.15] bg-red-50 text-red-500 border-red-500/20';

                            $frequencyClass =
                                $habit->frequency === 'daily'
                                    ? 'dark:bg-orange-500/[0.15] bg-orange-50 text-orange-500'
                                    : 'dark:bg-blue-500/[0.15] bg-blue-50 text-blue-500';

                            $completed = optional($habit->todayLog)->is_completed;
                        @endphp

                        @if ($completed)
                        @else
                            <form action="{{ route('user.habits.toggle', $habit) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-2 rounded-lg text-[14px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500">
                                    Mark Done
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="space-y-2">
                        @forelse ($habit->logs as $log)
                            <div
                                class="flex items-center justify-between py-2.5 border-b dark:border-white/[0.06] border-black/[0.05]">
                                <div>
                                    <p class="text-[14px] font-bold dark:text-gray-200 text-gray-800">
                                        {{ $log->log_date->format('d M, Y') }}
                                    </p>
                                    <p class="text-[12px] dark:text-gray-500 text-gray-400">
                                        {{ $log->created_at->format('h:i A') }}
                                    </p>
                                </div>

                                <span
                                    class="px-2.5 py-[4px] rounded-lg text-[12px] font-bold dark:bg-emerald-500/[0.15] bg-emerald-50 text-emerald-500">
                                    Completed
                                </span>
                            </div>
                        @empty
                            <div
                                class="border border-dashed dark:border-white/[0.08] border-black/[0.08] rounded-xl p-5 text-center">
                                <p class="text-[12px] dark:text-gray-500 text-gray-400">No completion logs found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-bold dark:text-white text-gray-900 mb-4">
                    Streak Summary
                </h3>

                <div class="space-y-3">
                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[13px] dark:text-gray-500 text-gray-400">Current Streak</p>
                        <h4 class="text-[28px] font-extrabold dark:text-white text-gray-900 mt-1">
                            {{ $habit->streak?->current_streak ?? 0 }}
                        </h4>
                        <p class="text-[12px] dark:text-gray-500 text-gray-400">days</p>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[13px] dark:text-gray-500 text-gray-400">Best Streak</p>
                        <h4 class="text-[28px] font-extrabold dark:text-white text-gray-900 mt-1">
                            {{ $habit->streak?->best_streak ?? 0 }}
                        </h4>
                        <p class="text-[12px] dark:text-gray-500 text-gray-400">days</p>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[13px] dark:text-gray-500 text-gray-400">Last Completed</p>
                        <h4 class="text-[15px] font-bold dark:text-white text-gray-900 mt-1">
                            {{ $habit->streak?->last_completed_date ? $habit->streak->last_completed_date->format('d M, Y') : 'Not completed yet' }}
                        </h4>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
