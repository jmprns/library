@extends('library.layout.app')

{{-- HTML Title --}}
@section('html-title')

@endsection


{{-- Css --}}
@section('css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

{{-- Page Title --}}
@section('page-title')
Categories & Subjects
@endsection

{{-- Page Title Sub --}}
@section('page-title-sub')
<div class="row">
	<div class="col-lg-7">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Category List</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">
                <table class="table table-bordered" id="category-datatable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th width="3%">Color</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  	@php($x = 1)
                  	@foreach($categories as $category)
                    <tr>
                      <td>{{ $x++ }}</td>
                      <td>{{ $category->name }}</td>
                      <td style="background-color: {{ $category->hex }};"></td>
                      <td align="center">
                      	<a href="javascript:void(0)" onclick="editCategory('{{ $category->id }}', '{{ $category->name }}', '{{ $category->hex }}')" class="btn btn-warning btn-circle btn-sm">
                    		<i class="fas fa-pen"></i>
                  		</a>
                  		<a href="javascript:void(0)" onclick="deleteCategory('{{ $category->id }}')" class="btn btn-danger btn-circle btn-sm">
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
				<form method="POST" action="/library/settings/book-category/store">
					@csrf
					<div class="form-group">
						<label for="category-name"><strong>Category Name</strong></label>
						<input type="text" class="form-control" id="category-name" name="name" placeholder="Category Name" required>
					</div>

          <div class="form-group">
            <label for="category-name"><strong>Pick Color</strong></label>
            <input type="color" class="form-control" id="category-hex" name="hex" required>
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

  <!-- Edit CATEGORY Modal-->
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

            <div class="form-group">
              <label for="cat-edit-name"><strong>Pick Color</strong></label>
              <input type="color" class="form-control" id="cat-edit-hex" placeholder="Category Color" name="hex" value="" required>
            </div>
        	
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" type="submit">Update</button>
        </div></form>
      </div>
    </div>
  </div>

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
                              <option value="/library/books/catsub/0" @if($catd == 0) selected @endif>See All</option>
                            @foreach($categories as $category)
                              <option value="/library/books/catsub/{{ $category->id }}" @if($catd == $category->id) selected @endif>{{ $category->name }}</option>
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
                  <a href="javascript:void(0)" onclick="editSub('{{ $subject->id }}', '{{ $subject->name }}')" class="btn btn-warning btn-circle btn-sm">
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
        <h6 class="m-0 font-weight-bold text-primary">Add Subject</h6>
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

  <!-- Edit SUBJECT Modal-->
  <div class="modal fade" id="subject-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Subject</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="/library/settings/book-subject/update">
            @csrf
            <div class="form-group">
          <label for="sub-edit-name"><strong>Category</strong></label>
          <select class="form-control" name="category" required>
            <option value="">Select Category</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
            <div class="form-group">
          <label for="sub-edit-name"><strong>Subject Name</strong></label>
          <input type="text" class="form-control" id="sub-edit-name" placeholder="Subject Name" name="name" value="" required>
          <input type="hidden" class="form-control" id="sub-edit-id" name="id" value="" required>
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

<script type="text/javascript">

$(document).ready(function() {
  $('#category-datatable').DataTable();
});

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

function editSub(id, name)
{
  $("#sub-edit-name").val(name);
  $("#sub-edit-id").val(id);
  $("#subject-edit-modal").modal('show');
}


function editCategory(id, name, hex)
{
	$("#cat-edit-id").val(id);
  $("#cat-edit-name").val(name);
	$("#cat-edit-hex").val(hex);
	$("#category-edit-modal").modal('show');
}


function deleteCategory(id){

	if(confirm('Are you sure you want to delete the category?')){
		window.location = '/library/settings/book-category/destroy/'+id;
	}

}


</script>


@if(session('success'))
<script type="text/javascript">
	alert('{{ session('success') }}');
</script>
@endif


@endsection