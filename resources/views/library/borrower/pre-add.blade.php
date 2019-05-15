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
Add a borrower
@endsection

{{-- Page Title Sub --}}
@section('page-title-sub')

@endsection


{{-- Main Content --}}
@section('main-content')
<div class="card shadow mb-4">
            <div class="card-header py-3">
            	<h6 class="m-0 font-weight-bold text-primary">Fill up the form with correct corresponding value</h6>
            </div>
            <div class="card-body">
              <form method="POST" action="/library/borrow/pre/store">
                @csrf
				<div class="form-row">
					<div class="form-group col-md-5">
						<label for="book-name"><strong>Last Name</strong></label>
						<input type="text" class="form-control" id="book-name" placeholder="Last Name" name="lname" value="{{ old('lname') }}" required>
					</div>
					<div class="form-group col-md-5">
						<label for="book-author"><strong>First Name</strong></label>
						<input type="text" class="form-control" id="book-author" placeholder="First Name" name="fname" value="{{ old('fname') }}" required>
					</div>
                    <div class="form-group col-md-2">
                        <label for="book-author"><strong>M.I.</strong></label>
                        <input type="text" class="form-control" id="book-author" placeholder="M.I." name="mname" value="{{ old('mname') }}">
                    </div>
				</div>

				<div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="book-author"><strong>LRN/ID</strong></label>
                        <input type="text" class="form-control" id="book-author" placeholder="LRN or ID" name="username" value="{{ old('username') }}" required>
                    </div>
					<div class="form-group col-md-6">
						<label for="book-category"><strong>Department - Year</strong></label>
						<select id="book-category" class="form-control" name="dept" required>
                            <option>Grade 7</option>
                            <option>Grade 8</option>
                            <option>Grade 9</option>
                            <option>Grade 10</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<button type="reset" class="btn btn-warning">Reset</button>
					<button type="submit" class="btn btn-primary">Add</button>
				</div>
              </form>
            </div>
          </div>

@endsection


{{-- Js Script --}}
@section('js')

<script type="text/javascript">

</script>

@if(session('error'))
<script type="text/javascript">
    alert('{{ session('error') }}');
</script>
@endif

@if(session('success'))
<script type="text/javascript">
    alert('{{ session('success') }}');
</script>
@endif

@endsection