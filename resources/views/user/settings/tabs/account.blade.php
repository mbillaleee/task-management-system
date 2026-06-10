@php
    $user = auth()->user();
    $inputCls = "w-full px-3.5 py-2.5 rounded-[10px] text-[13.5px] outline-none transition
        dark:bg-[#1a1625] bg-gray-50
        dark:text-white text-gray-800
        dark:border dark:border-white/[0.1] border border-black/[0.09]
        focus:border-orange-400 dark:focus:border-orange-400";
    $labelCls = "block text-[12px] font-bold dark:text-gray-300 text-gray-600 mb-1.5";
@endphp

{{-- ── SECTION: Basic Info ── --}}
<div>
    <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-4 flex items-center gap-2">
        <i class="fa-solid fa-id-card text-orange-400 text-[13px]"></i> Basic Information
    </h4>

    <form action="{{ route('user.settings.account') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PATCH')

        {{-- Avatar upload --}}
        <div class="flex items-center gap-4 p-4 dark:bg-[#1a1625] bg-gray-50 rounded-xl border dark:border-white/[0.07] border-black/[0.06]">
            <div class="w-16 h-16 rounded-xl overflow-hidden flex items-center justify-center flex-shrink-0"
                style="background: linear-gradient(135deg,#f97316,#ec4899);">
                @if($user->profile)
                    <img src="{{ asset('storage/profile/' . $user->profile) }}"
                        id="avatarPreview" class="w-full h-full object-cover">
                @else
                    <span class="text-[22px] font-extrabold text-white" id="avatarInitial">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </span>
                    <img id="avatarPreview" class="hidden w-full h-full object-cover">
                @endif
            </div>
            <div>
                <label for="profileInput" class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-2 rounded-[8px] text-[12px] font-bold
                    dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700
                    border dark:border-white/[0.08] border-black/[0.08] hover:border-orange-400 transition">
                    <i class="fa-solid fa-upload text-[11px]"></i> Upload Photo
                </label>
                <input type="file" id="profileInput" name="profile" accept="image/*" class="hidden"
                    onchange="previewAvatar(this)">
                <p class="text-[11px] dark:text-gray-600 text-gray-400 mt-1">JPG, PNG, WebP — max 2MB</p>
            </div>
        </div>

        {{-- Name + Username --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $labelCls }}">Full Name <span class="text-red-400">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    placeholder="Your full name" class="{{ $inputCls }}">
            </div>
            <div>
                <label class="{{ $labelCls }}">Username</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[13px] dark:text-gray-500 text-gray-400">@</span>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
                        placeholder="yourname" class="{{ $inputCls }} pl-7">
                </div>
            </div>
        </div>

        {{-- Email --}}
        <div>
            <label class="{{ $labelCls }}">Email Address <span class="text-red-400">*</span></label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                placeholder="your@email.com" class="{{ $inputCls }}">
        </div>

        {{-- Bio --}}
        <div>
            <label class="{{ $labelCls }}">Bio <span class="dark:text-gray-600 text-gray-400 font-normal">— max 300 characters</span></label>
            <textarea name="bio" rows="2" placeholder="A short description about yourself..."
                class="{{ $inputCls }} resize-none" maxlength="300">{{ old('bio', $user->bio) }}</textarea>
        </div>

        {{-- Phone + Gender --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $labelCls }}">Phone</label>
                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                    placeholder="+1 234 567 8900" class="{{ $inputCls }}">
            </div>
            <div>
                <label class="{{ $labelCls }}">Gender</label>
                <select name="gender" class="{{ $inputCls }}">
                    <option value="">Prefer not to say</option>
                    <option value="male"        {{ old('gender', $user->gender) === 'male'        ? 'selected' : '' }}>Male</option>
                    <option value="female"      {{ old('gender', $user->gender) === 'female'      ? 'selected' : '' }}>Female</option>
                    <option value="non-binary"  {{ old('gender', $user->gender) === 'non-binary'  ? 'selected' : '' }}>Non-binary</option>
                    <option value="prefer_not"  {{ old('gender', $user->gender) === 'prefer_not'  ? 'selected' : '' }}>Prefer not to say</option>
                </select>
            </div>
        </div>

        {{-- DOB + Timezone --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $labelCls }}">Date of Birth</label>
                <input type="date" name="date_of_birth"
                    value="{{ old('date_of_birth', $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '') }}"
                    class="{{ $inputCls }}">
            </div>
            <div>
                <label class="{{ $labelCls }}">Timezone</label>
                <select name="timezone" class="{{ $inputCls }}">
                    <option value="">Select timezone...</option>
                    @foreach(\DateTimeZone::listIdentifiers() as $tz)
                        <option value="{{ $tz }}" {{ old('timezone', $user->timezone) === $tz ? 'selected' : '' }}>
                            {{ $tz }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Country + City --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $labelCls }}">Country</label>
                <input type="text" name="country" value="{{ old('country', $user->country) }}"
                    placeholder="e.g. Bangladesh" class="{{ $inputCls }}">
            </div>
            <div>
                <label class="{{ $labelCls }}">City</label>
                <input type="text" name="city" value="{{ old('city', $user->city) }}"
                    placeholder="e.g. Dhaka" class="{{ $inputCls }}">
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit"
                class="px-5 py-2.5 rounded-[10px] text-white text-[13px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 btn-trans">
                <i class="fa-solid fa-floppy-disk mr-1.5 text-[12px]"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<div class="border-t dark:border-white/[0.06] border-black/[0.05]"></div>

{{-- ── SECTION: Change Password ── --}}
<div>
    <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-4 flex items-center gap-2">
        <i class="fa-solid fa-lock text-orange-400 text-[13px]"></i> Change Password
    </h4>

    <form action="{{ route('user.settings.password') }}" method="POST" class="space-y-4">
        @csrf @method('PATCH')

        <div>
            <label class="{{ $labelCls }}">Current Password</label>
            <div class="relative">
                <input type="password" name="current_password" id="curPwd" placeholder="••••••••" class="{{ $inputCls }} pr-10">
                <button type="button" onclick="togglePwd('curPwd','eyeCur')"
                    class="absolute right-3 top-1/2 -translate-y-1/2 dark:text-gray-500 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i id="eyeCur" class="fa-solid fa-eye text-[13px]"></i>
                </button>
            </div>
            @error('current_password') <p class="text-red-400 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $labelCls }}">New Password</label>
                <div class="relative">
                    <input type="password" name="password" id="newPwd" placeholder="••••••••" class="{{ $inputCls }} pr-10">
                    <button type="button" onclick="togglePwd('newPwd','eyeNew')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 dark:text-gray-500 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i id="eyeNew" class="fa-solid fa-eye text-[13px]"></i>
                    </button>
                </div>
                @error('password') <p class="text-red-400 text-[11px] mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $labelCls }}">Confirm New Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="conPwd" placeholder="••••••••" class="{{ $inputCls }} pr-10">
                    <button type="button" onclick="togglePwd('conPwd','eyeCon')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 dark:text-gray-500 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i id="eyeCon" class="fa-solid fa-eye text-[13px]"></i>
                    </button>
                </div>
            </div>
        </div>

        <p class="text-[11.5px] dark:text-gray-600 text-gray-400">
            Min 8 characters, with uppercase, lowercase and numbers.
        </p>

        <div class="flex justify-end">
            <button type="submit"
                class="px-5 py-2.5 rounded-[10px] text-white text-[13px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 btn-trans">
                <i class="fa-solid fa-key mr-1.5 text-[12px]"></i> Change Password
            </button>
        </div>
    </form>
</div>

<div class="border-t dark:border-white/[0.06] border-black/[0.05]"></div>

{{-- ── SECTION: Subscription Info ── --}}
@if(isset($subscription) && $subscription)
<div>
    <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-4 flex items-center gap-2">
        <i class="fa-solid fa-credit-card text-orange-400 text-[13px]"></i> Current Subscription
    </h4>

    <div class="dark:bg-[#1a1625] bg-gray-50 rounded-xl p-4 border dark:border-white/[0.07] border-black/[0.06] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl flex-shrink-0"
                style="background: {{ $subscription->plan->color ?? '#f97316' }}22;">
                {{ $subscription->plan->icon ?? '💎' }}
            </div>
            <div>
                <p class="text-[14px] font-extrabold dark:text-white text-gray-900">{{ $subscription->plan->name }} Plan</p>
                <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-0.5">
                    {{ ucfirst($subscription->billing_cycle) }} ·
                    @if($subscription->ends_at)
                        Renews {{ $subscription->ends_at->format('M d, Y') }}
                    @else
                        No expiry set
                    @endif
                    · <span class="{{ $subscription->status === 'active' ? 'text-emerald-400' : 'text-blue-400' }} font-bold">{{ ucfirst($subscription->status) }}</span>
                </p>
            </div>
        </div>
        <a href="{{ route('user.pricing') }}"
            class="px-4 py-2 rounded-[10px] text-[12px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
            Manage Plan
        </a>
    </div>
</div>

<div class="border-t dark:border-white/[0.06] border-black/[0.05]"></div>
@endif

{{-- ── SECTION: Danger Zone ── --}}
<div>
    <h4 class="text-[14px] font-extrabold text-red-500 mb-4 flex items-center gap-2">
        <i class="fa-solid fa-triangle-exclamation text-[13px]"></i> Danger Zone
    </h4>

    <div class="p-4 rounded-xl border border-red-500/20 dark:bg-red-500/[0.04] bg-red-50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div>
            <p class="text-[13px] font-bold dark:text-white text-gray-900">Delete Account</p>
            <p class="text-[12px] dark:text-gray-500 text-gray-500 mt-0.5">
                All your data will be permanently deleted. This cannot be undone.
            </p>
        </div>
        <button onclick="document.getElementById('deleteModal').classList.remove('hidden')"
            class="flex-shrink-0 px-4 py-2 rounded-[10px] text-[12px] font-bold text-red-500 dark:bg-red-500/[0.12] bg-red-100 border border-red-500/20">
            Delete Account
        </button>
    </div>
</div>

{{-- Delete Confirm Modal --}}
<div id="deleteModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center px-4">
    <div class="w-full max-w-md dark:bg-[#17141f] bg-white border dark:border-white/[0.08] border-black/[0.08] rounded-2xl p-6">
        <div class="text-center mb-5">
            <div class="w-14 h-14 rounded-2xl bg-red-500/10 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-triangle-exclamation text-red-500 text-[22px]"></i>
            </div>
            <h3 class="text-[17px] font-extrabold dark:text-white text-gray-900">Delete your account?</h3>
            <p class="text-[13px] dark:text-gray-400 text-gray-500 mt-1">
                This will permanently delete all your tasks, habits, notes, goals, and data.
            </p>
        </div>
        <form action="{{ route('user.settings.destroy') }}" method="POST" class="space-y-4">
            @csrf @method('DELETE')
            <div>
                <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
                    Enter your password to confirm
                </label>
                <input type="password" name="password" placeholder="••••••••" required
                    class="w-full px-3.5 py-2.5 rounded-[10px] text-[13.5px] outline-none
                    dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800
                    dark:border dark:border-white/[0.1] border border-black/[0.09]
                    focus:border-red-400 transition">
                @error('password', 'userDeletion') <p class="text-red-400 text-[11px] mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="flex-1 py-2.5 rounded-[10px] text-[13px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 py-2.5 rounded-[10px] text-[13px] font-bold text-white bg-red-500">
                    Yes, Delete
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                const preview = document.getElementById('avatarPreview');
                const initial = document.getElementById('avatarInitial');
                if (preview) { preview.src = e.target.result; preview.classList.remove('hidden'); }
                if (initial) initial.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function togglePwd(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (!input || !icon) return;
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
