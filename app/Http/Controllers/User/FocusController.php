<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FocusSession;
use App\Models\FocusSessionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\GamificationService;
use App\Http\Controllers\User\ChallengeController;

class FocusController extends Controller
{
    public function index()
    {
        $sessions = FocusSession::where('user_id', auth()->id())
            ->latest()
            ->paginate(9);

        $stats = $this->stats();

        return view('user.focus.index', compact('sessions', 'stats'));
    }

    public function create()
    {
        return view('user.focus.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $data['user_id'] = auth()->id();
        $data['completed_minutes'] = $data['completed_minutes'] ?? 0;
        $data['xp_earned'] = $data['xp_earned'] ?? 0;
        $data['fullscreen_mode'] = $request->boolean('fullscreen_mode');
        $data['distraction_free'] = $request->boolean('distraction_free');

        $focus = FocusSession::create($data);

        $this->storeHistory($focus, 'Created', 'Focus session created.');

        return redirect()
            ->route('user.focus.index')
            ->with('success', 'Focus session created successfully.');
    }

    public function show($id)
    {
        $focus = $this->findUserFocus($id);
        $focus->load('histories');

        return view('user.focus.show', compact('focus'));
    }

    public function edit($id)
    {
        $focus = $this->findUserFocus($id);

        return view('user.focus.edit', compact('focus'));
    }

    public function update(Request $request, $id)
    {
        $focus = $this->findUserFocus($id);

        $data = $this->validatedData($request);

        $data['fullscreen_mode'] = $request->boolean('fullscreen_mode');
        $data['distraction_free'] = $request->boolean('distraction_free');

        if ($data['status'] === 'completed') {
            $data['completed_minutes'] = $data['duration_minutes'];
            $data['completed_at'] = $focus->completed_at ?? now();
            $data['xp_earned'] = $this->calculateXp($data['duration_minutes']);
        }

        $focus->update($data);

        $this->storeHistory($focus, 'Updated', 'Focus session updated.');

        return redirect()
            ->route('user.focus.show', $focus->id)
            ->with('success', 'Focus session updated successfully.');
    }

    public function destroy($id)
    {
        $focus = $this->findUserFocus($id);

        $focus->delete();

        return redirect()
            ->route('user.focus.index')
            ->with('success', 'Focus session deleted successfully.');
    }

    public function start($id)
    {
        $focus = $this->findUserFocus($id);

        $focus->update([
            'status' => 'running',
            'started_at' => $focus->started_at ?? now(),
            'paused_at' => null,
        ]);

        $this->storeHistory($focus, 'Started', 'Focus session started.');

        return back()->with('success', 'Focus session started.');
    }

    public function pause(Request $request, $id)
    {
        $focus = $this->findUserFocus($id);

        $focus->update([
            'status' => 'paused',
            'paused_at' => now(),
            'completed_minutes' => $request->completed_minutes ?? $focus->completed_minutes,
        ]);

        $this->storeHistory($focus, 'Paused', 'Focus session paused.');

        return back()->with('success', 'Focus session paused.');
    }

    public function complete(Request $request, $id)
    {
        $focus = $this->findUserFocus($id);

        $completedMinutes = $request->completed_minutes ?? $focus->duration_minutes;
        $xpEarned = $this->calculateXp($completedMinutes);

        $focus->update([
            'status'            => 'completed',
            'completed_minutes' => $completedMinutes,
            'completed_at'      => now(),
            'xp_earned'         => $xpEarned,
        ]);

        $this->storeHistory($focus, 'Completed', 'Focus session completed.');

        // ✅ XP Award: UserGamification-এ যোগ করুন
        GamificationService::awardXp(
            auth()->id(),
            $xpEarned,
            'Focus session completed: ' . $completedMinutes . ' minutes'
        );

        if ($focus->wasChanged('status') && $focus->status === 'completed') {
            ChallengeController::autoProgress(auth()->id(), 'finish_focus');
        }

        return back()->with('success', 'Focus session completed! You earned ' . $xpEarned . ' XP ⚡');
    }

    public function cancel($id)
    {
        $focus = $this->findUserFocus($id);

        $focus->update([
            'status' => 'cancelled',
        ]);

        $this->storeHistory($focus, 'Cancelled', 'Focus session cancelled.');

        return back()->with('success', 'Focus session cancelled.');
    }

    public function fullscreen($id)
    {
        $focus = $this->findUserFocus($id);

        return view('user.focus.fullscreen', compact('focus'));
    }

    public function statistics()
    {
        $stats = $this->stats();

        $dailyFocus = FocusSession::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(completed_minutes) as minutes')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc')
            ->take(7)
            ->get()
            ->reverse()
            ->values();

        return view('user.focus.statistics', compact('stats', 'dailyFocus'));
    }

    public function history()
    {
        $histories = FocusSessionHistory::with('focusSession')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('user.focus.history', compact('histories'));
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => 'nullable|string|max:255',
            'type' => 'required|in:pomodoro,deep_work,focus_timer,break',
            'duration_minutes' => 'required|integer|min:1|max:300',
            'completed_minutes' => 'nullable|integer|min:0',
            'status' => 'required|in:pending,running,paused,completed,cancelled',
            'ambient_sound' => 'required|in:none,white_noise,rain,lofi',
            'xp_earned' => 'nullable|integer|min:0',
        ]);
    }

    private function findUserFocus($id): FocusSession
    {
        return FocusSession::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();
    }

    private function calculateXp(int $minutes): int
    {
        return max(5, $minutes * 2);
    }

    private function storeHistory(FocusSession $focus, string $action, string $description): void
    {
        FocusSessionHistory::create([
            'focus_session_id' => $focus->id,
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
        ]);
    }

    private function stats(): array
    {
        $baseQuery = FocusSession::where('user_id', auth()->id());

        return [
            'total_focus_minutes' => (clone $baseQuery)
                ->where('status', 'completed')
                ->sum('completed_minutes'),

            'completed_sessions' => (clone $baseQuery)
                ->where('status', 'completed')
                ->count(),

            'total_xp' => (clone $baseQuery)
                ->sum('xp_earned'),

            'running_session' => (clone $baseQuery)
                ->where('status', 'running')
                ->first(),

            'total_sessions' => (clone $baseQuery)
                ->count(),

            'longest_session' => (clone $baseQuery)
                ->where('status', 'completed')
                ->max('completed_minutes') ?? 0,
        ];
    }
}