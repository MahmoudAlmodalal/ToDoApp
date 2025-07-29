@extends('layouts.app')
@section('title') show category @endsection
@section('model')
<!-- Category Delete Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this category?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteCategoryForm" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
        <!-- ====================================
    ——— WRAPPER
    ===================================== -->
		<div class="col-lg-6">
		<div class="card card-default">
			<div class="card-header card-header-border-bottom d-flex justify-content-between">
				<h2>Category Table</h2>
					<a href="{{route('categorys.create')}}" class="btn btn-outline-primary btn-sm text-uppercase">
					<i class=" mdi mdi-link mr-1"></i> Add
				</a>
			</div>

			<div class="card-body">

				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Name</th>
							<th scope="col">Tasks</th>
							<th scope="col">Actions</th>
						</tr>
					</thead>

					<tbody>
                        @foreach ($categorys as $index => $category)
                            <tr>
                                <td scope="row">{{$index + 1}}</td>
                                <td>{{$category->name}}</td>
                                <td>{{$category->task_count}}</td>
                                <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-recent-order5" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order5">
                                    <li class="dropdown-item">
                                        <a href="{{route('categorys.edit', $category->id)}}">Edit</a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="#" class="delete-category-btn" data-toggle="modal" data-target="#deleteCategoryModal"
                                            data-cat-id="{{ $category->id }}">Remove</a>
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
	</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    // Handle category delete modal
    $('.delete-category-btn').on('click', function() {
        var categoryId = $(this).data('cat-id');
        var deleteUrl = "{{ route('categorys.destroy', ':id') }}".replace(':id', categoryId);
        $('#deleteCategoryForm').attr('action', deleteUrl);
    });
});
</script>
@endsection

