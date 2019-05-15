@extends('library.layout.app')

{{-- HTML Title --}}
@section('html-title')

@endsection


{{-- Css --}}
@section('css')

@endsection

{{-- Page Title --}}
@section('page-title')
Add Copy
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
				<h6 class="m-0 font-weight-bold text-primary">Accession Information</h6>
			</div>
			<div class="card-body">
				<form method="POST" action="/library/books/copy/accession">

					@csrf
					<input type="hidden" name="bid" value="{{ $book->id }}">

					@php($x = 0)
					
					@while($x != $copy)
					<div class="form-group">
						<label for="book-name"><strong>Accession Name</strong></label>
						<input type="text" class="form-control" id="book-edit-author" placeholder="" name="accession[]" value="" required>
					</div>
					@php($x++)
					@endwhile

					<div class="form-group">
					<a href="/library/books/" class="btn btn-danger">Cancel</a>
					<button type="submit" class="btn btn-primary">Update</button>
				</div>

				</form>
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
                        <h6 class="m-0 font-weight-bold text-primary">(BOOK COVER)</h6>
                    </div>
                    <div class="col-lg-7">
                        <h6 class="m-0 font-weight-bold text-primary">Book Title:</h6>
                        <p>{{ $book->name }}</p>
                        <h6 class="m-0 font-weight-bold text-primary">Author:</h6>
                        <p>{{ $book->author }}</p>
                        <h6 class="m-0 font-weight-bold text-primary">ISBN:</h6>
                        <p>{{ $book->isbn }}</p>
                        <h6 class="m-0 font-weight-bold text-primary">Category - Subject:</h6>
                        <p><span title="{{ $book->category->name }}" style="color: {{ $book->category->hex }};">■</span> {{ $book->subject->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


{{-- Js Script --}}
@section('js')

<script type="text/javascript">

</script>


@endsection