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

                        

                        <h6 class="m-0 font-weight-bold text-primary">@if($reservation->status == 6) Disapproved Date: @else Approved Date: @endif</h6>
                        <p>@if($reservation->approve_date == NULL) - @else {{ date('F d, Y h:i A', $reservation->approve_date) }} @endif</p>
                        
                        <h6 class="m-0 font-weight-bold text-primary">Claimed Date:</h6>
                        <p>@if($reservation->start == null) - @else {{ date('F d, Y h:i A', $reservation->start) }} @endif</p>
                        
                        <h6 class="m-0 font-weight-bold text-primary">Must Return Date:</h6>
                        <p>@if($reservation->end == null) - @else {{ mustReturn($reservation->days, $reservation->end) }} @endif</p>
                    
                    </div>
                    <div class="col-lg-6">
                        
                        <h6 class="m-0 font-weight-bold text-primary">Status:</h6>
                        <p>@if($reservation->status == 3 && time() > $reservation->end)<span class="badge badge-danger">Penalty started!</span>@else{!! statusDecoder($reservation->status) !!}@endif</p>
                        
                        <h6 class="m-0 font-weight-bold text-primary">Days borrowed:</h6>
                        <p>@if($reservation->returned == null) - @else {{ getDays($reservation->start, $reservation->returned) }} @endif</p>
                        
                        <h6 class="m-0 font-weight-bold text-primary">@if($reservation->status == 8) Lost Date: @else Returned Date: @endif</h6>
                        <p>@if($reservation->returned == null) - @else {{ date('F d, Y', $reservation->returned) }} @endif</p>
                        
                        <h6 class="m-0 font-weight-bold text-primary">@if($reservation->status == 6) Disapproved By: @else Approved By: @endif</h6>
                        <p>@if($reservation->approve_by == null) - @else @if(isset($reservation->library->lname)){{ $reservation->library->lname }}, {{ $reservation->library->fname }} {{ $reservation->library->mname }}.@else Librarian deleted. @endif @endif</p>
                        
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
                        <h6 class="m-0 font-weight-bold text-primary">Request date to return:</h6>
                        <p>{{ date('F d, Y', stringToTime($reservation->notes)) }}</p>
                    </div>
                </div>
                <hr>
                @if($reservation->status == 1)
                    <div class="form-group">
                        <label for="book-author"><h6 class="m-0 font-weight-bold text-primary">Actions:</h6></label><br>
                        <button onclick="cancelRes('{{ $reservation->id }}')" class="btn btn-danger">Cancel Reservation</button>
                    </div>
                @elseif($reservation->status == 3 && time() > $reservation->end)
                    <h6 class="m-0 font-weight-bold text-danger">Please return this book to the library as soon as possible for fewer penalty fine!</h6>
                @elseif($reservation->status == 3 && time() < $reservation->end)
                    <h6 class="m-0 font-weight-bold text-default">Return this book before the due date to avoid penalty.</h6>
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
                        {{-- <img src="{{ $reservation->book->img }}" srcset="{{ asset('img/books/default.jpg') }}" class="img-thumbnail" > --}}
                        <h6 class="m-0 font-weight-bold text-primary">(BOOK COVER)</h6>
                    </div>
                    <div class="col-lg-7">
                        <h6 class="m-0 font-weight-bold text-primary">Book Name:</h6>
                        <p>{{ $reservation->book->name }}</p>
                        <h6 class="m-0 font-weight-bold text-primary">Author:</h6>
                        <p>{{ $reservation->book->author }}</p>
                        <h6 class="m-0 font-weight-bold text-primary">ISBN:</h6>
                        <p>{{ $reservation->book->isbn }}</p>
                        <h6 class="m-0 font-weight-bold text-primary">Category - Subject:</h6>
                        <p>{{ $reservation->book->category->name }} - {{ $reservation->book->subject->name }}</p>
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
  if(confirm('Are you sure you want to cancel the reservation?')){
    window.location = '/borrow/cancel/'+id;
  }
}

@if(session('success'))
    alert('{{ session('success') }}');
@endif

</script>


@endsection