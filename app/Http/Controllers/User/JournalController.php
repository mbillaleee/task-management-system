<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\JournalCategory;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $query = Journal::with('category')
            ->where('user_id', auth()->id());

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->mood) {
            $query->where('mood', $request->mood);
        }

        if ($request->journal_category_id) {
            $query->where('journal_category_id', $request->journal_category_id);
        }

        if ($request->journal_date) {
            $query->whereDate('journal_date', $request->journal_date);
        }

        $journals = $query->latest('journal_date')->paginate(10)->withQueryString();

        $categories = JournalCategory::where('user_id', auth()->id())->latest()->get();

        $totalJournals = Journal::where('user_id', auth()->id())->count();
        $todayJournals = Journal::where('user_id', auth()->id())->whereDate('journal_date', today())->count();
        $gratitudeCount = Journal::where('user_id', auth()->id())->where('type', 'gratitude')->count();
        $favoriteCount = Journal::where('user_id', auth()->id())->where('is_favorite', true)->count();

        return view('user.journals.index', compact(
            'journals',
            'categories',
            'totalJournals',
            'todayJournals',
            'gratitudeCount',
            'favoriteCount'
        ));
    }

    public function create()
    {
        $categories = JournalCategory::where('user_id', auth()->id())->latest()->get();

        return view('user.journals.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'journal_category_id' => 'nullable|exists:journal_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|in:daily,gratitude,reflection,personal_log',
            'mood' => 'nullable|in:happy,calm,neutral,sad,angry,stressed,excited',
            'gratitude_notes' => 'nullable|string',
            'prompt' => 'nullable|string',
            'journal_date' => 'required|date',
            'is_private' => 'nullable|boolean',
            'is_favorite' => 'nullable|boolean',
        ]);

        $journal = Journal::create([
            'user_id' => auth()->id(),
            'journal_category_id' => $request->journal_category_id,
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'mood' => $request->mood,
            'gratitude_notes' => $request->gratitude_notes,
            'prompt' => $request->prompt,
            'journal_date' => $request->journal_date,
            'is_private' => $request->boolean('is_private'),
            'is_favorite' => $request->boolean('is_favorite'),
        ]);

        return redirect()->route('user.journals.show', $journal)->with('success', 'Journal created successfully.');
    }

    public function show(Journal $journal)
    {
        abort_if($journal->user_id !== auth()->id(), 403);

        $journal->load('category');

        return view('user.journals.show', compact('journal'));
    }

    public function edit(Journal $journal)
    {
        abort_if($journal->user_id !== auth()->id(), 403);

        $categories = JournalCategory::where('user_id', auth()->id())->latest()->get();

        return view('user.journals.edit', compact('journal', 'categories'));
    }

    public function update(Request $request, Journal $journal)
    {
        abort_if($journal->user_id !== auth()->id(), 403);

        $request->validate([
            'journal_category_id' => 'nullable|exists:journal_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|in:daily,gratitude,reflection,personal_log',
            'mood' => 'nullable|in:happy,calm,neutral,sad,angry,stressed,excited',
            'gratitude_notes' => 'nullable|string',
            'prompt' => 'nullable|string',
            'journal_date' => 'required|date',
            'is_private' => 'nullable|boolean',
            'is_favorite' => 'nullable|boolean',
        ]);

        $journal->update([
            'journal_category_id' => $request->journal_category_id,
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'mood' => $request->mood,
            'gratitude_notes' => $request->gratitude_notes,
            'prompt' => $request->prompt,
            'journal_date' => $request->journal_date,
            'is_private' => $request->boolean('is_private'),
            'is_favorite' => $request->boolean('is_favorite'),
        ]);

        return redirect()->route('user.journals.show', $journal)->with('success', 'Journal updated successfully.');
    }

    public function destroy(Journal $journal)
    {
        abort_if($journal->user_id !== auth()->id(), 403);

        $journal->delete();

        return redirect()->route('user.journals.index')->with('success', 'Journal deleted successfully.');
    }

    public function toggleFavorite(Journal $journal)
    {
        abort_if($journal->user_id !== auth()->id(), 403);

        $journal->update([
            'is_favorite' => !$journal->is_favorite,
        ]);

        return back()->with('success', 'Favorite status updated.');
    }
}