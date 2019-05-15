<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Library System - Login</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6" style="display: flex; justify-content: center; align-items: center;">
                <img src="{{ asset('img/logo.png') }}" width="400px" height="400px">
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Sign Up</h1>
                    <p class="mb-4">
                      Fill up the form with correct corresponding value.
                    </p>
                  </div>






<form class="user" method="POST" action="{{ url('/borrow/signup') }}">

    @csrf

    <div class="form-row">

        <div class="form-group col-md-5">
            <label for="book-name"><strong>Last Name:</strong></label>
            <input type="text" class="form-control" id="book-name" placeholder="Last Name" name="lname" value="{{ old('lname') }}" required>
        </div>

        <div class="form-group col-md-5">
            <label for="book-author"><strong>First Name</strong></label>
            <input type="text" class="form-control" id="book-author" placeholder="First Name" name="fname" value="{{ old('fname') }}" required>
        </div>

        <div class="form-group col-md-2">
            <label for="book-author"><strong>M.I.</strong></label>
            <input type="text" class="form-control" id="book-author" placeholder="M.I." name="mname" value="{{ old('mname') }}" required>
        </div>

    </div>

    <div class="form-group">
        <label for="book-isbn"><strong>Department - Year</strong></label>
        <select name="dept" class="form-control">
          <option>Grade 7</option>
          <option>Grade 8</option>
          <option>Grade 9</option>
          <option>Grade 10</option>
          <option>Teacher</option>
        </select>
    </div>

    <div class="form-group">
        <label for="book-isbn"><strong>LRN/ID</strong></label>
        <input type="text" class="form-control" id="inputAddress" placeholder="LRN / ID" name="username" value="{{ old('username') }}" required>
    </div>

    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="book-name"><strong>Password</strong></label>
            <input type="password" class="form-control" id="book-name" placeholder="Password" name="pass" required>
        </div>

        <div class="form-group col-md-6">
            <label for="book-author"><strong>Confirm Password</strong></label>
            <input type="password" class="form-control" id="book-author" placeholder="Confirm Password" name="cpass" required>
        </div>

    </div>



<button type="submit" class="btn btn-primary btn-user btn-block">
Sign up
</button>
<hr>
<a href="/borrow/login" class="btn btn-success btn-user btn-block">
Return to Login Page
</a>
</form>

                  
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

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
    @if(session('error'))
      alert('{{ session('error') }}')
    @endif
  </script>

</body>

</html>
