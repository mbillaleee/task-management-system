@extends('admin.layouts.master')

@section('admin')
    <div class="space-y-5">



        <!-- FEATURE CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $features = [
                    [
                        'title' => 'All-in-One',
                        'desc' => 'Everything you need in one powerful workspace.',
                        'color' => 'orange',
                        'svg_path' => '<path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>',
                        'stroke' => '#f97316',
                    ],
                    [
                        'title' => 'Focus First',
                        'desc' => 'Built to eliminate distractions and help you go deep.',
                        'color' => 'amber',
                        'svg_path' =>
                            '<circle cx="12" cy="12" r="3"/><circle cx="12" cy="12" r="7" stroke-dasharray="2 1"/><circle cx="12" cy="12" r="11"/>',
                        'stroke' => '#f97316',
                    ],
                    [
                        'title' => 'Data Driven',
                        'desc' => 'Analytics that help you improve every day.',
                        'color' => 'pink',
                        'svg_path' =>
                            '<rect x="3" y="14" width="4" height="7" rx="1"/><rect x="9.5" y="9" width="4" height="12" rx="1"/><rect x="16" y="4" width="4" height="17" rx="1"/><polyline points="3 7 9 4 15 7 21 3" stroke-width="1.6"/>',
                        'stroke' => '#ec4899',
                    ],
                    [
                        'title' => 'Privacy First',
                        'desc' => 'Your data is yours. Always.',
                        'color' => 'pink',
                        'svg_path' =>
                            '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/><circle cx="12" cy="16" r="1.2" fill="currentColor"/>',
                        'stroke' => '#ec4899',
                    ],
                ];
            @endphp

            @foreach ($features as $feature)
                <div
                    class="group hover-lift relative overflow-hidden rounded-2xl p-5 min-h-[118px]
    dark:bg-[#100b18]/90 bg-white
    border dark:border-orange-500/[0.14] border-orange-200/70
    shadow-[0_0_25px_rgba(249,115,22,0.08)]
    hover:shadow-[0_0_35px_rgba(236,72,153,0.18)]
    transition-all duration-300">

                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center flex-shrink-0">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                stroke="{{ $feature['stroke'] }}" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" class="drop-shadow-[0_0_7px_{{ $feature['stroke'] }}]">
                                {!! $feature['svg_path'] !!}
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[15px] font-bold dark:text-white text-gray-900 mb-1">
                                {{ $feature['title'] }}
                            </h4>
                            <p class="text-[12px] leading-[1.7] dark:text-gray-400 text-gray-500">
                                {{ $feature['desc'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
