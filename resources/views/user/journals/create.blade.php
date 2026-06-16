@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">
        <div class="flex items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-plus-circle mr-2"></i> Create Journal
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    Add daily journal, gratitude note or reflection entry.
                </p>
            </div>

            <a href="{{ route('user.journals.index') }}"
                class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
        </div>

        <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
            <form action="{{ route('user.journals.store') }}" method="POST">
                @csrf
                @include('user.journals.partials.form')
            </form>
        </div>
    </section>
@endsection
