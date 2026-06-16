@extends('user.layouts.master')

@section('user')
    <div class="space-y-5">

        <section
            class="relative overflow-hidden rounded-2xl border  veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] px-6 py-6">
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="text-[14px] font-semibold text-orange-400 mb-2"><i class="fa-solid fa-plus"></i> New Note</p>
                    <h1 class="text-[34px] font-extrabold dark:text-white text-gray-900">
                        <i class="fa-solid fa-lightbulb"></i> Create a new idea
                    </h1>
                    <p class="text-[15px] dark:text-gray-400 text-gray-600 mt-2">
                        <i class="fa-solid fa-pencil"></i> Write, organize and save your thoughts instantly.
                    </p>
                </div>

                <a href="{{ route('user.notes.index') }}"
                    class="px-5 py-3 rounded-xl text-[14px] font-bold
                dark:text-white text-gray-800 border dark:border-white/[0.14] border-orange-200
                dark:bg-white/[0.03] bg-white/70">
                    <i class="fa-solid fa-arrow-left"></i> Back to Notes
                </a>
            </div>
        </section>

        <form action="{{ route('user.notes.store') }}" method="POST">
            @csrf

            @include('user.notes.partials.form', [
                'note' => null,
                'buttonText' => 'Create Note',
            ])
        </form>
    </div>
@endsection
