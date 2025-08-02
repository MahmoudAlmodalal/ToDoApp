<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Exceptions\TaskNotFoundException;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($catId)
    {
        $category = Category::withCount('task')
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->take(5)
            ->get();

        $tasksQ = Task::with('category')->where('user_id', Auth::user()->id);

        if ($catId != -1) {
            $tasksQ = Task::where(['category_id' => $catId, 'user_id' => Auth::user()->id]);
        }

        $tasks = $tasksQ->paginate(5);

        return view('tasks.show', [
            'categorys' => $category,
            'tasks' => $tasks,
        ]);
    }

    public function progress($taskId)
    {
        $status = ['completed' => 'failed', 'uncompleted' => 'completed', 'failed' => 'uncompleted'];
        $task = Task::where('user_id', Auth::user()->id)->findOrFail($taskId);
        $task->status = $status[$task->status] ?? 'uncompleted';
        $task->save();

        return redirect()->back()->with('success', 'Task status updated successfully!');
    }

    public function report()
    {
        $now = Carbon::now();
        $tasks = Task::where('user_id', Auth::user()->id)->get();

        // Current month statistics
        $currentMonCom = Task::where('user_id', Auth::user()->id)
            ->whereMonth('end_date', $now->month)
            ->whereYear('end_date', $now->year)
            ->where('status', 'completed')
            ->count();

        $currentMonUncom = Task::where('user_id', Auth::user()->id)
            ->whereMonth('end_date', $now->month)
            ->whereYear('end_date', $now->year)
            ->where('status', 'uncompleted')
            ->count();

        $currentMonFailed = Task::where('user_id', Auth::user()->id)
            ->whereMonth('end_date', $now->month)
            ->whereYear('end_date', $now->year)
            ->where('status', 'failed')
            ->count();

        // Last month statistics
        $lastMon = Carbon::now()->subMonth();
        $lastMonCom = Task::where('user_id', Auth::user()->id)
            ->whereMonth('end_date', $lastMon->month)
            ->whereYear('end_date', $lastMon->year)
            ->where('status', 'completed')
            ->count();

        $lastMonUncom = Task::where('user_id', Auth::user()->id)
            ->whereMonth('end_date', $lastMon->month)
            ->whereYear('end_date', $lastMon->year)
            ->where('status', 'uncompleted')
            ->count();

        $lastMonFailed = Task::where('user_id', Auth::user()->id)
            ->whereMonth('end_date', $lastMon->month)
            ->whereYear('end_date', $lastMon->year)
            ->where('status', 'failed')
            ->count();

        // Overall statistics
        $taskCompleted = $tasks->where('status', 'completed')->count();
        $taskUncompleted = $tasks->where('status', 'uncompleted')->count();
        $taskFailed = $tasks->where('status', 'failed')->count();
        $taskCount = $tasks->count();

        // Calculate percentages
        $taskComPer = $taskCount > 0 ? round(($taskCompleted * 100) / $taskCount, 2) : 0;
        $taskUncomPer = $taskCount > 0 ? round(($taskUncompleted * 100) / $taskCount, 2) : 0;
        $taskFailedPer = $taskCount > 0 ? round(($taskFailed * 100) / $taskCount, 2) : 0;

        // Recent tasks
        $resTask = Task::where('user_id', Auth::user()->id)->latest()->take(5)->get();

        // Calculate month-over-month changes
        $taskComLastPer = $lastMonCom > 0 ? round((($currentMonCom - $lastMonCom) / $lastMonCom) * 100, 2) : ($currentMonCom > 0 ? 100 : 0);
        $taskUncomLastPer = $lastMonUncom > 0 ? round((($currentMonUncom - $lastMonUncom) / $lastMonUncom) * 100, 2) : ($currentMonUncom > 0 ? 100 : 0);
        $taskFailedLastPer = $lastMonFailed > 0 ? round((($currentMonFailed - $lastMonFailed) / $lastMonFailed) * 100, 2) : ($currentMonFailed > 0 ? 100 : 0);

        $report = [
            'taskCount' => $taskCount,
            'taskCompleted' => $taskCompleted,
            'taskUncompleted' => $taskUncompleted,
            'taskFailed' => $taskFailed,
            'taskComPer' => $taskComPer,
            'taskUncomPer' => $taskUncomPer,
            'taskFailedPer' => $taskFailedPer,
            'taskComLastPer' => $taskComLastPer,
            'taskUncomLastPer' => $taskUncomLastPer,
            'taskFailedLastPer' => $taskFailedLastPer,
            'resTask' => $resTask
        ];

        return view('tasks.report', $report);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::where('user_id', Auth::user()->id)->get();

        if ($category->isEmpty()) {
            return redirect()->route('categorys.create')
                ->with('info', 'Please create a category first before adding tasks.');
        }

        return view('tasks.add', [
            'categorys' => $category,
        ]);
    }

    /**
     * Generate PDF report
     */
    public function print()
    {
        $tasks = Task::with('category')->where('user_id', Auth::user()->id)->get();
        $categorys = Category::withCount('task')->where('user_id', Auth::user()->id)->get();

        $totalTasks = $tasks->count();
        $completed = $tasks->where('status', 'completed')->count();
        $uncompleted = $tasks->where('status', 'uncompleted')->count();
        $failed = $tasks->where('status', 'failed')->count();

        $percentCompleted = $totalTasks ? round(($completed / $totalTasks) * 100, 2) : 0;
        $percentUncompleted = $totalTasks ? round(($uncompleted / $totalTasks) * 100, 2) : 0;
        $percentFailed = $totalTasks ? round(($failed / $totalTasks) * 100, 2) : 0;

        // QuickChart URL for a pie chart
        $chartConfig = [
            'type' => 'pie',
            'data' => [
                'labels' => ['Completed', 'Uncompleted', 'Failed'],
                'datasets' => [[
                    'data' => [$completed, $uncompleted, $failed],
                    'backgroundColor' => ['#27ae60', '#f39c12', '#c0392b']
                ]]
            ],
            'options' => [
                'plugins' => [
                    'legend' => ['position' => 'bottom']
                ]
            ]
        ];

        $chartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig));

        $pdf = Pdf::loadView('tasks.pdf', compact(
            'tasks', 'categorys', 'totalTasks', 'completed', 'uncompleted', 'failed',
            'percentCompleted', 'percentUncompleted', 'percentFailed', 'chartUrl'
        ));

        $pdf->setOptions(['isRemoteEnabled' => true]);
        return $pdf->stream('tasks_report.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'exists:categories,name'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $category = Category::where('name', $validated['category'])
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$category) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Selected category does not exist or you do not have permission to use it.');
        }

        DB::transaction(function () use ($validated, $category) {
            Task::create([
                'name' => $validated['name'],
                'category_id' => $category->id,
                'user_id' => Auth::user()->id,
                'end_date' => $validated['date'],
                'description' => $validated['description'],
                'status' => 'uncompleted'
            ]);
        });

        return redirect()->route('tasks.index', -1)->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // This method can be implemented if needed for individual task viewing
        return redirect()->route('tasks.index', -1);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($taskId)
    {
        $task = Task::where('user_id', Auth::user()->id)->findOrFail($taskId);
        $categorys = Category::where('user_id', Auth::user()->id)->get();

        return view('tasks.edit', [
            'task' => $task,
            'categorys' => $categorys,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $taskId)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'exists:categories,name'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $task = Task::where('user_id', Auth::user()->id)->findOrFail($taskId);

        $category = Category::where('name', $validated['category'])
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$category) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Selected category does not exist or you do not have permission to use it.');
        }

        DB::transaction(function () use ($task, $validated, $category) {
            $task->update([
                'name' => $validated['name'],
                'category_id' => $category->id,
                'end_date' => $validated['date'],
                'description' => $validated['description'],
            ]);
        });

        return redirect()->route('tasks.index', -1)->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($taskId)
    {
        DB::transaction(function () use ($taskId) {
            $task = Task::where('user_id', Auth::user()->id)->findOrFail($taskId);
            $task->delete();
        });

        return redirect()->route('tasks.index', -1)->with('success', 'Task deleted successfully!');
    }
}

