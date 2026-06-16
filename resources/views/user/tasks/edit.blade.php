@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        <div class="flex items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-edit"></i> Edit Task
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    Update task information, priority, status and labels.
                </p>
            </div>

            <a href="{{ route('user.tasks.index') }}"
                class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-white text-gray-800 border dark:border-white/[0.08] border-black/[0.08]">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="hover-lift veroa-card rounded-2xl p-[18px]">
            <form action="{{ route('user.tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')
                @include('user.tasks.partials.form')
            </form>
        </div>

    </section>
@endsection
