<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\NoteCategory;
use App\Models\NoteFolder;
use App\Models\NoteTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class NoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Note::with(['folder', 'category', 'tags'])
            ->where('user_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('folder')) {
            $query->where('note_folder_id', $request->folder);
        }

        if ($request->filled('category')) {
            $query->where('note_category_id', $request->category);
        }

        if ($request->filled('favorite')) {
            $query->where('is_favorite', true);
        }

        if ($request->filled('pinned')) {
            $query->where('is_pinned', true);
        }

        // Filter by tag slug
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('user_id', Auth::id())
                  ->where('slug', $request->tag);
            });
        }

        $notes = $query
            ->orderByDesc('is_pinned')
            ->orderByDesc('updated_at')
            ->paginate(12);

        $folders = NoteFolder::where('user_id', Auth::id())->get();
        $categories = NoteCategory::where('user_id', Auth::id())->get();

        // All tags for this user (for tag filter dropdown)
        $userTags = NoteTag::where('user_id', Auth::id())
            ->withCount('notes')
            ->having('notes_count', '>', 0)
            ->orderBy('name')
            ->get();

        $pinnedNotes = Note::where('user_id', Auth::id())
            ->where('is_pinned', 1)
            ->count();

        $favoriteNotes = Note::where('user_id', Auth::id())
            ->where('is_favorite', 1)
            ->count();

        return view('user.notes.index', compact('notes', 'folders', 'categories', 'userTags', 'pinnedNotes', 'favoriteNotes'));
    }

    public function create()
    {
        $folders = NoteFolder::where('user_id', Auth::id())->get();
        $categories = NoteCategory::where('user_id', Auth::id())->get();

        return view('user.notes.create', compact('folders', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateNote($request);

        $note = Note::create([
            'user_id' => Auth::id(),
            'note_folder_id' => $data['note_folder_id'] ?? null,
            'note_category_id' => $data['note_category_id'] ?? null,
            'title' => $data['title'],
            'content' => $data['content'] ?? null,
            'type' => $data['type'] ?? 'text',
            'status' => $data['status'] ?? 'draft',
            'is_pinned' => $request->boolean('is_pinned'),
            'is_favorite' => $request->boolean('is_favorite'),
            'last_edited_at' => now(),
        ]);

        $this->syncTags($note, $request->tags);

        return redirect()
            ->route('user.notes.show', $note)
            ->with('success', 'Note created successfully.');
    }

    public function show(Note $note)
    {
        $this->authorizeNote($note);

        $note->load(['folder', 'category', 'tags']);

        return view('user.notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        $this->authorizeNote($note);

        $folders = NoteFolder::where('user_id', Auth::id())->get();
        $categories = NoteCategory::where('user_id', Auth::id())->get();

        return view('user.notes.edit', compact('note', 'folders', 'categories'));
    }

    public function update(Request $request, Note $note)
    {
        $this->authorizeNote($note);

        $data = $this->validateNote($request);

        $note->update([
            'note_folder_id' => $data['note_folder_id'] ?? null,
            'note_category_id' => $data['note_category_id'] ?? null,
            'title' => $data['title'],
            'content' => $data['content'] ?? null,
            'type' => $data['type'] ?? 'text',
            'status' => $data['status'] ?? 'draft',
            'is_pinned' => $request->boolean('is_pinned'),
            'is_favorite' => $request->boolean('is_favorite'),
            'last_edited_at' => now(),
        ]);

        $this->syncTags($note, $request->tags);

        return redirect()
            ->route('user.notes.show', $note)
            ->with('success', 'Note updated successfully.');
    }

    public function destroy(Note $note)
    {
        $this->authorizeNote($note);

        $note->delete();

        return redirect()
            ->route('user.notes.index')
            ->with('success', 'Note deleted successfully.');
    }

    public function togglePin(Note $note)
    {
        $this->authorizeNote($note);

        $note->update([
            'is_pinned' => ! $note->is_pinned,
        ]);

        return back()->with('success', 'Pin status updated.');
    }

    public function toggleFavorite(Note $note)
    {
        $this->authorizeNote($note);

        $note->update([
            'is_favorite' => ! $note->is_favorite,
        ]);

        return back()->with('success', 'Favorite status updated.');
    }

    public function autosave(Request $request, Note $note)
    {
        $this->authorizeNote($note);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
            'last_edited_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Autosaved',
            'saved_at' => now()->format('h:i A'),
        ]);
    }

    private function validateNote(Request $request): array
    {
        return $request->validate([
            'note_folder_id' => 'nullable|exists:note_folders,id',
            'note_category_id' => 'nullable|exists:note_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'nullable|in:text,checklist',
            'status' => 'nullable|in:draft,published,archived',
            'tags' => 'nullable|string',
        ]);
    }

    private function syncTags(Note $note, ?string $tags): void
    {
        if (! $tags) {
            $note->tags()->sync([]);
            return;
        }

        $tagIds = collect(explode(',', $tags))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->unique()
            ->map(function ($tagName) {
                $slug = Str::slug($tagName);

                $tag = NoteTag::firstOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'slug' => $slug,
                    ],
                    [
                        'name' => $tagName,
                    ]
                );

                return $tag->id;
            })
            ->toArray();

        $note->tags()->sync($tagIds);
    }

    public function storeFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        NoteFolder::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', 'Folder created successfully.');
    }

    public function updateFolder(Request $request, NoteFolder $folder)
    {
        abort_if($folder->user_id !== Auth::id(), 403);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $folder->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', 'Folder updated successfully.');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        NoteCategory::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
        ]);

        return back()->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, NoteCategory $category)
    {
        abort_if($category->user_id !== Auth::id(), 403);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Category updated successfully.');
    }

    private function authorizeNote(Note $note): void
    {
        abort_if($note->user_id !== Auth::id(), 403);
    }

    // ─────────────────────────────────────────────────────────────
    // TAG MANAGEMENT — routes: notes.tags.store / notes.tags.destroy
    // ─────────────────────────────────────────────────────────────

    /**
     * Add a single tag to a note (AJAX-friendly)
     * Route: POST /user/notes/{note}/tags
     */
    public function storeTag(Request $request, Note $note)
    {
        $this->authorizeNote($note);

        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $tagName = trim($request->name);
        $slug    = \Illuminate\Support\Str::slug($tagName);

        if (! $slug) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Invalid tag name.'], 422);
            }
            return back()->with('error', 'Invalid tag name.');
        }

        $tag = NoteTag::firstOrCreate(
            ['user_id' => Auth::id(), 'slug' => $slug],
            ['name'    => $tagName]
        );

        // Attach only if not already attached
        if (! $note->tags()->where('note_tag_id', $tag->id)->exists()) {
            $note->tags()->attach($tag->id);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'tag'     => [
                    'id'   => $tag->id,
                    'name' => $tag->name,
                    'slug' => $tag->slug,
                ],
                'message' => 'Tag added.',
            ]);
        }

        return back()->with('success', 'Tag "' . $tagName . '" added.');
    }

    /**
     * Remove a tag from a note (detach only, does not delete the tag itself)
     * Route: DELETE /user/notes/{note}/tags/{tag}
     */
    public function destroyTag(Note $note, NoteTag $tag)
    {
        $this->authorizeNote($note);

        // Only allow detaching user's own tags
        abort_if($tag->user_id !== Auth::id(), 403);

        $note->tags()->detach($tag->id);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Tag removed.']);
        }

        return back()->with('success', 'Tag removed.');
    }
}
