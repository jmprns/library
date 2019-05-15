@extends('borrow.layout.app')

{{-- HTML Title --}}
@section('html-title')

@endsection


{{-- Css --}}
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/croppie/croppie.css') }}">
@endsection

{{-- Page Title --}}
@section('page-title')
Reservation Form
@endsection

{{-- Page Title Sub --}}
@section('page-title-sub')
@endsection


{{-- Main Content --}}
@section('main-content')
<div class="row">
	<div class="col-lg-7">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Fill Up the form</h6>
			</div>
			<div class="card-body">
                <form id="reserve-form" method="POST" action="/borrow/reserve/submit">
                    @csrf
                    <div class="form-group">
                        <label for="book-isbn"><strong>Date to return:</strong></label>
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <input type="date" class="form-control" name="notes" min="{{ date('Y-m-d', time()) }}">
                    </div>
                    
                </form>
                <div class="form-group">
                    <button onclick="reserveForm()" class="btn btn-primary">Submit</button>
                </div>

			</div>
		</div>
	</div>

	<div class="col-lg-5">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Book Details</h6>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-5 text-center">
						<img src="{{ asset('img/books') }}/{{ $book->img }}" class="img-thumbnail" >
						{{-- <img src="{{ asset('img/books/default.jpg') }}" class="img-thumbnail" > --}}
						<h6 class="m-0 font-weight-bold text-primary">(BOOK COVER)</h6>
					</div>
					<div class="col-lg-7">
						<h6 class="m-0 font-weight-bold text-primary">Book Name:</h6>
						<p>{{ $book->name }}</p>
						<h6 class="m-0 font-weight-bold text-primary">Author:</h6>
						<p>{{ $book->author }}</p>
						<h6 class="m-0 font-weight-bold text-primary">ISBN:</h6>
						<p>{{ $book->isbn }}</p>
						<h6 class="m-0 font-weight-bold text-primary">Category - Subject:</h6>
						<p>{{ $book->category->name }} - {{ $book->subject->name }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection


{{-- Js Script --}}
@section('js')
<script src="{{ asset('vendor/croppie/croppie.min.js') }}"></script>
<script src="{{ asset('vendor/croppie/exif.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
function reserveForm(){
    if(confirm('Reserve this book?')){
        $('#reserve-form').submit();
    }
}
</script>


@endsection