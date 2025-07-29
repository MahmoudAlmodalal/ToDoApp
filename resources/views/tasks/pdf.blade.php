@extends('layouts.pdf')
@section('title')
Tasks Report
@endsection
@section('content')
        <h2>Tasks Report</h2>

    <div class="summary">
        <h4>Summary</h4>
        <p>Total Tasks: {{ $totalTasks }}</p>
        <p style="color:#27ae60;">Completed: {{ $completed }} ({{ $percentCompleted }}%)</p>
        <p style="color:#f39c12;">Uncompleted: {{ $uncompleted }} ({{ $percentUncompleted }}%)</p>
        <p style="color:#c0392b;">Failed: {{ $failed }} ({{ $percentFailed }}%)</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Task Name</th>
                <th>Category</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $index => $task)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->category->name }}</td>
                    <td>{{ $task->created_at->format('Y-m-d') }}</td>
                    <td>{{ $task->end_date }}</td>
                    <td>
                        @switch($task->status)
                            @case('completed')
                                <span class="badge badge-success">Completed</span>
                                @break
                            @case('uncompleted')
                                <span class="badge badge-warning">Uncompleted</span>
                                @break
                            @case('failed')
                                <span class="badge badge-danger">Failed</span>
                                @break
                            @default
                                <span>{{ $task->status }}</span>
                        @endswitch
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h2>Categorys Report</h2>
        <div class="summary">
        <h4>Summary</h4>
        <p>Total Categorys: {{ $categorys->count() }}</p>
    </div>
     <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Tasks Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorys as $index => $category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->task_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
        <div class="chart-container">
        <h2>Tasks Chart Report</h2>
            <div class="summary">
        <h4>Summary</h4>
        <p>Total Tasks: {{ $totalTasks }}</p>
        <p style="color:#27ae60;">Completed: {{ $completed }} ({{ $percentCompleted }}%)</p>
        <p style="color:#f39c12;">Uncompleted: {{ $uncompleted }} ({{ $percentUncompleted }}%)</p>
        <p style="color:#c0392b;">Failed: {{ $failed }} ({{ $percentFailed }}%)</p>
    </div>
        <img src="{{ $chartUrl }}" alt="Tasks Progress Chart" />
    </div>
@endsection
