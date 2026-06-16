<div id="createModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
    onclick="if(event.target===this) closeCreateModal()">

    <div
        class="relative w-full max-w-3xl veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-3xl shadow-2xl overflow-hidden">
        <form id="eventForm" action="{{ route('user.calendar.store') }}" method="POST"
            class="relative p-6 space-y-5 overflow-y-auto max-h-[75vh] sm:max-h-[85vh]">
            @csrf
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h3 id="modalTitle" class="text-xl font-bold dark:text-white text-gray-900"><i
                            class="fas fa-plus mr-2"></i> Add Event</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Create or update calendar events.</p>
                </div>
                <button type="button" onclick="closeCreateModal()"
                    class="w-10 h-10 rounded-xl dark:bg-white/[0.06] bg-black/[0.05] 
               text-gray-500 dark:text-gray-300 hover:bg-gradient-to-br 
               hover:from-orange-500 hover:to-pink-500 dark:hover:from-orange-400 
               dark:hover:to-pink-400 hover:text-white transition-all duration-300 
               flex items-center justify-center shadow hover:shadow-lg transform hover:scale-110">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="eventFormError"
                class="hidden rounded-2xl border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                <p class="font-semibold">Please fix the following errors:</p>
                <ul class="mt-2 list-disc list-inside" id="eventFormErrorList"></ul>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">Title</span>
                    <input name="title" id="ev_title" type="text"
                        class="mt-2 w-full rounded-2xl border border-black/[0.1] dark:border-white/[0.12] bg-white dark:bg-[#120d1d] text-gray-900 dark:text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        required>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">Type</span>
                    <select name="type" id="ev_type"
                        class="mt-2 w-full rounded-2xl border border-black/[0.1] dark:border-white/[0.12] bg-white dark:bg-[#120d1d] text-gray-900 dark:text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        required>
                        <option value="event">Event</option>
                        <option value="reminder">Reminder</option>
                        <option value="block">Block</option>
                        <option value="meeting">Meeting</option>
                        <option value="personal">Personal</option>
                        <option value="task">Task</option>
                    </select>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">Start Date</span>
                    <input name="start_date" id="start_date" type="date"
                        class="mt-2 w-full rounded-2xl border border-black/[0.1] dark:border-white/[0.12] bg-white dark:bg-[#120d1d] text-gray-900 dark:text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        required>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">End Date</span>
                    <input name="end_date" id="end_date" type="date"
                        class="mt-2 w-full rounded-2xl border border-black/[0.1] dark:border-white/[0.12] bg-white dark:bg-[#120d1d] text-gray-900 dark:text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        required>
                </label>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div id="timeFields" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="block">
                        <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">Start Time</span>
                        <input name="start_time" id="start_time" type="time"
                            class="mt-2 w-full rounded-2xl border border-black/[0.1] dark:border-white/[0.12] bg-white dark:bg-[#120d1d] text-gray-900 dark:text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">End Time</span>
                        <input name="end_time" id="end_time" type="time"
                            class="mt-2 w-full rounded-2xl border border-black/[0.1] dark:border-white/[0.12] bg-white dark:bg-[#120d1d] text-gray-900 dark:text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">
                    </label>
                </div>
                <label class="block">
                    <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">Priority</span>
                    <select name="priority" id="ev_priority"
                        class="mt-2 w-full rounded-2xl border border-black/[0.1] dark:border-white/[0.12] bg-white dark:bg-[#120d1d] text-gray-900 dark:text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        required>
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </label>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">Location</span>
                    <input name="location" id="ev_location" type="text"
                        class="mt-2 w-full rounded-2xl border border-black/[0.1] dark:border-white/[0.12] bg-white dark:bg-[#120d1d] text-gray-900 dark:text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">
                </label>
                <label class="block">
                    <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">Color</span>
                    <select name="color" id="ev_color"
                        class="mt-2 w-full rounded-2xl border border-black/[0.1] dark:border-white/[0.12] bg-white dark:bg-[#120d1d] text-gray-900 dark:text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        required>
                        <option value="orange" selected>Orange</option>
                        <option value="blue">Blue</option>
                        <option value="green">Green</option>
                        <option value="pink">Pink</option>
                        <option value="purple">Purple</option>
                        <option value="red">Red</option>
                        <option value="yellow">Yellow</option>
                        <option value="teal">Teal</option>
                    </select>
                </label>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <label class="flex items-center gap-3">
                    <input name="all_day" id="ev_all_day" type="checkbox"
                        class="h-4 w-4 rounded border-black/[0.1] dark:border-white/[0.12] text-orange-500 focus:ring-orange-400">
                    <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">All day event</span>
                </label>
                <label class="flex items-center gap-3">
                    <input name="reminder_enabled" id="ev_reminder_enabled" type="checkbox"
                        class="h-4 w-4 rounded border-black/[0.1] dark:border-white/[0.12] text-orange-500 focus:ring-orange-400">
                    <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">Reminder enabled</span>
                </label>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <label class="block">
                    <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">Recurring type</span>
                    <select name="recurring_type" id="ev_recurring_type"
                        class="mt-2 w-full rounded-2xl border border-black/[0.1] dark:border-white/[0.12] bg-white dark:bg-[#120d1d] text-gray-900 dark:text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="">None</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">Recurring end</span>
                    <input name="recurring_end_date" id="ev_recurring_end_date" type="date"
                        class="mt-2 w-full rounded-2xl border border-black/[0.1] dark:border-white/[0.12] bg-white dark:bg-[#120d1d] text-gray-900 dark:text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">
                </label>
                <label class="block">
                    <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">Reminder minutes</span>
                    <input name="reminder_minutes" id="ev_reminder_minutes" type="number" min="0"
                        class="mt-2 w-full rounded-2xl border border-black/[0.1] dark:border-white/[0.12] bg-white dark:bg-[#120d1d] text-gray-900 dark:text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        placeholder="15">
                </label>
            </div>

            <label class="block">
                <span class="text-sm font-semibold dark:text-gray-300 text-gray-700">Description</span>
                <textarea name="description" id="ev_description" rows="4"
                    class="mt-2 w-full rounded-2xl border border-black/[0.1] dark:border-white/[0.12] bg-white dark:bg-[#120d1d] text-gray-900 dark:text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
            </label>

            <div
                class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-3 border-t border-black/[0.08] dark:border-white/[0.08]">
                <button type="button" onclick="closeCreateModal()"
                    class="inline-flex items-center justify-center rounded-2xl border border-black/[0.1] dark:border-white/[0.12] px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-black/[0.05] dark:hover:bg-white/[0.08] transition"><i
                        class="fas fa-times mr-2"></i>Cancel</button>
                <button type="submit" id="submitBtn"
                    class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-orange-500 to-pink-500 text-white px-5 py-3 text-sm font-semibold shadow-sm hover:shadow-md transition"><i
                        class="fas fa-plus mr-2"></i>Create
                    Event</button>
            </div>
        </form>
    </div>
</div>
