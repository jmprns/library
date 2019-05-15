<?php

namespace App\Http\Controllers\BorrowAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Borrow;

use Hash;

class RegisterController extends Controller
{
    public function form()
    {
    	return view('borrow.auth.register');
    }

    public function submit(Request $request)
    {

    	$find = Borrow::where('username', $request->username)->get()->count();

    	if($find > 0){
    		return redirect()->back()->withInput()->with('error', 'LRN/ID is taken.');
    	}

    	if($request->pass !== $request->cpass){
    		return redirect()->back()->withInput()->with('error', 'Password mismatch.');
    	}

    	$create = Borrow::create([
    		'fname' => $request->fname,
    		'lname' => $request->lname,
    		'mname' => $request->mname,
    		'username' => $request->username,
    		'password' => Hash::make($request->pass),
    		'dept' => $request->dept,
    		'stat' => 0,
    	]);

    	return redirect('/borrow/login')->with('success', 'Your account will be review by the librarian for activation.');

    }
}
