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
Edit Book
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
				<h6 class="m-0 font-weight-bold text-primary">Edit Information</h6>
			</div>
			<div class="card-body">
				<form method="POST" action="/library/books/update">

					@csrf
					<input type="hidden" name="id" value="{{ $book->id }}">

					<div class="form-group">
						<label for="book-name"><strong>Book Title</strong></label>
						<input type="text" class="form-control" id="book-edit-name" placeholder="Name/Title" name="name" value="{{ $book->name }}" required>
					</div>

					<div class="form-group">
						<label for="book-name"><strong>Author</strong></label>
						<input type="text" class="form-control" id="book-edit-author" placeholder="Author" name="author" value="{{ $book->author }}" required>
					</div>

					<div class="form-group">
						<label for="book-name"><strong>ISBN</strong></label>
						<input type="text" class="form-control" id="book-edit-isbn" placeholder="ISBN" name="isbn" value="{{ $book->isbn }}" required>
					</div>

					<div class="form-group">
						<label for="book-name"><strong>Genre - Category</strong></label>
						<select id="book-category" class="form-control" name="category" required>
                            @foreach($subjects as $subject)
								<option @if($subject->id == $book->sub_id) selected @endif value="{{ $subject->category->id }}__{{ $subject->id }}">{{ $subject->name }} - {{ $subject->category->name }}</option>
                            @endforeach
						</select>
					</div>

                    <div class="form-group">
                        <label for="book-name"><strong>Subject</strong></label>
                        <select id="book-category" class="form-control" name="subject" required>
                            @foreach($realSub as $rs)
                                <option @if($book->sub2_id == $rs->id) selected @endif value="{{ $rs->id }}">{{ $rs->name }}</option>
                            @endforeach
                        </select>
                    </div>

					<div class="form-group">
						<label for="book-name"><strong>Image</strong></label>
						<input type="hidden" id="crop-image" value="" name="image">
                    	<input type="file" name="upload_image" id="upload_image" accept="image/*" data-buttonbefore="true" class="filestyle">
					</div>

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
				<h6 class="m-0 font-weight-bold text-primary">Book Image</h6>
			</div>
			<div class="card-body">
				<img id="edit-book-image-show" src="{{ asset('img/books') }}/{{ $book->img }}" width="312px" height="500px" class="mx-auto d-block img-thumbnail">
			</div>
		</div>
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


<script type="text/javascript">
	$(document).ready(function(){

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
            $("#edit-book-image-show").attr("src", response);
            $('#uploadimageModal').modal('toggle');
        })
    });

});
</script>


@endsection