@extends('layouts.app')
@section('title') Tasks @endsection
@section('model')
<!-- Task Delete Modal -->
<div class="modal fade" id="deleteTaskModal" tabindex="-1" role="dialog" aria-labelledby="deleteTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="" id="deleteTaskForm">
      @csrf
      @method('DELETE')

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Task</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        </div>

        <div class="modal-body">
          Are you sure you want to delete this task?
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
@section('content')
    		<div class="card card-default">
			<div class="card-header card-header-border-bottom d-flex justify-content-between">
				<h2>ToDo Task Table</h2>

				<a href="{{route('tasks.print')}}" target="_blank" class="btn btn-outline-primary btn-sm text-uppercase">
					<i class=" mdi mdi-link mr-1"></i> PDF
				</a>
			</div>
		<div class="card card-default">
			<div class="card-header card-header-border-bottom d-flex justify-content-between">
			            	<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a href="{{route('tasks.index', -1)}}" class="nav-link {{request()->route('int') == -1 ? 'active' : ''}}">All</a>
					</li>
                    @foreach ($categorys as $cat)
                        <li class="nav-item">
                            <a href="{{route('tasks.index', $cat->id)}}" class="nav-link {{request()->route('int') == $cat->id ? 'active' : ''}}">{{$cat->name}}</a>
                        </li>
                    @endforeach
				</ul>
                				<a href="{{route('tasks.create')}}" class="btn btn-outline-primary btn-sm text-uppercase">
					<i class=" mdi mdi-link mr-1"></i> Add Task
				</a>
				<a href="{{route('categorys.create')}}" target="_blank" class="btn btn-outline-primary btn-sm text-uppercase">
					<i class=" mdi mdi-link mr-1"></i> Add Category
				</a>
			</div>


			<div class="card-body">
				<div class="expendable-data-table">
					<table id="expendable-data-table" class="table display nowrap" style="width:100%">
						<thead>
							<tr>
								<th></th>
								<th>ID</th>
								<th>Task name</th>
							<th>Task type</th>
								<th>Start date</th>
								<th>End date</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>

						<tbody>
                            @foreach ($tasks as $index => $task)
                                <tr data-description="{{$task->description}}">
                                    <td class="details-control"></td>
                                    <td>{{$index + 1}}</td>
                                    <td>{{$task->name}}</td>
                                    <td>{{$task->category_id ? $task->category->name : 'not found'}}</td>
                                    <td>{{$task->created_at}}</td>
                                    <td>{{$task->end_date}}</td>
                                    <td >
                                        <a href="{{route('tasks.progress', $task->id)}}" class="badge badge-{{($task->status == 'completed') ? 'success' : (($task->status == 'uncompleted') ? 'warning' : 'danger')}}">{{($task->status == 'completed') ? 'Completed' : (($task->status == 'uncompleted') ? 'Uncompleted' : 'Failed')}}</a>
                                    </td>
                                <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-recent-order5" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order5">
                                    <li class="dropdown-item">
                                        <a href="{{route('tasks.edit', $task->id)}}">Edit</a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="#" class="delete-task-btn" data-task-id="{{$task->id}}" data-toggle="modal" data-target="#deleteTaskModal">Remove</a>
                                    </li>
                                    </ul>
                                </div>
                                </td>
                                </tr>
                            @endforeach
						</tbody>
					</table>
				</div>
                <div class="flex mt-3 page-break-avoid">
                    {{$tasks->links()}}
                </div>
			</div>
		</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    // Handle task delete modal
    $('.delete-task-btn').on('click', function() {
        var taskId = $(this).data('task-id');
        var deleteUrl = "{{ route('tasks.destroy', ':id') }}".replace(':id', taskId);
        $('#deleteTaskForm').attr('action', deleteUrl);
    });
});
</script>
@endsection

