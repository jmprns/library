<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>BOOKLAT</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body>

<div class="row">
  <div class="col-lg-12">
    <h1 class="text-center">BOOKLAT</h1>
    <h3 class="text-center">Reservation - {{ $stats }}</h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <table class="table">
      <thead>
        <tr>
          <th>Date</th>
          <th>#RN</th>
          <th>Type</th>
          <th>Borrower Name</th>
          <th>Grade</th>
          <th>Book Title</th>
          <th>Book Author</th>
          <th>Approved Date</th>
          <th>Claimed Date</th>
          <th>Must Return Date</th>
          <th>Returned Date</th>
          <th>Approved By</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rss as $rs)
          <tr>
            <td>{{ date('F d, Y', $rs->reserve_date) }}</td>
            <td>{{ $rs->rn }}</td>
            <td>@if($rs->type == 0)ONLINE @else WALK-IN @endif</td>
            <td>{{ $rs->borrow->lname }}, {{ $rs->borrow->fname }}</td>
            <td>{{ $rs->borrow->dept }}</td>
            <td>{{ $rs->book->name }}</td>
            <td>{{ $rs->book->author }}</td>
            <td>@if($rs->approve_date == '') - @else {{ date('F d, Y', $rs->approve_date) }} @endif</td>
            <td>@if($rs->start == '') - @else {{ date('F d, Y', $rs->start) }} @endif</td>
            <td>@if($rs->end == '') - @else {{ date('F d, Y', $rs->end) }} @endif</td>
            <td>@if($rs->returned == '') - @else {{ date('F d, Y', $rs->returned) }} @endif</td>
            <td>
              @if(isset($rs->library->lname))
                @if($rs->approve_by == '') - 
                @else {{ $rs->library->lname }}, {{ $rs->library->fname }} 
                @endif
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>




<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script type="text/javascript">
  window.print();
</script>
</body>

</html>
