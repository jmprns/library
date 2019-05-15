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
Profile
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
				<form method="POST" action="/borrow/settings/info">

					@csrf

					<div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="profile-lname"><strong>Last Name</strong></label>
                            <input type="text" class="form-control" id="profile-lname" name="lname" value="{{ Auth::user()->lname }}" required>
                            
                        </div>
                        <div class="form-group col-md-5">
                            <label for="profile-fname"><strong>First Name</strong></label>
                            <input type="text" class="form-control" id="profile-fname" name="fname" value="{{ Auth::user()->fname }}" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="profile-mname"><strong>M.I.</strong></label>
                            <input type="text" class="form-control" id="profile-mname" name="mname" value="{{ Auth::user()->mname }}" required>
                        </div>
                    </div>

					<div class="form-group">
						<label for="book-name"><strong>Image</strong></label>
						<input type="hidden" id="crop-image" value="" name="image">
                    	<input type="file" name="upload_image" id="upload_image" accept="image/*" data-buttonbefore="true" class="filestyle">
					</div>

					<div class="form-group">
					   <button type="submit" class="btn btn-primary">Update</button>
				    </div>

				</form>
			</div>
		</div>
	</div>

	<div class="col-lg-5">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Avatar</h6>
			</div>
			<div class="card-body">
				<img id="edit-book-image-show" src="{{ asset('img/avatar') }}/{{ Auth::user()->img }}" width="250px" height="250px" class="mx-auto d-block img-thumbnail">
			</div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Credentials</h6>
            </div>
            <div class="card-body">
                
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="profile-username"><strong>LRN/ID</strong></label>
                            <input readonly type="text" class="form-control" id="profile-username" name="username" value="{{ Auth::user()->username }}" required>
                            
                        </div>
                       
                    </div>
               
                <hr>

                <form method="POST" action="/borrow/settings/password">
                    @csrf
                    <div class="form-group">
                        <label for="book-name"><strong>Old Password</strong></label>
                        <input class="form-control" type="password" placeholder="Old Password" name="old" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="book-category"><strong>New Password</strong></label>
                            <input type="password" class="form-control" id="book-stocks" name="pass" value="{{ old('pass') }}" required>
                            
                        </div>
                        <div class="form-group col-md-6">
                            <label for="book-stocks"><strong>Confirm Password</strong></label>
                            <input type="password" class="form-control" id="book-stocks" name="cpass" value="{{ old('cpass') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                       <button type="submit" class="btn btn-primary">Update</button>
                    </div>


                </form>
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
            width:150,
            height:150,
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

<script type="text/javascript">
    @if(session('success'))
        alert('{{ session('success') }}');
    @endif

    @if(session('error'))
        alert('{{ session('error') }}');
    @endif
</script>

@endsection