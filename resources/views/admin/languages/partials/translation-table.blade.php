<table class="table w-full border-collapse">
    <thead>
        <tr class="bg-gray-100 dark:bg-[#1a1625] sticky top-0">
            <th class="p-3 text-left text-[12px] font-bold dark:text-gray-300 text-gray-700">#SL</th>
            <th class="p-3 text-left text-[12px] font-bold dark:text-gray-300 text-gray-700">Key</th>
            <th class="p-3 text-left text-[12px] font-bold dark:text-gray-300 text-gray-700">Value</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lang_keys as $key => $translation)
            <tr class="hover:bg-gray-50 dark:hover:bg-[#100b18] transition-colors duration-200">
                <td class="p-2 text-[13px] dark:text-white text-gray-800">
                    {{ $key + 1 + ($lang_keys->currentPage() - 1) * $lang_keys->perPage() }}
                </td>
                <td class="p-2 text-[13px] dark:text-white text-gray-800 font-medium">
                    {{ ucwords(str_replace('_', ' ', $translation->lang_key)) }}
                </td>
                <td class="p-2">
                    <input type="text" name="values[{{ $translation->lang_key }}]"
                        class="w-full px-3 py-2 rounded-[10px] text-[14px]
                        outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
                        border border-gray-200 dark:border-white/[0.1] shadow-sm"
                        value="{{ optional(
                            App\Models\LanguageTranslation::where('lang', $language->language_code)->where('lang_key', $translation->lang_key)->latest()->first(),
                        )->lang_value }}">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
