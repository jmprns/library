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
Pre-registered Student/Teacher

@endsection

{{-- Page Title Sub --}}
@section('page-title-sub')

@endsection


{{-- Main Content --}}
@section('main-content')
<!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
            	<h6 class="m-0 font-weight-bold text-primary">Complete Pre-registered Student/Teacher List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Grade - Year</th>
                      <th>LRN/ID</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php($x = 1)
                    @foreach($borrows as $borrow)
                      <tr>
                        <td>{{ $x++ }}</td>
                        <td>{{ $borrow->lname }}, {{ $borrow->fname }} @if(isset($borrow->mname)) {{ $borrow->mname }}. @endif</td>
                        <td>{{ $borrow->dept }}</td>
                        <td>{{ $borrow->username }}</td>
                        <td>
                          <a href="/library/borrow/activate/{{ $borrow->id }}" class="btn btn-success btn-circle btn-sm">
                        <i class="fas fa-check"></i>
                      </a>
                      <a href="javascript:void(0)" onclick="deleteUser('{{ $borrow->id }}')" class="btn btn-danger btn-circle btn-sm">
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

function deleteUser(id)
{
  if(confirm('Delete the borrower?')){
    window.location = '/library/borrow/destroy/'+id;
  }
}

@if(session('success'))
  alert('{{ session('success') }}');
@endif


</script>
@endsection