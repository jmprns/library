<?php

namespace App\Http\Controllers\Library;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Book;
use App\Borrow;
use App\Reservation;

class DashboardController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:library');
    }

    public function index()
    {
    	$count['books'] = Book::count();
    	$count['borrow1'] = Borrow::where('stat', 0)->count();
    	$count['borrow2'] = Borrow::where('stat', 1)->count();
    	$count['pending'] = Reservation::where('status', 1)->count();
		return view('library.dashboard')->with('count', $count);
    }
}
