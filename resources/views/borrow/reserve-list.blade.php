@extends('borrow.layout.app')

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
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>#RN</th>
                      <th>Book Name</th>
                      <th>Author</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($reservations as $reservation)
                      <tr>
                        <td>{{ date('Y-m-d h:i', $reservation->reserve_date) }}</td>
                        <td>{{ $reservation->rn }}</td>
                        <td>{{ $reservation->book->name }}</td>
                        <td>{{ $reservation->book->author }}</td>
                        <td>
                          @if($reservation->status == 3 && time() > $reservation->end) 
                            <span class="badge badge-danger">
                              Penalty Started!
                            </span>
                          @else 
                            {!! statusDecoder($reservation->status) !!}
                          @endif
                        </td>
                        <td>
                          <a href="/borrow/reserve/view/{{ $reservation->id }}" class="btn btn-primary">View</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>


  <!-- Logout Modal-->
  <div class="modal fade" id="modal-book-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
       		<div class="text-center">
			  <img id="book-img" src="{{ asset('img/books/default.jpg') }}" width="280px" height="450px" class="rounded" alt="...">
			</div>
    	</div>
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