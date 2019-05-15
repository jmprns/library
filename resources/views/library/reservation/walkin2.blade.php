@extends('library.layout.app')

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
                <h6 class="m-0 font-weight-bold text-primary">Reservation Details</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">

                        <h6 class="m-0 font-weight-bold text-primary">Reservation Date:</h6>
                        <p>{{ date('F d, Y h:i A', time()) }}</p>

                        <h6 class="m-0 font-weight-bold text-primary">Status:</h6>
                        <p><span class="badge badge-primary">Waiting to Reserve</span></p>
                        
                        <h6 class="m-0 font-weight-bold text-primary">Borrower:</h6>
                        <p>{{ $borrow->fname }} {{ $borrow->lname }}</p>
                        
                        <h6 class="m-0 font-weight-bold text-primary">Department:</h6>
                        <p>{{ $borrow->dept }}</p>
                    
                    </div>
                </div>
                
                <hr>
                    <form id="reservation-form" method="POST" action="/library/walkin">
                        @csrf
                        <div class="form-group">
                            <label for="book-author"><h6 class="m-0 font-weight-bold text-primary">Days to borrow:</h6></label><br>
                            <input type="date" id="res-day" name="reservation_day" min="{{ date('Y-m-d', time()) }}" required class="form-control">
                        </div>

                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <input type="hidden" name="borrow_id" value="{{ $borrow->id }}">

                        <div class="form-group">
                            <label for="book-author"><h6 class="m-0 font-weight-bold text-primary">Choose Accession</h6></label><br>
                            <select class="form-control" name="accession">
                                @foreach($accessions as $accession)
                                <option value="{{ $accession->id }}">{{ $accession->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    

                    <div class="form-group">
                            <button type="submit" class="btn btn-success">Reserve</button>
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
                        <h6 class="m-0 font-weight-bold text-primary">ISBN</h6>
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
<script src="{{ asset('vendor/croppie/croppie.min.js') }}"></script>
<script src="{{ asset('vendor/croppie/exif.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">

function cancelRes(id)
{
    if(confirm('Cancel this reservation?')){
        window.location = '/library/reservation/cancel/'+id;
    }
}

function fetchRes(id)
{
    if(confirm('Mark this reservation as fetch?')){
        window.location = '/library/reservation/fetch/'+id;
    }
}

function lostBook(id)
{
    if(confirm('Mark the book as lost?')){
        window.location = '/library/reservation/lost/'+id;
    }
}

function returnBook(id)
{
    if(confirm('Mark this as returned?')){
        window.location = '/library/reservation/return/'+id;
    }
}

function resDes(des){

    if(des == 1)
    {


        if($('#res-day').val() == ''){
            alert('Input days!');
            return;
        }

        if(confirm('Approve this reservation?')){
        
            $('#app-des').val(des);

            $('#reservation-form').submit();
        }
    }else{
        if(confirm('Disapprove this reservation?')){
            $('#app-des').val(des);
            $('#reservation-form').submit();
        }
    }

}

@if(session('success'))
    alert('{{ session('success') }}');
@endif

</script>


@endsection