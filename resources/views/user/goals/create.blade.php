@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">
        <div class="flex items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-plus mr-2"></i> Create Goal
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Add a new goal with milestones, deadline and progress tracking.
                </p>
            </div>

            <a href="{{ route('user.goals.index') }}"
                class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
            <form action="{{ route('user.goals.store') }}" method="POST">
                @csrf
                @include('user.goals.partials.form')
            </form>
        </div>
    </section>
@endsection
