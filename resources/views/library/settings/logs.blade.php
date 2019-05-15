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
Log List
@endsection

{{-- Page Title Sub --}}
@section('page-title-sub')
<a href="/library/reservation/print/logs" target="_blank" class="btn btn-primary">Print</a>
@endsection


{{-- Main Content --}}
@section('main-content')
<!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
            	<h6 class="m-0 font-weight-bold text-primary">Complete Log List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Action</th>
                      <th>Librarian</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($logs as $log)
                      <tr>
                        <td>{{ $log->created_at }}</td>
                        <td>{{ $log->action }}</td>
                        <td>@if(isset($reservation->library->lname)){{ $log->librarian->lname }}, {{ $log->librarian->fname }}@endif</td>
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


</script>
@endsection