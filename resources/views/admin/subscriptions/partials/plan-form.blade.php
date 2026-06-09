{{-- ════════════════════════════════════════════════
     FILE: resources/views/admin/subscriptions/partials/plan-form.blade.php
     Used in both Create and Edit modals.
     Pass $edit = true for edit mode.
════════════════════════════════════════════════ --}}

@php $pfx = isset($edit) ? 'edit_' : ''; @endphp

{{-- ── Row 1: Name + Slug ── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Plan Name <span class="text-red-400">*</span></label>
        <input type="text" name="name" id="{{ $pfx }}name" required placeholder="e.g. Pro"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 dark:focus:border-orange-400 transition">
    </div>
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Slug <span class="text-red-400">*</span></label>
        <input type="text" name="slug" id="{{ $pfx }}slug" required placeholder="e.g. pro"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 dark:focus:border-orange-400 transition">
    </div>
</div>

{{-- ── Description ── --}}
<div>
    <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Description</label>
    <textarea name="description" id="{{ $pfx }}description" rows="2" placeholder="Short plan description..."
        class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none resize-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 dark:focus:border-orange-400 transition"></textarea>
</div>

{{-- ── Pricing ── --}}
<div class="dark:bg-[#1a1625] bg-gray-50 rounded-xl p-4 border dark:border-white/[0.07] border-black/[0.06] space-y-3">
    <p class="text-[12px] font-bold dark:text-gray-400 text-gray-500 uppercase tracking-wide">Pricing</p>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Monthly Price ($) <span class="text-red-400">*</span></label>
            <input type="number" name="price_monthly" id="{{ $pfx }}price_monthly" value="0" min="0" step="0.01" required
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#100e1a] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition">
        </div>
        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Yearly Price ($) <span class="text-red-400">*</span></label>
            <input type="number" name="price_yearly" id="{{ $pfx }}price_yearly" value="0" min="0" step="0.01" required
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#100e1a] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition">
        </div>
        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Currency</label>
            <select name="currency" id="{{ $pfx }}currency"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#100e1a] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition">
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <option value="GBP">GBP</option>
                <option value="BDT">BDT</option>
            </select>
        </div>
    </div>
</div>

{{-- ── Visual & Badge ── --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Icon (emoji)</label>
        <input type="text" name="icon" id="{{ $pfx }}icon" placeholder="💎"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[18px] outline-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition text-center">
    </div>
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Accent Color</label>
        <input type="color" name="color" id="{{ $pfx }}color" value="#f97316"
            class="w-full h-11 rounded-[10px] cursor-pointer outline-none dark:bg-[#1a1625] bg-gray-50 dark:border dark:border-white/[0.1] border border-black/[0.1]">
    </div>
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Badge Label</label>
        <input type="text" name="badge_label" id="{{ $pfx }}badge_label" placeholder="Most Popular"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[13px] outline-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition">
    </div>
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Badge Color</label>
        <input type="color" name="badge_color" id="{{ $pfx }}badge_color" value="#f97316"
            class="w-full h-11 rounded-[10px] cursor-pointer outline-none dark:bg-[#1a1625] bg-gray-50 dark:border dark:border-white/[0.1] border border-black/[0.1]">
    </div>
</div>

{{-- ── Feature Limits ── --}}
<div class="dark:bg-[#1a1625] bg-gray-50 rounded-xl p-4 border dark:border-white/[0.07] border-black/[0.06] space-y-3">
    <p class="text-[12px] font-bold dark:text-gray-400 text-gray-500 uppercase tracking-wide">Feature Limits <span class="dark:text-gray-600 text-gray-400 normal-case font-normal ml-1">(-1 = Unlimited)</span></p>
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
        @php
            $limits = [
                'max_tasks'          => 'Max Tasks',
                'max_habits'         => 'Max Habits',
                'max_notes'          => 'Max Notes',
                'max_goals'          => 'Max Goals',
                'max_focus_sessions' => 'Focus Sessions',
                'max_journals'       => 'Max Journals',
            ];
        @endphp
        @foreach($limits as $field => $label)
            <div>
                <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">{{ $label }}</label>
                <input type="number" name="{{ $field }}" id="{{ $pfx }}{{ $field }}" value="-1" min="-1"
                    class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#100e1a] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition">
            </div>
        @endforeach
    </div>
</div>

{{-- ── Feature Flags ── --}}
<div class="dark:bg-[#1a1625] bg-gray-50 rounded-xl p-4 border dark:border-white/[0.07] border-black/[0.06]">
    <p class="text-[12px] font-bold dark:text-gray-400 text-gray-500 uppercase tracking-wide mb-3">Feature Access</p>
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
        @php
            $flags = [
                'has_analytics'        => ['label' => 'Analytics',       'icon' => 'fa-chart-bar'],
                'has_calendar'         => ['label' => 'Calendar',        'icon' => 'fa-calendar'],
                'has_gamification'     => ['label' => 'Gamification',    'icon' => 'fa-trophy'],
                'has_themes'           => ['label' => 'Themes',          'icon' => 'fa-palette'],
                'has_ai_tools'         => ['label' => 'AI Tools',        'icon' => 'fa-robot'],
                'has_team_workspace'   => ['label' => 'Team Workspace',  'icon' => 'fa-users'],
                'has_priority_support' => ['label' => 'Priority Support','icon' => 'fa-headset'],
            ];
        @endphp
        @foreach($flags as $field => $meta)
            <label class="flex items-center gap-2 cursor-pointer group">
                <input type="checkbox" name="{{ $field }}" id="{{ $pfx }}{{ $field }}" value="1"
                    class="w-4 h-4 accent-orange-500 rounded cursor-pointer">
                <span class="text-[13px] font-bold dark:text-gray-300 text-gray-700 group-hover:dark:text-white group-hover:text-gray-900 transition flex items-center gap-1.5">
                    <i class="fa-solid {{ $meta['icon'] }} text-[11px] dark:text-gray-500 text-gray-400"></i>
                    {{ $meta['label'] }}
                </span>
            </label>
        @endforeach
    </div>
</div>

{{-- ── Custom Features List ── --}}
<div>
    <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
        Custom Features List
        <span class="dark:text-gray-600 text-gray-400 font-normal ml-1">(one per line, shown on pricing page)</span>
    </label>
    <textarea name="features" id="{{ $pfx }}features" rows="4" placeholder="Unlimited storage&#10;Advanced exports&#10;Custom branding"
        class="w-full px-3.5 py-2.5 rounded-[10px] text-[13px] outline-none resize-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 dark:focus:border-orange-400 transition font-mono"></textarea>
</div>

{{-- ── Sort & Status ── --}}
<div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Sort Order</label>
        <input type="number" name="sort_order" id="{{ $pfx }}sort_order" value="0" min="0"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition">
    </div>
    <div class="flex flex-col justify-end gap-2 pb-0.5">
        <label class="flex items-center gap-2.5 cursor-pointer">
            <input type="checkbox" name="is_active" id="{{ $pfx }}is_active" value="1" checked class="w-4 h-4 accent-orange-500 rounded">
            <span class="text-[13px] font-bold dark:text-gray-300 text-gray-700">Active</span>
        </label>
        <label class="flex items-center gap-2.5 cursor-pointer">
            <input type="checkbox" name="is_featured" id="{{ $pfx }}is_featured" value="1" class="w-4 h-4 accent-orange-500 rounded">
            <span class="text-[13px] font-bold dark:text-gray-300 text-gray-700">Featured / Highlighted</span>
        </label>
    </div>
</div>

{{-- ── Submit ── --}}
<div class="flex justify-end pt-2 border-t dark:border-white/[0.06] border-black/[0.05]">
    <button type="submit"
        class="px-6 py-2.5 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 btn-trans">
        {{ isset($edit) ? 'Update Plan' : 'Create Plan' }}
    </button>
</div>
