@extends('library.layout.app')

{{-- HTML Title --}}
@section('html-title')

@endsection


{{-- Css --}}
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/croppie/croppie.css') }}">
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Page Title --}}
@section('page-title')
Add a book
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
              <form method="POST" action="/library/books/store">
                @csrf
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="book-name"><strong>Book Title</strong></label>
						<input type="text" class="form-control" id="book-name" placeholder="Name" name="name" value="{{ old('name') }}" required>
					</div>
					<div class="form-group col-md-3">
						<label for="book-author"><strong>Author First Name</strong></label>
						<input type="text" class="form-control" id="book-author" placeholder="Author First Name" name="authorf" value="{{ old('authorf') }}" required>
					</div>
                    <div class="form-group col-md-3">
                        <label for="book-author"><strong>Author Last Name</strong></label>
                        <input type="text" class="form-control" id="book-author" placeholder="Author Last Name" name="authorl" value="{{ old('authorl') }}" required>
                    </div>
				</div>

				<div class="form-group">
					<label for="book-isbn"><strong>ISBN Number</strong></label>
					<input type="text" class="form-control" id="inputAddress" placeholder="ISBN Number" name="isbn" value="{{ old('isbn') }}" required>
				</div>

				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="book-category"><strong>Category - Genre</strong></label>
						<select id="book-category" class="form-control" name="category" required>
                            @foreach($subjects as $subject)
							<option value="{{ $subject->category->id }}__{{ $subject->id }}">{{ $subject->name }} - {{ $subject->category->name }}</option>
                            @endforeach
						</select>
					</div>

                    <div class="form-group col-md-6">
                        <label for="book-category"><strong>Subject</strong></label>
                        <select id="book-subject" class="form-control" name="subject" required>
                           @foreach($realSubs as $rS)
                           <option value="{{ $rS->id }}">{{ $rS->name }}</option>
                           @endforeach
                        </select>
                    </div>
				</div>

				<div class="form-row">
					<div class="form-group col-md-6">
				    	<label for="book-isbn"><strong>Image</strong></label>
					<input type="hidden" id="crop-image" value="" name="image">
                    <input type="file" name="upload_image" id="upload_image" accept="image/*" data-buttonbefore="true" class="filestyle">
				    </div>
					
				</div>

				<div class="form-group">
					<button type="reset" class="btn btn-warning">Reset</button>
					<button type="submit" class="btn btn-primary">Add</button>
				</div>
              </form>
            </div>
          </div>

<!-- Modal Image Cropper -->
<div id="uploadimageModal" class="modal" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
       <div class="col-md-12 text-center">
        <div id="image_demo"></div>
       </div>
    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success crop_image">Crop</button>
        </div>
     </div>
    </div>
</div><!-- /.modal -->
@endsection


{{-- Js Script --}}
@section('js')
<script src="{{ asset('vendor/croppie/croppie.min.js') }}"></script>
<script src="{{ asset('vendor/croppie/exif.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>


<script type="text/javascript">
$(document).ready(function(){

    $('#book-category').select2();

    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width:125,
            height:200,
            type:'square' //circle
        },
        boundary:{
            width:300,
            height:300
        }
    });

    $('#upload_image').on('change', function(){
        var reader = new FileReader();
        reader.onload = function (event) {
        $image_crop.croppie('bind', {
            url: event.target.result
        }).then(function(){
          console.log('jQuery bind complete');
        });
        }
        reader.readAsDataURL(this.files[0]);
        $('#uploadimageModal').modal('show');
    });

    $('.crop_image').click(function(event){
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport',
            format: 'jpeg'
        }).then(function(response){
            console.log(response);
            $('#crop-image').val(response);
            $('#uploadimageModal').modal('toggle');
        })
    });

});
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