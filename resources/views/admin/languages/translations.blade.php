@extends('admin.layouts.master')

@section('admin')
    <section class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[22px] font-extrabold dark:text-white text-gray-900"> <i class="fas fa-language"></i>
                    {{ $language->title }} Translations</h2>
                <p class="text-[14px] dark:text-gray-400 text-gray-500 mt-0.5">
                    Edit translations for {{ $language->title }} language.
                </p>
            </div>

            <div class="flex items-center gap-2.5">
                <input type="search" name="q"
                    class="language-tranlation w-full sm:w-64 px-4 py-2 rounded-[12px] text-[14px] outline-none
                       dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
                       dark:border dark:border-white/[0.15] border border-black/[0.15] shadow-sm"
                    data-url="{{ route('admin.language.translation.search.ajax', ['id' => $language->id]) }}"
                    placeholder="Search translation key...">
            </div>
        </div>

        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] 
                rounded-3xl p-6 shadow-xl transition-all duration-300 relative overflow-hidden">

            <!-- Subtle background glow -->
            <div
                class="absolute top-0 -left-8 w-32 h-32 bg-gradient-to-tr from-pink-500 via-orange-400 to-yellow-400 opacity-20 blur-3xl">
            </div>
            <div
                class="absolute bottom-0 -right-8 w-32 h-32 bg-gradient-to-tl from-purple-500 to-pink-400 opacity-15 blur-3xl">
            </div>

            <form action="{{ route('admin.language.translation.value.store') }}" method="POST">
                @csrf
                <input type="hidden" name="lang" value="{{ $language->language_code }}">
                <div class="overflow-x-auto language-container rounded-lg">
                    @include('admin.languages.partials.translation-table', [
                        'language' => $language,
                        'lang_keys' => $lang_keys,
                    ])
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="px-6 py-3 rounded-[12px] text-white text-[14px] font-bold
                           bg-gradient-to-r from-orange-500 to-pink-500 shadow-lg hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-save"></i> Save Translations
                    </button>
                </div>

                <div class="mt-4">
                    {{ $lang_keys->links() }}
                </div>
            </form>
        </div>
    </section>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $(document).on('keyup', '.language-tranlation', function(e) {
                e.preventDefault();
                var that = $(this);
                var url = that.data('url');
                var q = that.val();
                $.ajax({
                    url: url,
                    method: "get",
                    data: {
                        q: q
                    },
                    success: function(res) {
                        if (res.success) {
                            $(".language-container").empty().append(res.page);
                        }
                    }
                });
            });

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function(res) {
                    if (res.success) {
                        $(".language-container").empty().append(res.page);
                    }
                });
            });
        });
    </script>
@endpush
