@extends('library.layout.app')

{{-- HTML Title --}}
@section('html-title')

@endsection


{{-- Css --}}
@section('css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

{{-- Page Title --}}
@section('page-title')
Site Borrow
@endsection

{{-- Page Title Sub --}}
@section('page-title-sub')

@endsection


{{-- Main Content --}}
@section('main-content')
<!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
            	<h6 class="m-0 font-weight-bold text-primary">Walkin Borrow</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="book-isbn"><strong>* Select Student</strong></label>
                    <select class="form-control" id="student-select">
                      @foreach($borrows as $borrow)
                        <option value="{{ $borrow->id }}">{{ $borrow->username }} - {{ $borrow->fname }} {{ $borrow->lname }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ISBN</th>
                      <th>Image</th>
                      <th>Book Title</th>
                      <th>Author</th>
                      <th>Subject</th>
                      <th>No. of Copies</th>
                      <th>Reserve</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($books as $book)
                    <tr>
                      <td>{{ $book->isbn }}</td>
                      <td align="center">
                      	<a href="javascript:void(0)" onclick="showImage('{{ $book->img }}')" title="Show image" class="btn btn-primary btn-circle btn-sm">
                    		<i class="fas fa-eye"></i>
                  		</a>
                      </td>
                      <td>{{ $book->name }}</td>
                      <td>{{ $book->author }}</td>
                      <td><span title="{{ $book->category->name }}" style="color: {{ $book->category->hex }};">■</span> {{ $book->subject->name }}</td>
                      <td>{{ $book->stocks }}</td>
                      <td align="center">
                        @if($book->stocks == 0)
                          <button class="btn btn-default">Out of Stock</button>
                        @else
                          <button onclick="reserve('{{ $book->id }}')" class="btn btn-success">Reserve</button>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>


  <!-- BOOK IMAGE Modal-->
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

  <!-- BOOK IMAGE Modal-->
  <div class="modal fade" id="modal-book-copy" tabindex="-1" role="dialog" aria-labelledby="book-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="book-title">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="/library/books/copy">
            @csrf
          <div class="form-group">
            <label for="book-isbn"><strong>Number of Copies</strong></label>
            <input type="hidden" id="copy-book-id" name="book_id">
            <input type="number" class="form-control" id="inputAddress" placeholder="Number of Copies" name="copy" value="{{ old('copy') }}" required>
          </div>
      </div>
      <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" href="login.html">Submit</button>
        </div>
      </form>
      </div>
    </div>
  </div>



@endsection


{{-- Js Script --}}
@section('js')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script type="text/javascript">
	// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable();
  $('#student-select').select2();
});

function showImage(src){
  $("#book-img").attr("src", '{{ asset('img/books') }}/'+src);
  $("#modal-book-image").modal('show');
}

function reserve(id)
{
  var student = $('#student-select').val();

  window.location = '/library/walkin/'+student+'/'+id;
}



@if(session('success'))
  alert('{{ session('success') }}');
@endif


</script>
@endsection