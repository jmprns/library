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
    <h3 class="text-center">Registered Borrower</h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>LRN/ID</th>
          <th>Department</th>
        </tr>
      </thead>
      <tbody>
        @php($x = 1)
        @foreach($borrows as $borrow)
          <tr>
            <td>{{ $x++ }}</td>
            <td>{{ $borrow->lname }}, {{ $borrow->fname }}</td>
            <td>{{ $borrow->username }}</td>
            <td>{{ $borrow->dept }}</td>
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
