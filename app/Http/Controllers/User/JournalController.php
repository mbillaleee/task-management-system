<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\JournalCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Favorites filter
        if ($request->favorites) {
            $query->where('is_favorite', true);
        }

        $journals = $query->latest('journal_date')->paginate(10)->withQueryString();

        $categories = JournalCategory::where('user_id', auth()->id())->latest()->get();

        $totalJournals  = Journal::where('user_id', auth()->id())->count();
        $todayJournals  = Journal::where('user_id', auth()->id())->whereDate('journal_date', today())->count();
        $gratitudeCount = Journal::where('user_id', auth()->id())->where('type', 'gratitude')->count();
        $favoriteCount  = Journal::where('user_id', auth()->id())->where('is_favorite', true)->count();

        // Writing streak calculation
        $writingStreak = $this->calculateWritingStreak();

        return view('user.journals.index', compact(
            'journals',
            'categories',
            'totalJournals',
            'todayJournals',
            'gratitudeCount',
            'favoriteCount',
            'writingStreak'
        ));
    }

    public function create()
    {
        $categories = JournalCategory::where('user_id', auth()->id())->latest()->get();

        // Predefined writing prompts
        $prompts = $this->getWritingPrompts();

        return view('user.journals.create', compact('categories', 'prompts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'journal_category_id' => 'nullable|exists:journal_categories,id',
            'title'               => 'required|string|max:255',
            'content'             => 'nullable|string',
            'type'                => 'required|in:daily,gratitude,reflection,personal_log',
            'mood'                => 'nullable|in:happy,calm,neutral,sad,angry,stressed,excited',
            'gratitude_notes'     => 'nullable|string',
            'prompt'              => 'nullable|string',
            'journal_date'        => 'required|date',
            'is_private'          => 'nullable|boolean',
            'is_favorite'         => 'nullable|boolean',
        ]);

        $journal = Journal::create([
            'user_id'             => auth()->id(),
            'journal_category_id' => $request->journal_category_id,
            'title'               => $request->title,
            'content'             => $request->content,
            'type'                => $request->type,
            'mood'                => $request->mood,
            'gratitude_notes'     => $request->gratitude_notes,
            'prompt'              => $request->prompt,
            'journal_date'        => $request->journal_date,
            'is_private'          => $request->boolean('is_private'),
            'is_favorite'         => $request->boolean('is_favorite'),
        ]);

        return redirect()->route('user.journals.show', $journal)
            ->with('success', 'Journal created successfully.');
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
        $prompts    = $this->getWritingPrompts();

        return view('user.journals.edit', compact('journal', 'categories', 'prompts'));
    }

    public function update(Request $request, Journal $journal)
    {
        abort_if($journal->user_id !== auth()->id(), 403);

        $request->validate([
            'journal_category_id' => 'nullable|exists:journal_categories,id',
            'title'               => 'required|string|max:255',
            'content'             => 'nullable|string',
            'type'                => 'required|in:daily,gratitude,reflection,personal_log',
            'mood'                => 'nullable|in:happy,calm,neutral,sad,angry,stressed,excited',
            'gratitude_notes'     => 'nullable|string',
            'prompt'              => 'nullable|string',
            'journal_date'        => 'required|date',
            'is_private'          => 'nullable|boolean',
            'is_favorite'         => 'nullable|boolean',
        ]);

        $journal->update([
            'journal_category_id' => $request->journal_category_id,
            'title'               => $request->title,
            'content'             => $request->content,
            'type'                => $request->type,
            'mood'                => $request->mood,
            'gratitude_notes'     => $request->gratitude_notes,
            'prompt'              => $request->prompt,
            'journal_date'        => $request->journal_date,
            'is_private'          => $request->boolean('is_private'),
            'is_favorite'         => $request->boolean('is_favorite'),
        ]);

        return redirect()->route('user.journals.show', $journal)
            ->with('success', 'Journal updated successfully.');
    }

    public function destroy(Journal $journal)
    {
        abort_if($journal->user_id !== auth()->id(), 403);

        $journal->delete();

        return redirect()->route('user.journals.index')
            ->with('success', 'Journal deleted successfully.');
    }

    public function toggleFavorite(Journal $journal)
    {
        abort_if($journal->user_id !== auth()->id(), 403);

        $journal->update(['is_favorite' => !$journal->is_favorite]);

        return back()->with('success', 'Favorite status updated.');
    }

    // ─── Statistics ───────────────────────────────────────────────
    public function statistics()
    {
        $userId = auth()->id();

        // Total entries per type
        $byType = Journal::where('user_id', $userId)
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type')
            ->toArray();

        // Mood distribution
        $moodData = Journal::where('user_id', $userId)
            ->whereNotNull('mood')
            ->select('mood', DB::raw('count(*) as total'))
            ->groupBy('mood')
            ->orderByDesc('total')
            ->pluck('total', 'mood')
            ->toArray();

        // Last 12 months — entries per month
        $monthlyData = Journal::where('user_id', $userId)
            ->where('journal_date', '>=', now()->subMonths(11)->startOfMonth())
            ->select(
                DB::raw('DATE_FORMAT(journal_date, "%Y-%m") as month'),
                DB::raw('count(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill in missing months with 0
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $key = now()->subMonths($i)->format('Y-m');
            $months[$key] = $monthlyData[$key] ?? 0;
        }

        // Writing streak
        $writingStreak = $this->calculateWritingStreak();

        // Total word count (approximate)
        $totalWords = Journal::where('user_id', $userId)
            ->whereNotNull('content')
            ->get()
            ->sum(fn($j) => str_word_count(strip_tags($j->content)));

        // Most productive day of week
        $dayData = Journal::where('user_id', $userId)
            ->select(DB::raw('DAYNAME(journal_date) as day'), DB::raw('count(*) as total'))
            ->groupBy('day')
            ->orderByDesc('total')
            ->pluck('total', 'day')
            ->toArray();

        $totalJournals  = Journal::where('user_id', $userId)->count();
        $gratitudeCount = Journal::where('user_id', $userId)->where('type', 'gratitude')->count();
        $favoriteCount  = Journal::where('user_id', $userId)->where('is_favorite', true)->count();
        $thisMonthCount = Journal::where('user_id', $userId)
            ->whereMonth('journal_date', now()->month)
            ->whereYear('journal_date', now()->year)
            ->count();

        return view('user.journals.statistics', compact(
            'byType',
            'moodData',
            'months',
            'writingStreak',
            'totalWords',
            'dayData',
            'totalJournals',
            'gratitudeCount',
            'favoriteCount',
            'thisMonthCount'
        ));
    }

    // ─── Helpers ──────────────────────────────────────────────────
    private function calculateWritingStreak(): int
    {
        $userId = auth()->id();

        $dates = Journal::where('user_id', $userId)
            ->select(DB::raw('DATE(journal_date) as day'))
            ->groupBy('day')
            ->orderByDesc('day')
            ->pluck('day')
            ->map(fn($d) => \Carbon\Carbon::parse($d))
            ->toArray();

        if (empty($dates)) {
            return 0;
        }

        $streak = 0;
        $check  = \Carbon\Carbon::today();

        // Allow today or yesterday as the starting point
        if (!$dates[0]->isSameDay($check) && !$dates[0]->isSameDay($check->copy()->subDay())) {
            return 0;
        }

        foreach ($dates as $date) {
            if ($date->isSameDay($check) || $date->isSameDay($check->copy()->subDay())) {
                $streak++;
                $check = $date->copy()->subDay();
            } else {
                break;
            }
        }

        return $streak;
    }

    private function getWritingPrompts(): array
    {
        return [
            'What did I learn today?',
            'What am I most grateful for right now?',
            'What challenged me today and how did I handle it?',
            'What is one thing I want to improve about myself?',
            'What made me smile today?',
            'What would I do differently if I could redo today?',
            'What are my top 3 priorities for tomorrow?',
            'How am I feeling right now and why?',
            'What is one small win I had today?',
            'What does my ideal day look like?',
            'What fear is holding me back right now?',
            'Who had a positive impact on my life recently?',
        ];
    }
}
