@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-bullseye mr-2"></i> Goals Workspace
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    Track long-term goals, milestones, deadlines and achievements.
                </p>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('user.goal.categories.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                    <i class="fas fa-list mr-2"></i> Category
                </a>

                <a href="{{ route('user.goals.create') }}"
                    class="flex items-center justify-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                    <i class="fas fa-plus mr-2"></i> Create Goal
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-5">
                <p class="text-[14px] dark:text-white text-gray-800 font-bold"><i class="fas fa-flag mr-2"></i>Total
                    Goals</p>
                <h3 class="text-[34px] font-black dark:text-white text-gray-900 mt-2">{{ $totalGoals }}</h3>
                <p class="text-[13px] text-orange-400 font-bold"><i class="fas fa-info-circle mr-2"></i> All saved goals</p>
            </div>

            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-5">
                <p class="text-[14px] dark:text-white text-gray-800 font-bold"><i class="fas fa-play-circle mr-2"></i>
                    Active Goals</p>
                <h3 class="text-[34px] font-black text-pink-400 mt-2">{{ $activeGoals }}</h3>
                <p class="text-[13px] text-pink-400 font-bold"><i class="fas fa-info-circle mr-2"></i> In progress goals</p>
            </div>

            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-5">
                <p class="text-[14px] dark:text-white text-gray-800 font-bold"><i
                        class="fas fa-check-circle mr-2"></i>Completed</p>
                <h3 class="text-[34px] font-black text-emerald-400 mt-2">{{ $completedGoals }}</h3>
                <p class="text-[13px] text-emerald-400 font-bold"><i class="fas fa-info-circle mr-2"></i> Achievements
                    unlocked</p>
            </div>

            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-5">
                <p class="text-[14px] dark:text-white text-gray-800 font-bold"><i class="fas fa-coins mr-2"></i>XP Earned
                </p>
                <h3 class="text-[34px] font-black text-yellow-600 mt-2">{{ $totalXp }}</h3>
                <p class="text-[13px] text-yellow-600 font-bold"><i class="fas fa-info-circle mr-2"></i> From goal
                    completion</p>
            </div>
        </div>

        <div
            class="hover-lift dark:border-pink-500/15 bg-[#f7e4c3]/75
            dark:bg-[#080612]  backdrop-blur-xl  p-6  space-y-6
            shadow-[0_20px_60px_rgba(0,0,0,0.25)]
            dark:shadow-[inset_0_1px_0_rgba(255,255,255,.03)] rounded-2xl p-[18px]">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 mb-5">
                <div>
                    <h3 class="text-[20px] font-extrabold dark:text-white text-gray-900"><i
                            class="fas fa-bullseye mr-2"></i>All Goals</h3>
                    <p class="text-[13px] dark:text-white text-gray-800 mt-1">
                        Search, filter and manage your goals.
                    </p>
                </div>

                <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search goals..."
                        class="px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">

                    <select name="status"
                        class="px-3.5 py-2.5 rounded-[10px] text-[14px] dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.1]">
                        <option value="">All Status</option>
                        <option value="not_started" @selected(request('status') == 'not_started')>Not Started</option>
                        <option value="in_progress" @selected(request('status') == 'in_progress')>In Progress</option>
                        <option value="completed" @selected(request('status') == 'completed')>Completed</option>
                        <option value="cancelled" @selected(request('status') == 'cancelled')>Cancelled</option>
                    </select>

                    <select name="type"
                        class="px-3.5 py-2.5 rounded-[10px] text-[14px] dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.1]">
                        <option value="">All Types</option>
                        <option value="short_term" @selected(request('type') == 'short_term')>Short Term</option>
                        <option value="long_term" @selected(request('type') == 'long_term')>Long Term</option>
                    </select>

                    <select name="goal_category_id"
                        class="px-3.5 py-2.5 rounded-[10px] text-[14px] dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.1]">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('goal_category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <button
                        class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                @forelse($goals as $goal)
                    @php
                        $priorityClass =
                            [
                                'high' => 'dark:bg-red-500/[0.15] bg-red-50 text-red-500 border-red-500/20',
                                'medium' =>
                                    'dark:bg-orange-500/[0.15] bg-orange-50 text-orange-500 border-orange-500/20',
                                'low' =>
                                    'dark:bg-emerald-500/[0.15] bg-emerald-50 text-emerald-500 border-emerald-500/20',
                            ][$goal->priority] ?? 'bg-gray-100 text-gray-500';

                        $statusClass =
                            [
                                'not_started' => 'dark:bg-gray-500/[0.15] bg-gray-50 text-gray-500',
                                'in_progress' => 'dark:bg-blue-500/[0.15] bg-blue-50 text-blue-500',
                                'completed' => 'dark:bg-emerald-500/[0.15] bg-emerald-50 text-emerald-500',
                                'cancelled' => 'dark:bg-red-500/[0.15] bg-red-50 text-red-500',
                            ][$goal->status] ?? 'bg-gray-100 text-gray-500';
                    @endphp

                    <div
                        class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-4 relative overflow-hidden">

                        <div class="relative z-10 flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-[16px] font-bold dark:text-white text-gray-900 leading-snug">
                                    {{ $goal->title }}
                                </h3>
                                <p class="text-[14px] dark:text-white text-gray-800 mt-1">
                                    {{ $goal->category?->name ?? 'Uncategorized' }}
                                </p>
                            </div>

                            <span class="px-2.5 py-[4px] rounded-lg text-[13px] font-bold border {{ $priorityClass }}">
                                <i class="fas fa-flag mr-1"></i> {{ ucfirst($goal->priority) }}
                            </span>
                        </div>

                        <p class="relative z-10 text-[14px] dark:text-white text-gray-800 leading-relaxed mt-3">
                            {{ \Illuminate\Support\Str::limit($goal->description, 100) ?? 'No description added.' }}
                        </p>

                        <div
                            class="relative z-10 flex items-center justify-between mt-4 pt-3 border-t dark:border-white/[0.06] border-black/[0.05]">
                            <div>
                                <p class="text-[13px] dark:text-white text-gray-800"><i
                                        class="fas fa-calendar-alt mr-2"></i> Deadline</p>
                                <p class="text-[14px] font-semibold dark:text-gray-300 text-gray-700">
                                    {{ $goal->deadline ? $goal->deadline->format('d M, Y') : 'No deadline' }}
                                </p>
                            </div>

                            <span class="px-2.5 py-[4px] rounded-lg text-[13px] font-bold {{ $statusClass }}">
                                <i class="fas fa-info-circle mr-1"></i> {{ ucwords(str_replace('_', ' ', $goal->status)) }}
                            </span>
                        </div>

                        <div class="relative z-10 mt-4">
                            <div class="flex justify-between text-[13px] mb-1.5">
                                <span class="dark:text-white text-gray-800"><i class="fas fa-chart-line mr-2"></i>
                                    Progress</span>
                                <span class="font-bold dark:text-white text-gray-800">{{ $goal->progress }}%</span>
                            </div>

                            <div class="w-full h-[7px] rounded-full dark:bg-white/[0.08] bg-gray-400 overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500"
                                    style="width: {{ $goal->progress }}%"></div>
                            </div>
                        </div>

                        <div class="relative z-10 flex items-center justify-between gap-2 mt-4">
                            <a href="{{ route('user.goals.show', $goal) }}"
                                class="px-3 py-2 rounded-lg text-[14px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500">
                                <i class="fas fa-eye mr-2"></i> View
                            </a>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('user.goals.edit', $goal) }}"
                                    class="px-3 py-2 rounded-lg text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                                    <i class="fas fa-edit mr-2"></i> Edit
                                </a>

                                <form action="{{ route('user.goals.destroy', $goal) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this goal?')"
                                        class="px-3 py-2 rounded-lg text-[14px] font-bold dark:bg-red-500/[0.15] bg-red-50 text-red-500">
                                        <i class="fas fa-trash-alt mr-2"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full dark:bg-white/[0.03] bg-gray-50 border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-10 text-center">
                        <h3 class="text-[18px] font-bold dark:text-white text-gray-900">No goals found</h3>
                        <p class="text-[13px] dark:text-white text-gray-800 mt-1">Create your first goal to start
                            tracking progress.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $goals->links() }}
            </div>
        </div>

        {{-- <div id="categoryModal" class="hidden fixed inset-0 z-50 bg-black/60 flex items-center justify-center px-4">
            <div class="w-full max-w-md dark:bg-[#17141f] bg-white border dark:border-white/[0.08] rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold dark:text-white text-gray-900">Create Goal Category</h3>
                    <button onclick="document.getElementById('categoryModal').classList.add('hidden')"
                        class="text-gray-400">✕</button>
                </div>

                <form action="{{ route('user.goal.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="text" name="name" placeholder="Category name"
                        class="w-full px-4 py-3 rounded-xl dark:bg-[#1a1625] bg-gray-50 dark:text-white border dark:border-white/[0.1]">

                    <select name="color"
                        class="w-full px-4 py-3 rounded-xl dark:bg-[#1a1625] bg-gray-50 dark:text-white border dark:border-white/[0.1]">
                        <option value="orange">Orange</option>
                        <option value="pink">Pink</option>
                        <option value="blue">Blue</option>
                        <option value="green">Green</option>
                        <option value="purple">Purple</option>
                    </select>

                    <button
                        class="w-full px-4 py-3 rounded-xl text-white font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                        Save Category
                    </button>
                </form>
            </div>
        </div> --}}

    </section>
@endsection
