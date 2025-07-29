@extends('layouts.app')
@section('title') TaskRepor @endsection
@section('script')
    @vite([
    'resources/plugins/circle-progress/circle-progress.js',
    'resources/plugins/nprogress/nprogress.js',
    'resources/plugins/charts/Chart.min.js',
    'resources/js/chart.js',
    ])
@endsection
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
<div id="toaster"></div>
         <!-- ====================================
    ——— WRAPPER
    ===================================== -->
    <div class="row pt-4">
	<div class="col-md-4 col-lg-6 col-xl-3">
		<div class="card widget-block p-4 rounded bg-success border">
			<div class="card-block">
				<i class="mdi mdi-diamond t mr-4 text-white"></i>
				<h4 class="text-white my-2 task-com">{{$taskCompleted}}</h4>
				<p>Task Completed</p>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-lg-6 col-xl-3">
		<div class="card widget-block p-4 rounded bg-warning border">
			<div class="card-block">
				<i class="mdi mdi-cart-outline mr-4 text-white"></i>
				<h4 class="text-white my-2 task-uncom">{{$taskUncompleted}}</h4>
				<p>Task uncompleted</p>
			</div>
		</div>
	</div>

	<div class="col-md-4 col-lg-6 col-xl-3">
		<div class="card widget-block p-4 rounded bg-danger border">
			<div class="card-block">
				<i class="mdi mdi-cart-outline  mr-4 text-white"></i>
				<h4 class="text-white my-2 task-failed">{{$taskFailed}}</h4>
				<p>Task Failed</p>
			</div>
		</div>
	</div>

</div>
				<!--progresss -->
								<div class="col-xl-4">
									<div class="card card-default">
										<div class="card-header card-header-border-bottom">
											<h2>Progress</h2>
										</div>

											<div class="card-body p-4 py-xl-6 px-xl-2">
												<div class="circle circle-lg"
													data-size="200"
													data-value="{{$taskComPer}}"
													data-thickness="20"
													data-fill="{
														&quot;color&quot;: &quot;#35D00E&quot;
													}"
													>
												<div class="circle-content">
													<h6 class="text-uppercase text-dark font-weight-bold">{{$taskComPer}}%</h6>

													<strong></strong>
												</div>
											</div>
										</div>
									</div>
								</div>
    			<div class="col-xl-4 col-md-12">

                  <!-- Doughnut Chart -->
                  <div class="card card-default">
                    <div class="card-header justify-content-center">
                      <h2>Tasks Overview</h2>
                    </div>
                    <div class="card-body" >
                      <canvas id="doChart" task-com="{{$taskCompleted}}" task-uncom="{{$taskUncompleted}}" task-failed="{{$taskFailed}}" ></canvas>
                    </div>
                    <a href="#" class="pb-5 d-block text-center text-muted"><i class="mdi mdi-download mr-2"></i> Download Tasks report</a>
                    <div class="card-footer d-flex flex-wrap bg-white p-0">
                      <div class="col-4">
                        <div class="py-4 px-4">
                          <ul class="d-flex flex-column justify-content-between">
                            <li class="mb-2"><i class="mdi mdi-checkbox-blank-circle-outline mr-2" style="color: #4c84ff"></i>{{$taskCompleted}} Task Completed</li>

                          </ul>
                        </div>
                      </div>
                      <div class="col-4 border-left">
                        <div class="py-4 px-4 ">
                          <ul class="d-flex flex-column justify-content-between">
                            <li class="mb-2"><i class="mdi mdi-checkbox-blank-circle-outline mr-2" style="color: #8061ef"></i>{{$taskUncompleted}} Task uncompleted</li>
                          </ul>
                        </div>
                      </div>
                                            <div class="col-4 border-left">
                        <div class="py-4 px-4 ">
                          <ul class="d-flex flex-column justify-content-between">
                            <li><i class="mdi mdi-checkbox-blank-circle-outline mr-2" style="color: #ffa128"></i>{{$taskFailed}} Task Faild</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>

			</div>
			<div class=" col-xl-4 ">
					<!-- Sessions By device Chart -->
					<div class="card card-default" id="analytics-device" analytics-data-height>
						<div class="card-header justify-content-between">
							<h2>Task Persantage</h2>
						</div>

						<div class="card-body">
							<div class="pb-5">
								<canvas id="deviceChart" task-com="{{$taskCompleted}}" task-uncom="{{$taskUncompleted}}" task-failed="{{$taskFailed}}" ></canvas>
							</div>

							<div class="row no-gutters justify-content-center">
								<div class="col-4 col-lg-3">
									<div class="card card-icon-info text-center border-0">
										<i class="mdi mdi-desktop-mac"></i>
										<p class="pt-3 pb-1">Task Completed</p>
										<h4 class="text-dark pb-1">{{$taskComPer}}%</h4>
										<span class="{{$taskComLastPer <= 0 ? 'text-danger' : 'text-success'}}">{{$taskComLastPer}}% <i class="{{$taskComLastPer <= 0 ? 'mdi mdi-arrow-down-bold' : 'mdi mdi-arrow-up-bold'}}"></i></span>
									</div>
								</div>

								<div class="col-4 col-lg-3">
									<div class="card card-icon-info text-center border-0">
										<i class="mdi mdi-tablet-ipad"></i>
										<p class="pt-3 pb-1">Task uncompleted</p>
										<h4 class="text-dark pb-1">{{$taskUncomPer}}%</h4>
										<span class="{{$taskUncomLastPer <= 0 ? 'text-danger' : 'text-success'}}">{{$taskUncomLastPer}}% <i class="{{$taskUncomLastPer <= 0 ? 'mdi mdi-arrow-down-bold' : 'mdi mdi-arrow-up-bold'}}"></i></span>
									</div>
								</div>

								<div class="col-4 col-lg-3">
									<div class="card card-icon-info text-center border-0">
										<i class="mdi mdi-cellphone-android fa-3x"></i>
										<p class="pt-3 pb-1">Task Failed</p>
										<h4 class="text-dark pb-1">{{$taskFailedPer}}%</h4>
										<span class="{{$taskFailedLastPer <= 0 ? 'text-danger' : 'text-success'}}">{{$taskFailedLastPer}}% <i class="{{$taskFailedLastPer <= 0 ? 'mdi mdi-arrow-down-bold' : 'mdi mdi-arrow-up-bold'}}"></i></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

                  <!-- Recent Order Table -->
                  <div class="card card-table-border-none recent-orders" id="recent-orders">
                    <div class="card-header justify-content-between">
                      <h2>Recent Taskss</h2>
                      <div class="date-range-report ">
                        <span></span>
                      </div>
                    </div>
                    <div class="card-body pt-0 pb-5">
                      <table class="table card-table table-responsive table-responsive-large" style="width:100%">
                        <thead>
                          <tr>
                            <th>Task ID</th>
                            <th>Task Name</th>
                            <th>Task Date</th>
                            <th>Status</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($resTask as $index => $task)
                                <tr>
                                    <td >{{$index + 1}}</td>
                                    <td>
                                    <a class="text-dark" href="">{{$task->name}}</a>
                                    </td>
                                    <td>{{$task->end_date}}</td>
                                    <td >
                                        <a href="{{route('tasks.progress', $task->id)}}" class="badge badge-{{($task->status == 'completed') ? 'success' : (($task->status == 'uncompleted') ? 'warning' : 'danger')}}">{{($task->status == 'completed') ? 'Completed' : (($task->status == 'uncompleted') ? 'Uncompleted' : 'Failed')}}</a>
                                    </td>
                                    <td class="text-right">
                                    <div class="dropdown show d-inline-block widget-dropdown">
                                        <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">

                                        <li class="dropdown-item">
                                            <a href="{{route('tasks.edit', $task->id)}}">Edite</a>
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