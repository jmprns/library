<?php

namespace App\Http\Controllers\Borrow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Hash;

use App\Borrow;

class SettingsController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:borrow');
    }

    public function profile()
    {
    	return view('borrow.profile');
    }

    public function info(Request $request)
    {
    	// Validating image
        if($request->image == "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCADIAMgDAREAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AJ/4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP//Z"){
            return redirect()->back()->with('error', 'Invalid image file.');
        }

        $update = Borrow::find(Auth::user()->id);
        $update->fname = $request->fname;
    	$update->lname = $request->lname;
    	$update->mname = $request->mname;

    	if($request->image != '')
        {
        	//Image Decoding
            $image = $request->image;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = unique_string().".jpg";
            $destination = public_path()."/img/avatar/".$imageName;
            $actualImage = base64_decode($image);
            $move = file_put_contents($destination, $actualImage);

            $update->img = $imageName;
        }

        $update->save();

        return redirect()->back()->with('success', 'Profile has been updated.');


    }

    public function password(Request $request)
    {
    	if($request->pass != $request->cpass){
            return redirect()->back()->withInput()->with('error', 'Password mismatch');
        }

        if(Hash::check($request->old, Auth::user()->password) == false){
            return redirect()->back()->with('error', 'Wrong password.');
        }

        $update = Borrow::find(Auth::user()->id);
        $update->password = Hash::make($request->pass);
        $update->save();

        return redirect()->back()->with('success', 'Password has been updated');
    }
}
