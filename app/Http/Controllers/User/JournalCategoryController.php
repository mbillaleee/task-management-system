<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\JournalCategory;
use Illuminate\Http\Request;

class JournalCategoryController extends Controller
{
    public function index()
    {
        $categories = JournalCategory::withCount('journals')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('user.journals.categories', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);

        JournalCategory::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'color' => $request->color ?? '#f97316',
        ]);

        return back()->with('success', 'Journal category created.');
    }

    public function update(Request $request, JournalCategory $category)
    {
        abort_if($category->user_id !== auth()->id(), 403);

        $request->validate([
            'name' => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);

        $category->update([
            'name' => $request->name,
            'color' => $request->color ?? '#f97316',
        ]);

        return back()->with('success', 'Journal category updated.');
    }

    public function destroy(JournalCategory $category)
    {
        abort_if($category->user_id !== auth()->id(), 403);

        $category->delete();

        return back()->with('success', 'Journal category deleted.');
    }
}