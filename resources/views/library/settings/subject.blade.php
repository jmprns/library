@extends('library.layout.app')

{{-- HTML Title --}}
@section('html-title')

@endsection


{{-- Css --}}
@section('css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Page Title --}}
@section('page-title')
Book Subject
@endsection

{{-- Page Title Sub --}}
@section('page-title-sub')
<div class="row">
	<div class="col-lg-7">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Subject List</h6>
			</div>
			<div class="card-body">
					<div class="form-group">
						<label for="book-isbn"><strong>Select Category</strong></label>
							<select id="cat-select" class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                            	<option value="/library/settings/book-subject/0" @if($catd == 0) selected @endif>See All</option>
                        		@foreach($categories as $category)
                        			<option value="/library/settings/book-subject/{{ $category->id }}" @if($catd == $category->id) selected @endif>{{ $category->name }}</option>
                        		@endforeach
                        </select>
					</div>
				<div class="table-responsive">
	                <table class="table table-bordered" id="category-datatable" width="100%" cellspacing="0">
	                  <thead>
	                    <tr>
	                      <th>#</th>
	                      <th>Subject</th>
	                      <th>Category</th>
	                      <th align="center">Action</th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                  	@foreach($subjects as $subject)
	                  		<tr>
	                  			<td></td>
	                  			<td>{{ $subject->name }}</td>
	                  			<td>{{ $subject->category->name }}</td>
	                  			<td align="center">
									<a href="#" class="btn btn-warning btn-circle btn-sm">
										<i class="fas fa-pen"></i>
									</a>
									<a href="javascript:void(0)" onclick="deleteSub('{{ $subject->id }}')" class="btn btn-danger btn-circle btn-sm">
										<i class="fas fa-trash"></i>
									</a>
	                  			</td>
	                  		</tr>
	                  	@endforeach
	                  </tbody>
	                </table>
              	</div>
			</div>
		</div>
	</div>

	<div class="col-lg-5">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Add Category</h6>
			</div>
			<div class="card-body">
				<form method="POST" action="/library/settings/book-subject/store">
					@csrf

					<div class="form-group">
						<label for="book-isbn"><strong>Select Category</strong></label>
							<select id="cat2-select" class="form-control" name="category" required >
                        		@foreach($categories as $category)
                        			<option value="{{ $category->id }}">{{ $category->name }}</option>
                        		@endforeach
                        </select>
					</div>


					<div class="form-group">
						<label for="category-name"><strong>Subject Name</strong></label>
						<input type="text" class="form-control" id="category-name" name="name" placeholder="Category Name" required>
					</div>

					<div class="form-group">
						<button type="reset" class="btn btn-warning">Reset</button>
						<button type="submit" class="btn btn-primary">Add</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

  <!-- Edit Modal-->
  <div class="modal fade" id="category-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        	<form method="POST" action="/library/settings/book-category/update">
        		@csrf
        		<div class="form-group">
					<label for="cat-edit-name"><strong>Category Name</strong></label>
					<input type="text" class="form-control" id="cat-edit-name" placeholder="Category Name" name="name" value="" required>
					<input type="hidden" class="form-control" id="cat-edit-id" name="cat_id" value="" required>
				</div>
        	
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" type="submit">Update</button>
        </div></form>
      </div>
    </div>
  </div>
@endsection


{{-- Main Content --}}
@section('main-content')

@endsection


{{-- Js Script --}}
@section('js')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>

<script type="text/javascript">

$(document).ready(function() {
  $('#category-datatable').DataTable();
  $("#cat-select").select2();
  $("#cat2-select").select2();
});

function deleteSub(id){
	if(confirm('Delete the subject?')){
		window.location = '/library/settings/book-subject/destroy/'+id;
	}
}

</script>


@if(session('success'))
<script type="text/javascript">
	alert('{{ session('success') }}');
</script>
@endif


@endsection