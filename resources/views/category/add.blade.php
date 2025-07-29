@extends('layouts.app')
@section('title') add category @endsection
@section('content')
        <!-- ====================================
    ——— WRAPPER
    ===================================== -->
		<div class="card card-default">
			<div class="card-header card-header-border-bottom">
				<h2>@section('form-title')
                    Add
                @endsection Category</h2>
			</div>

			<div class="card-body">
				<form method="POST" action="{{route('categorys.store')}}">
                    @csrf
					<div class="form-group">
						<label for="exampleFormControlInput1">Category name</label>
						<input name="name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Enter the category name">
					</div>
					<div class="form-footer pt-4 pt-5 mt-4 border-top">
						<button class="btn btn-primary btn-default">Submit</button>
						<a href="{{route('categorys.index')}}" class="btn btn-secondary btn-default">Cancel</a>
				</form>
			</div>
		</div>
@endsection
