@extends('admin.layouts.master')

@section('admin')
    <section class="space-y-6">

        <div class="flex justify-between items-end">
            <h2 class="text-[20px] font-extrabold dark:text-white text-gray-900">Languages</h2>
            <a href="{{ route('admin.language.create') }}"
                class="px-4 py-2 rounded-[10px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 text-white shadow">
                + Add Language
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($languages as $language)
                <div
                    class="relative hover:scale-105 transform transition-all duration-300 hover-lift dark:bg-[#1b1624] bg-white rounded-3xl p-6 border dark:border-purple-700 border-gray-200 shadow-lg shadow-pink-400/20 overflow-hidden">

                    <!-- Background glow effect -->
                    <div
                        class="absolute -top-8 -right-8 w-32 h-32 rounded-full bg-gradient-to-r from-pink-500 via-orange-400 to-yellow-400 opacity-30 blur-3xl">
                    </div>
                    <div
                        class="absolute -bottom-8 -left-8 w-32 h-32 rounded-full bg-gradient-to-r from-purple-500 to-pink-400 opacity-20 blur-3xl">
                    </div>

                    <div class="relative z-10 flex justify-between items-center">
                        <div>
                            <h3 class="font-extrabold text-lg sm:text-xl dark:text-white text-gray-900">
                                {{ $language->title }}</h3>
                            <p
                                class="text-sm font-semibold px-2 py-1 rounded-full inline-block bg-gradient-to-r from-orange-400 to-pink-500 text-white mt-1">
                                {{ strtoupper($language->language_code) }}
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('admin.language.edit', $language) }}"
                                class="px-3 py-1.5 rounded-full bg-gradient-to-r from-yellow-400 to-pink-500 text-white font-semibold shadow-md hover:shadow-xl transition">
                                Edit
                            </a>
                            <a href="{{ route('admin.language.translations', $language) }}"
                                class="px-3 py-1.5 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold shadow-md hover:shadow-xl transition">
                                Translations
                            </a>
                        </div>
                    </div>

                    <div class="mt-4 relative z-10">
                        <label class="flex items-center gap-2 font-medium dark:text-gray-300 text-gray-700">
                            <input type="checkbox" data-url="{{ route('admin.language.status') }}"
                                value="{{ $language->id }}" name="toggle" {{ $language->active ? 'checked' : '' }}
                                class="accent-pink-500 w-5 h-5">
                            Active
                        </label>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full hover-lift dark:bg-[#1b1624] bg-white border dark:border-white/[0.07] border-gray-200 rounded-3xl p-8 text-center shadow-lg shadow-pink-400/20">
                    <h3 class="text-[16px] font-bold dark:text-white text-gray-900">No languages found</h3>
                    <p class="text-[12px] dark:text-gray-400 text-gray-500 mt-2">Add a new language to get started.</p>
                </div>
            @endforelse
        </div>

        <div>
            {{ $languages->links() }}
        </div>

    </section>

    @push('js')
        <script>
            document.querySelectorAll('input[name=toggle]').forEach(el => {
                el.addEventListener('change', function() {
                    const id = this.value;
                    const mode = this.checked;
                    fetch(this.dataset.url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id,
                            mode
                        })
                    }).then(res => res.json()).then(data => {
                        alert(data.msg);
                    });
                });
            });
        </script>
    @endpush
@endsection
