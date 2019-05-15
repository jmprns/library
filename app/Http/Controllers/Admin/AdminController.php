<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Library;

use Auth;
use Hash;

class AdminController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function home()
    {
    	$libs = Library::all();
    	return view('admin.home')->with('libs', $libs);
    }

    public function add()
    {
    	return view('admin.library-add');
    }

    public function store(Request $request)
    {
    	// Validating image
        if($request->image == "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCADIAMgDAREAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AJ/4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP//Z"){
            return redirect()->back()->withInput()->with('error', 'Invalid image file.');
        }

        $check = Library::where('username', $request->username)->get()->count();

        if($check != 0)
        {
            return redirect()->back()->withInput()->with('error', 'Username already taken');
        }

        if($request->pass != $request->cpass){
            return redirect()->back()->withInput()->with('error', 'Password mismatch');
        }

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
           
        }else{
        	$imageName = 'default.svg';
        }

        Library::create([
        	'fname' => $request->fname,
        	'lname' => $request->lname,
        	'mname' => $request->mname,
        	'username' => $request->username,
        	'password' => Hash::make($request->pass),
        	'img' => $imageName
        ]);

        return redirect()->back()->with('success', 'Librarian has been added.');


    }

    public function delete($id)
    {
        Library::find($id)->delete();
        return redirect()->back()->with('success', 'Librarian has been deleted.');

    }

    public function reset($id)
    {
        $update = Library::find($id);
        $update->password = Hash::make('library');
        $update->save();

        return redirect()->back()->with('success', 'Password has been set to default.');
    }
}
