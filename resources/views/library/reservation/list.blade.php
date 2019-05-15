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
Reservations
@endsection

{{-- Page Title Sub --}}
@section('page-title-sub')

@endsection


{{-- Main Content --}}
@section('main-content')
<!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
            	<h6 class="m-0 font-weight-bold text-primary">Complete Reservation List</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="book-isbn"><strong>Select status</strong></label>
                    <select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                      <option value="/library/reservation/">See All</option>
                      <option value="/library/reservation/status/pending">Pending</option>
                      <option value="/library/reservation/status/cancelled">Cancelled</option>
                      <option value="/library/reservation/status/approved">Approved</option>
                      <option value="/library/reservation/status/dissaproved">Dissaproved</option>
                      <option value="/library/reservation/status/returned">Returned</option>
                      <option value="/library/reservation/status/fetched">Borrowed</option>
                      <option value="/library/reservation/status/lost">Lost</option>
                    </select>
                  </div>
                </div>
              </div>
              <a href="/library/reservation/print/all" target="_blank" class="btn btn-primary">Print</a>
              <br><br>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                    	<th>Date</th>
                      	<th>#RN</th>
                      	<th>Name</th>
                      	<th>Book Title</th>
                      	<th>Author</th>
                        <th>Status</th>
                      	<th>Type</th>
                      	<th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($reservations as $res)
                      <tr>
                        <td>{{ date('Y-m-d h:i', $res->reserve_date) }}</td>
                        <td>{{ $res->rn }}</td>
                        <td>{{ $res->borrow->lname }}, {{ $res->borrow->fname }} @if(isset($res->mname)) {{ $res->borrow->mname }}. @endif</td>
                        <td>{{ $res->book->name }}</td>
                        <td>{{ $res->book->author }}</td>
                        <td>@if($res->status == 3 && time() > $res->end)<span class="badge badge-danger">Penalty started!</span>@else{!! statusDecoder($res->status) !!}@endif</td>
                        <td>@if($res->type == 0) ONLINE @else WALK-IN @endif</td>
                        <td>
                          <a href="/library/reservation/view/{{ $res->id }}" class="btn btn-primary btn-sm" title="">
                              View
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
  $('#dataTable').DataTable({
    "order": [[ 0, "desc" ]]
  });
});

@if(session('success'))
  alert('{{ session('success') }}');
@endif

</script>
@endsection