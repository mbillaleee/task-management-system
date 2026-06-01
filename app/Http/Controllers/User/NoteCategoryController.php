<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\NoteCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NoteCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = NoteCategory::withCount('notes')
            ->where('user_id', Auth::id());

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $totalCategories = NoteCategory::where('user_id', Auth::id())->count();

        return view('user.notes.note-categories.index', compact(
            'categories',
            'totalCategories'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('note_categories', 'name')
                    ->where('user_id', Auth::id()),
            ],
            'color' => [
                'required',
                'string',
                'max:20',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],
        ]);

        NoteCategory::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'slug' => $this->makeUniqueSlug($request->name),
            'color' => $request->color,
        ]);

        return back()->with('success', 'Category created successfully.');
    }

    public function update(Request $request, NoteCategory $noteCategory)
    {
        $this->authorizeCategory($noteCategory);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('note_categories', 'name')
                    ->where('user_id', Auth::id())
                    ->ignore($noteCategory->id),
            ],
            'color' => [
                'required',
                'string',
                'max:20',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],
        ]);

        $noteCategory->update([
            'name' => $request->name,
            'slug' => $this->makeUniqueSlug($request->name, $noteCategory->id),
            'color' => $request->color,
        ]);

        return back()->with('success', 'Category updated successfully.');
    }

    public function destroy(NoteCategory $noteCategory)
    {
        $this->authorizeCategory($noteCategory);

        $noteCategory->delete();

        return back()->with('success', 'Category deleted successfully.');
    }

    private function authorizeCategory(NoteCategory $category): void
    {
        abort_if($category->user_id !== Auth::id(), 403);
    }

    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            NoteCategory::where('user_id', Auth::id())
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