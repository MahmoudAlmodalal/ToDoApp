@extends('layouts.app')
@section('title') Edit Task @endsection
@section('content')
    <!-- ====================================
    ——— WRAPPER
    ===================================== -->
		<div class="card card-default">
			<div class="card-header card-header-border-bottom">
				<h2>@yield('form-title','Edit Task')</h2>
			</div>

			<div class="card-body">
				<form method="POST" action="{{route('tasks.update', $task->id)}}">
                    @csrf
                    @method('PUT')
					<div class="form-group">
						<label for="exampleFormControlInput1">Task name</label>
						<input value="{{$task->name}}" name="name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Enter the task name">
					</div>

					<div class="form-group">
						<label for="exampleFormControlSelect12">Task type</label>
						<select value="{{$task->category_id}}" name="category" class="form-control" id="exampleFormControlSelect12">
							@foreach ($categorys as $cat)
                                <option {{$task->category_id == $cat->id ? 'selected': ''}}>{{$cat->name}}</option>
                            @endforeach
						</select>
					</div>
					          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="firstName">Date</label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="mdi mdi-calendar-range"></i>
                    </span>
                  </div>

                  <input value="{{$task->end_date}}" name="date" type="text" class="form-control date-range" name="dateRange" value="" placeholder="End Date"/>
                </div>
              </div>
            </div>
					<div class="form-group">
						<label for="exampleFormControlTextarea1">Task Description</label>
						<textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$task->description}}</textarea>
					</div>

					<div class="form-footer pt-4 pt-5 mt-4 border-top">
						<button type="submit" class="btn btn-primary btn-default">Submit</button>
						<a href="{{route('tasks.index', -1)}}" class="btn btn-secondary btn-default">Cancel</a>
					</div>
				</form>
			</div>
		</div>
@endsection
