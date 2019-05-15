<?php

namespace App\Http\Controllers\Library;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\Library;
use App\Logs;


use Hash;
use Auth;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:library');
    }
    
    

    public function profile()
    {
        return view('library.settings.profile');
    }

    public function info(Request $request)
    {
    	// Validating image
        if($request->image == "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCADIAMgDAREAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AJ/4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP//Z"){
            return redirect()->back()->with('error', 'Invalid image file.');
        }

        $librarian = Library::find(Auth::user()->id);
    	$librarian->fname = $request->fname;
    	$librarian->lname = $request->lname;
    	$librarian->mname = $request->mname;

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

            $librarian->img = $imageName;
        }

        $librarian->save();

        return redirect()->back()->with('success', 'Profile has been updated.');
    }

    public function username(Request $request)
    {
        $check = Library::where('username', $request->username)->where('id', '!=', Auth::user()->id)->get()->count();

        if($check != 0)
        {
            return redirect()->back()->with('error', 'Username already taken');
        }

        $update = Library::find(Auth::user()->id);
        $update->username = $request->username;
        $update->save();

        return redirect()->back()->with('success', 'Username has been updated.');
    }

    public function password(Request $request)
    {
        if($request->pass != $request->cpass){
            return redirect()->back()->withInput()->with('error', 'Password mismatch');
        }

        if(Hash::check($request->old, Auth::user()->password) == false){
            return redirect()->back()->with('error', 'Wrong password.');
        }

        $update = Library::find(Auth::user()->id);
        $update->password = Hash::make($request->pass);
        $update->save();

        return redirect()->back()->with('success', 'Password has been updated');
    }

    public function logs()
    {
        $logs = Logs::all();

        return view('library.settings.logs')->with('logs', $logs);
    }
}
