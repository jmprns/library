<?php

namespace App\Http\Controllers\Borrow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Borrow;

use Hash;

class ActivateController extends Controller
{
    public function index()
    {
        return view('borrow.activate.search');
    }

    public function search(Request $request)
    {
    	$find = Borrow::where('username', $request->username)->get()->first();

    	if(!$find){

    		$message['header'] = 'Error';
    		$message['content'] = 'The LRN/ID you request to activate is not found in our database. Please ask the librarian for assistance.';
    		return view('borrow.activate.handlr')->with('message', $message);

    	}

    	if($find->stat == 1){
    		$message['header'] = 'Error';
    		$message['content'] = 'The LRN/ID you request is already activated. Please type another LRN/ID';
    		return view('borrow.activate.handlr')->with('message', $message);
    	}

    	return view('borrow.activate.activate')->with('bid', $find->id);
        
    }

    public function activate(Request $request)
    {

    	$borrow = Borrow::find($request->bid);

    	$borrow->password = Hash::make($request->pass);

    	$borrow->stat = 1;

    	$borrow->save();

    	$message['header'] = 'Success';
    	$message['content'] = 'Your account has been successfully activated.';

    	return view('borrow.activate.handlr')->with('message', $message);

    }

}
