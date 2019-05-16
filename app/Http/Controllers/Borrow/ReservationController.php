<?php

namespace App\Http\Controllers\Borrow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Book;
use App\Reservation;
use App\RealSub;

use Auth;

class ReservationController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:borrow');
    }
    public function book()
    {
    	$books = Book::with('category', 'subject', 'accession')->inRandomOrder()->paginate(12);
    	return view('borrow.list')->with('books', $books);
    }

    public function subject($id)
    {
        $subjectTitle = RealSub::find($id);
        $books = Book::with('category', 'subject')->where('sub2_id', $id)->inRandomOrder()->paginate(12);
        return view('borrow.list')->with('books', $books)->with('subjectTitle', $subjectTitle);
    }

    public function list()
    {
        $reservations = Reservation::with('book')->where('borrow_id', Auth::user()->id)->orderBy('id', 'desc')->get();
    	return view('borrow.reserve-list')->with('reservations', $reservations);
    }

    public function form($id)
    {
        $checkR = Reservation::where('borrow_id', Auth::user()->id)
                    ->where('status', 1)
                    ->orWhere('status', 2)
                    ->orWhere('status', 3)
                    ->orWhere('status', 5)
                    ->get()
                    ->count();

        if($checkR != 0){
            return redirect()->back()->with('error', 'Cannot reserve this book.');
        }

    	$book = Book::find($id);

    	if(!$book){
    		return abort(404);
    	}



    	return view('borrow.reserve-form')
    			->with('book', $book);
    }

    public function reserve(Request $request)
    {
        Reservation::create([
            'rn' => time().unique_int(),
            'type' => 0,
            'borrow_id' => Auth::user()->id,
            'book_id' => $request->book_id,
            'reserve_date' => time(),
            'notes' => $request->notes
        ]);

        return redirect('/borrow/reserve')->with('success', 'Reservation success. Waiting for approval of the librarian.');
    }

    public function cancel($id)
    {
        $res = Reservation::find($id);
        $res->status = 0;
        $res->save();

        return redirect('/borrow/reserve')->with('success', 'Reservation has been canceled.');
    }

    public function view($id)
    {
        $reservation = Reservation::with('book.category','book.subject', 'borrow', 'library')->where('id', $id)->get()->first();

        return view('borrow.reserve-view')
                ->with('reservation', $reservation);
    }

    public function search(Request $request)
    {
        $searchQuery = "%".$request->search_query."%";

        $books = Book::where('name', 'like', $searchQuery)
                    ->orWhere('author', 'like', $searchQuery)
                    ->paginate(12);

        $count = $books->count();

        return view('borrow.list')->with('books', $books)
                    ->with('search', $request->search_query)
                    ->with('count', $count);

    }
}
