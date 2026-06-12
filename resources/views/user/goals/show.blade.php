@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-tasks mr-2"></i> Goal Details
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    View milestones, progress and achievement tracking.
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('user.goals.edit', $goal) }}"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-edit mr-2"></i> Edit Goal
                </a>

                <a href="{{ route('user.goals.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <div class="xl:col-span-2 space-y-4">
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900">{{ $goal->title }}</h3>

                    <p class="text-[14px] dark:text-gray-400 text-gray-500 mt-3 leading-relaxed">
                        {{ $goal->description ?? 'No description added.' }}
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-5">
                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[13px] dark:text-gray-500 text-gray-400"><i class="fas fa-info-circle mr-2"></i>
                                Status</p>
                            <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                {{ ucwords(str_replace('_', ' ', $goal->status)) }}
                            </p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[13px] dark:text-gray-500 text-gray-400"><i class="fas fa-tag mr-2"></i> Type</p>
                            <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                {{ ucwords(str_replace('_', ' ', $goal->type)) }}
                            </p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[13px] dark:text-gray-500 text-gray-400"><i class="fas fa-folder mr-2"></i>
                                Category</p>
                            <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                {{ $goal->category?->name ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[13px] dark:text-gray-500 text-gray-400"><i class="fas fa-calendar-alt mr-2"></i>
                                Deadline</p>
                            <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                {{ $goal->deadline ? $goal->deadline->format('d M, Y') : 'No deadline' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="flex justify-between text-[14px] mb-2">
                            <span class="dark:text-gray-400 text-gray-500 font-bold"><i class="fas fa-chart-line mr-2"></i>
                                Overall Progress</span>
                            <span class="dark:text-white text-gray-900 font-bold">{{ $goal->progress }}%</span>
                        </div>

                        <div class="w-full h-[10px] rounded-full dark:bg-white/[0.08] bg-gray-100 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500"
                                style="width: {{ $goal->progress }}%"></div>
                        </div>
                    </div>
                </div>

                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                    <h3 class="text-[16px] font-bold dark:text-white text-gray-900 mb-3.5">
                        <i class="fas fa-flag mr-2"></i> Milestones
                    </h3>

                    <form action="{{ route('user.goals.milestones.store', $goal) }}" method="POST"
                        class="grid grid-cols-1 md:grid-cols-4 gap-2 mb-4">
                        @csrf

                        <input name="title" placeholder="Milestone title..."
                            class="md:col-span-2 px-3.5 py-2 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">

                        <input type="date" name="due_date"
                            class="px-3.5 py-2 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">

                        <button
                            class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                            <i class="fas fa-plus mr-2"></i> Add
                        </button>
                    </form>

                    @forelse($goal->milestones as $milestone)
                        <div
                            class="flex items-center justify-between py-3 border-b dark:border-white/[0.06] border-black/[0.05]">
                            <form action="{{ route('user.goal.milestones.toggle', $milestone) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button
                                    class="text-[14px] font-medium {{ $milestone->is_completed ? 'line-through text-gray-400' : 'dark:text-gray-200 text-gray-700' }}">
                                    <i
                                        class="fas {{ $milestone->is_completed ? 'fa-circle-check text-emerald-500' : 'fa-clock text-orange-400' }} mr-2"></i>
                                    {{ $milestone->title }}
                                </button>

                                @if ($milestone->due_date)
                                    <p class="text-[12px] text-gray-500 mt-1">
                                        <i class="fas fa-calendar-alt mr-1"></i> Due:
                                        {{ $milestone->due_date->format('d M, Y') }}
                                    </p>
                                @endif
                            </form>

                            <form action="{{ route('user.goal.milestones.destroy', $milestone) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-[14px] font-bold text-red-500"><i class="fas fa-trash-alt mr-1"></i>
                                    Delete</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-6">No milestones added yet.</p>
                    @endforelse
                </div>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-bold dark:text-white text-gray-900 mb-4">
                    <i class="fas fa-trophy mr-2"></i> Achievement Tracking
                </h3>

                <div class="space-y-4">
                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[13px] dark:text-gray-500 text-gray-400"><i class="fas fa-star mr-2"></i> XP Earned
                        </p>
                        <h4 class="text-[28px] font-black text-yellow-400 mt-1">
                            {{ $goal->xp_earned }}
                        </h4>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[13px] dark:text-gray-500 text-gray-400"><i class="fas fa-flag mr-2"></i> Completed
                            Milestones</p>
                        <h4 class="text-[28px] font-black text-emerald-400 mt-1">
                            {{ $goal->milestones->where('is_completed', true)->count() }}/{{ $goal->milestones->count() }}
                        </h4>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[13px] dark:text-gray-500 text-gray-400"><i class="fas fa-trophy mr-2"></i>
                            Achievement Status</p>
                        <h4
                            class="text-[16px] font-bold mt-1 {{ $goal->status === 'completed' ? 'text-emerald-400' : 'text-orange-400' }}">
                            {{ $goal->status === 'completed' ? 'Completed' : 'In Progress' }}
                        </h4>
                    </div>

                    @if ($goal->completed_at)
                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                            <p class="text-[13px] dark:text-gray-500 text-gray-400"><i class="fas fa-clock mr-2"></i>
                                Completed At</p>
                            <h4 class="text-[14px] font-bold dark:text-white text-gray-900 mt-1">
                                {{ $goal->completed_at->format('d M Y h:i A') }}
                            </h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
