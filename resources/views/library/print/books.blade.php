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
    <h3 class="text-center">Book List</h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Author Name</th>
          <th>Category</th>
          <th>Genre</th>
          <th>Copies</th>
          <th>Lost</th>
        </tr>
      </thead>
      <tbody>
        @php($x = 1)
        @foreach($books as $book)
        @php($bac = $book->accession)
          <tr>
            <td>{{ $x++ }}</td>
            <td>{{ $book->name }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->category->name }}</td>
            <td>{{ $book->subject->name }}</td>
            <td>{{ $book->accession->count() }}</td>
            <td>{{ $bac->where('status', 2)->count() }}</td>
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
