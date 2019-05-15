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
Book Catalogue
@endsection

{{-- Page Title Sub --}}
@section('page-title-sub')

@endsection


{{-- Main Content --}}
@section('main-content')
<!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
            	<h6 class="m-0 font-weight-bold text-primary">
                @if(isset($search))
                   Search Results for: {{ $search }}
                @else
                  @if(isset($subjectTitle))
                    Book list for subject '{{ $subjectTitle->name }}'
                  @else
                    Complete Book List
                  @endif
                @endif
              </h6>
            </div>
            <div class="card-body" style="background-color: rgba(10, 10, 10, 0.1);">

              @if(isset($count))
                @if($count == 0)
                  <h6 class="m-0 font-weight-bold text-primary">No Result Found</h6>
                @else
                  <h6 class="m-0 font-weight-bold text-primary">Returned result: {{ $count }}</h6>
                  <br>
                @endif
              @endif

              <div class="row">

                @foreach($books as $book)

                 <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card shadow h-100 py-2">
                    <div class="card-body">
                      <div class="row no-gutters">
                        <div class="col-md-12 text-center">
                          <img src="{{ asset('/img/books') }}/{{ $book->img }}" class="img-thumbnail img-fluid" width="150px" height="350px">
                        </div>
                        <div class="col-md-12 text-center" style="margin-top: 10px ">
                          <h6 class="m-0 font-weight-bold text-primary">{{ $book->name }}</h6>
                          <p>{{ $book->author }}</p>
                          <p>No. of Copies {{ $book->accession->count() }} <br> Available : {{ $book->stocks }}<br><span title="{{ $book->category->name }}" style="color: {{ $book->category->hex }};">■</span> {{ $book->subject->name }}</p>
                          @if($book->stocks > 0)
                            <a href="/borrow/reserve/form/{{ $book->id }}" class="btn btn-success">Reserve</a>
                          @else
                            <a href="javascript:void(0)" class="btn btn-default">Out of Stock</a>
                          @endif
                          
                        </div>
                      </div>
                    </div>
                    </div>
                 </div>

                 @endforeach

              </div>

                <div class="row">
                  <div class="col-md-5 mx-auto justify-content-center">
                 
                    {{ $books->links() }}
                </div>
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
  
});


@if(session('success'))
  alert('{{ session('success') }}');
@endif


</script>
@endsection