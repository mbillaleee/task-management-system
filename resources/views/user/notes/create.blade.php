@extends('user.layouts.master')

@section('user')
<div class="space-y-5">

    <section
        class="relative overflow-hidden rounded-2xl border dark:border-orange-500/[0.18] border-orange-200/70
        dark:bg-[#100b18] bg-orange-50/70 px-6 py-6">

        <div class="absolute inset-0 opacity-40 pointer-events-none"
            style="background:
            radial-gradient(circle at 80% 40%, rgba(236,72,153,.30), transparent 35%),
            radial-gradient(circle at 25% 70%, rgba(249,115,22,.25), transparent 32%);">
        </div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <p class="text-[14px] font-semibold text-orange-400 mb-2">New Note</p>
                <h1 class="text-[34px] font-extrabold dark:text-white text-gray-900">
                    Create a new idea
                </h1>
                <p class="text-[15px] dark:text-gray-400 text-gray-600 mt-2">
                    Write, organize and save your thoughts instantly.
                </p>
            </div>

            <a href="{{ route('user.notes.index') }}"
                class="px-5 py-3 rounded-xl text-[14px] font-bold
                dark:text-white text-gray-800 border dark:border-white/[0.14] border-orange-200
                dark:bg-white/[0.03] bg-white/70">
                ← Back to Notes
            </a>
        </div>
    </section>

    <form action="{{ route('user.notes.store') }}" method="POST">
        @csrf

        @include('user.notes.partials.form', [
            'note' => null,
            'buttonText' => 'Create Note'
        ])
    </form>
</div>
@endsection