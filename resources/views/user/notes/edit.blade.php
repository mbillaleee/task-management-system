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
                <p class="text-[14px] font-semibold text-orange-400 mb-2">Edit Note</p>
                <h1 class="text-[34px] font-extrabold dark:text-white text-gray-900">
                    {{ $note->title }}
                </h1>
                <p class="text-[15px] dark:text-gray-400 text-gray-600 mt-2">
                    Update your note. Changes will autosave while typing.
                </p>
            </div>

            <a href="{{ route('user.notes.show', $note) }}"
                class="px-5 py-3 rounded-xl text-[14px] font-bold
                dark:text-white text-gray-800 border dark:border-white/[0.14] border-orange-200
                dark:bg-white/[0.03] bg-white/70">
                View Note
            </a>
        </div>
    </section>

    <form action="{{ route('user.notes.update', $note) }}" method="POST" id="noteForm">
        @csrf
        @method('PUT')

        @include('user.notes.partials.form', [
            'note' => $note,
            'buttonText' => 'Update Note'
        ])
    </form>

    <div
        class="rounded-xl px-4 py-3 text-[13px] font-semibold
        dark:bg-[#17141f] bg-white border dark:border-white/[0.08] border-orange-100
        dark:text-gray-400 text-gray-500">
        Autosave status:
        <span id="autosaveStatus" class="text-orange-400">Waiting...</span>
    </div>
</div>

<script>
    let timer = null;

    const titleInput = document.querySelector('input[name="title"]');
    const contentInput = document.querySelector('textarea[name="content"]');
    const statusText = document.getElementById('autosaveStatus');

    function autosaveNote() {
        clearTimeout(timer);

        timer = setTimeout(() => {
            if (!titleInput.value.trim()) {
                statusText.innerText = "Title required";
                return;
            }

            statusText.innerText = "Saving...";

            fetch("{{ route('user.notes.autosave', $note) }}", {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    title: titleInput.value,
                    content: contentInput.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusText.innerText = "Saved at " + data.saved_at;
                } else {
                    statusText.innerText = "Autosave failed";
                }
            })
            .catch(() => {
                statusText.innerText = "Autosave failed";
            });
        }, 1200);
    }

    titleInput.addEventListener('input', autosaveNote);
    contentInput.addEventListener('input', autosaveNote);
</script>
@endsection