@extends('admin.layout.app')

{{-- HTML Title --}}
@section('html-title')

@endsection


{{-- Css --}}
@section('css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

{{-- Page Title --}}
@section('page-title')
Library List
@endsection

{{-- Page Title Sub --}}
@section('page-title-sub')
<a href="/admin/library/add" class="btn btn-primary"><i class="fa fa-plus"></i> Add new librarian</a>
@endsection


{{-- Main Content --}}
@section('main-content')
<div class="card shadow mb-4">
            <div class="card-header py-3">
            	<h6 class="m-0 font-weight-bold text-primary">Librarian List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Date Created</th>
                      <th>Name</th>
                      <th>Username</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  	@foreach($libs as $lib)
                  		<tr>
                  			<td>{{ $lib->created_at }}</td>
                  			<td>{{ $lib->lname }}, {{ $lib->fname }} {{ $lib->mname }}.</td>
                  			<td>{{ $lib->username }}</td>
                  			<td align="center">
                  				<a href="javascript:void(0)" onclick="reset('{{ $lib->id }}')" title="Show image" class="btn btn-warning btn-sm">
                            <i class="fas fa-undo"></i> Reset password
                          </a>

                          <a href="javascript:void(0)" onclick="deleteL('{{ $lib->id }}')" title="Show image" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Delete
                          </a>
                  			</td>
                  		</tr>
                  	@endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
@endsection


{{-- Js Script --}}
@section('js')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript">
	// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable();
});

@if(session('success'))
  alert('{{ session('success') }}');
@endif


function reset(id)
{
  if(confirm('Reset this librarian password?')){
    window.location = '/admin/library/reset/'+id;
  }
}

function deleteL(id)
{
  if(confirm('Delete this librarian?')){
    window.location = '/admin/library/delete/'+id;
  }
}


</script>
@endsection