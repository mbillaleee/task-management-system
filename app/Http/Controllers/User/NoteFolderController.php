<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\NoteFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NoteFolderController extends Controller
{
    public function index(Request $request)
    {
        $query = NoteFolder::withCount('notes')
            ->where('user_id', Auth::id());

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $folders = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $totalFolders = NoteFolder::where('user_id', Auth::id())->count();

        return view('user.notes.note-folders.index', compact(
            'folders',
            'totalFolders'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('note_folders', 'name')
                    ->where('user_id', Auth::id()),
            ],
        ]);

        NoteFolder::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'slug' => $this->makeUniqueSlug($request->name),
        ]);

        return back()->with('success', 'Folder created successfully.');
    }

    public function update(Request $request, NoteFolder $noteFolder)
    {
        $this->authorizeFolder($noteFolder);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('note_folders', 'name')
                    ->where('user_id', Auth::id())
                    ->ignore($noteFolder->id),
            ],
        ]);

        $noteFolder->update([
            'name' => $request->name,
            'slug' => $this->makeUniqueSlug($request->name, $noteFolder->id),
        ]);

        return back()->with('success', 'Folder updated successfully.');
    }

    public function destroy(NoteFolder $noteFolder)
    {
        $this->authorizeFolder($noteFolder);

        $noteFolder->delete();

        return back()->with('success', 'Folder deleted successfully.');
    }

    private function authorizeFolder(NoteFolder $folder): void
    {
        abort_if($folder->user_id !== Auth::id(), 403);
    }

    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            NoteFolder::where('user_id', Auth::id())
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}