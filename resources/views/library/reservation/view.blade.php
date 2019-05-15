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
Reservation Details
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

                        <h6 class="m-0 font-weight-bold text-primary">Reference Number:</h6>
                        <p>{{ $reservation->rn }}</p>

                        <h6 class="m-0 font-weight-bold text-primary">Reservation Date:</h6>
                        <p>{{ date('F d, Y h:i A', $reservation->reserve_date) }}</p>

                        <h6 class="m-0 font-weight-bold text-primary">Status:</h6>
                        <p>@if($reservation->status == 3 && time() > $reservation->end)<span class="badge badge-danger">Penalty started!</span>@else{!! statusDecoder($reservation->status) !!}@endif</p>

                        <h6 class="m-0 font-weight-bold text-primary">@if($reservation->status == 6) Disapproved Date: @else Approved Date: @endif</h6>
                        <p>@if($reservation->approve_date == NULL) - @else {{ date('F d, Y h:i A', $reservation->approve_date) }} @endif</p>
                        
                        <h6 class="m-0 font-weight-bold text-primary">Claimed Date:</h6>
                        <p>@if($reservation->start == null) - @else {{ date('F d, Y h:i A', $reservation->start) }} @endif</p>
                        
                        <h6 class="m-0 font-weight-bold text-primary">Must Return Date:</h6>
                        <p>@if($reservation->end == null) - @else {{ mustReturn($reservation->days, $reservation->end) }} @endif</p>
                    
                    </div>
                    <div class="col-lg-6">
                        
                        <h6 class="m-0 font-weight-bold text-primary">Borrower:</h6>
                        <p>{{ $reservation->borrow->lname }}, {{ $reservation->borrow->fname }} @if(isset($reservation->borrow->mname)) {{ $reservation->borrow->mname }}. @endif</p>
                        
                        <h6 class="m-0 font-weight-bold text-primary">Department - Year</h6>
                        <p>{{ $reservation->borrow->dept }}</p>
                        
                        <h6 class="m-0 font-weight-bold text-primary">Days borrowed:</h6>
                        <p>@if($reservation->returned == null) - @else {{ getDays($reservation->start, $reservation->returned) }} @endif</p>
                        
                        <h6 class="m-0 font-weight-bold text-primary">@if($reservation->status == 8) Lost Date: @else Returned Date: @endif</h6>
                        <p>@if($reservation->returned == null) - @else {{ date('F d, Y', $reservation->returned) }} @endif</p>
                        
                        <h6 class="m-0 font-weight-bold text-primary">@if($reservation->status == 6) Disapproved By: @else Approved By: @endif</h6>
                        <p>@if($reservation->approve_by == null) - @else @if(isset($reservation->library->lname)){{ $reservation->library->lname }}, {{ $reservation->library->fname }} {{ $reservation->library->mname }}. @else Librarian deleted. @endif @endif</p>
                        
                        <h6 class="m-0 font-weight-bold text-primary">Penalty:</h6>
                        <p>
                            @if($reservation->status == 3 && time() > $reservation->end)
                                {{ penaltyCalculator($reservation->end, time(), 100) }}
                            @elseif($reservation->status == 4 && $reservation->returned > $reservation->end)
                                {{ penaltyCalculator($reservation->end, $reservation->returned, 100) }}
                            @endif
                        </p>
                    
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @if($reservation->notes == '' && $reservation->type == 1)
                        @else
                        <h6 class="m-0 font-weight-bold text-primary">Request date to return:</h6>
                        <p>{{ date('F d, Y', stringToTime($reservation->notes)) }}</p>
                        @endif
                    </div>
                </div>
                <hr>
                @if($reservation->status == 1)
                    <form id="reservation-form" method="POST" action="/library/reservation/approve">
                        @csrf
                        <div class="form-group">
                            <label for="book-author"><h6 class="m-0 font-weight-bold text-primary">Days to borrow:</h6></label><br>
                            <input type="hidden" name="res_id" value="{{ $reservation->id }}">
                            <input type="hidden" id="app-des" name="app_des" value="">
                            <input type="date" id="res-day" name="reservation_days" required class="form-control" placeholder="Include saturday, sunday and holidays">
                        </div>

                        <div class="form-group">
                            <label for="book-author"><h6 class="m-0 font-weight-bold text-primary">Choose Accession</h6></label><br>
                            <select class="form-control" name="accession">
                                @foreach($accessions as $accession)
                                <option value="{{ $accession->id }}">{{ $accession->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    </form>

                    <div class="form-group">
                            <button class="btn btn-success" onclick="resDes('1')">Approve</button>
                            <button class="btn btn-danger" onclick="resDes('2')">Disapprove</button>
                        </div>
                    
                @elseif($reservation->status == 2)
                    <div class="form-group">
                        <label for="book-author"><h6 class="m-0 font-weight-bold text-primary">Actions:</h6></label><br>
                        <button onclick="fetchRes('{{ $reservation->id }}')" class="btn btn-success">Borrowed</button>
                        <button onclick="cancelRes('{{ $reservation->id }}')" class="btn btn-danger">Cancel Reservation</button>
                    </div>
                @elseif($reservation->status == 3)
                    <div class="form-group">
                        <label for="book-author"><h6 class="m-0 font-weight-bold text-primary">Actions:</h6></label><br>
                        <button onclick="returnBook('{{ $reservation->id }}')" class="btn btn-success">Returned</button>
                        <button onclick="lostBook('{{ $reservation->id }}')" class="btn btn-danger">Mark as Lost</button>
                    </div>
                @endif
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
                        <img src="{{ asset('img/books') }}/{{ $reservation->book->img }}" class="img-thumbnail" >
                        
                        <h6 class="m-0 font-weight-bold text-primary">(BOOK COVER)</h6>
                    </div>
                    <div class="col-lg-7">
                        <h6 class="m-0 font-weight-bold text-primary">Book Title:</h6>
                        <p>{{ $reservation->book->name }}</p>
                        <h6 class="m-0 font-weight-bold text-primary">Author:</h6>
                        <p>{{ $reservation->book->author }}</p>
                        <h6 class="m-0 font-weight-bold text-primary">ISBN - Accession:</h6>
                        <p>{{ $reservation->book->isbn }} @if($reservation->acc_id != null) - {{ $reservation->accession->name }} @endif</p>
                        <h6 class="m-0 font-weight-bold text-primary">Category - Subject:</h6>
                        <p><span title="{{ $reservation->book->category->name }}" style="color: {{ $reservation->book->category->hex }};">■</span> {{ $reservation->book->subject->name }}</p>
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