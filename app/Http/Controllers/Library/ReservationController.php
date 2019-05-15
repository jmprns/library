<?php

namespace App\Http\Controllers\Library;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Reservation;
use App\Book;
use App\Accession;
use App\Borrow;
use App\Notification;
use App\Logs;

use Auth;

class ReservationController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:library');
    }

    public function index()
    {
    	$reservations = Reservation::with('book', 'borrow')->orderBy('id', 'desc')->get();
    	return view('library.reservation.list')
    			->with('reservations', $reservations);
    }

    public function status($status)
    {

        switch ($status) {
            case 'pending':
                $reservations = Reservation::with('book', 'borrow')->where('status', '1')->orderBy('id', 'desc')->get();
                $stats = 'Pending Status';
            break;

            case 'cancelled':
                $reservations = Reservation::with('book', 'borrow')->where('status', '0')->orWhere('status', '7')->orderBy('id', 'desc')->get();
                $stats = 'Cancelled Status';
            break;

            case 'approved':
                $reservations = Reservation::with('book', 'borrow')->where('status', '2')->orderBy('id', 'desc')->get();
                $stats = 'Approved Status';
            break;

            case 'dissaproved':
                $reservations = Reservation::with('book', 'borrow')->where('status', '6')->orderBy('id', 'desc')->get();
                $stats = 'Disapproved Status';
            break;

            case 'fetched':
                $reservations = Reservation::with('book', 'borrow')->where('status', '3')->orderBy('id', 'desc')->get();
                $stats = 'Borrowed Status';
            break;

            case 'lost':
                $reservations = Reservation::with('book', 'borrow')->where('status', '8')->orderBy('id', 'desc')->get();
                $stats = 'Book Lost Status';
            break;

            case 'returned':
                $reservations = Reservation::with('book', 'borrow')->where('status', '4')->orderBy('id', 'desc')->get();
                $stats = 'Returned Status';
            break;
            
            default:
               return abort(404);
            break;
        }

        
        return view('library.reservation.status')
                ->with('reservations', $reservations)
                ->with('stats', $stats)
                ->with('print', $status);
    }

    public function print($status)
    {

        switch ($status) {

            case 'all':

            $rss = Reservation::all();

            return view('library.print.all')->with('rss', $rss);



            break;

            case 'pending':

                $reservations = Reservation::with('book', 'borrow')->where('status', '1')->orderBy('id', 'desc')->get();
                $stats = 'Pending Status';

                return view('library.print.pending')
                        ->with('rss', $reservations)
                        ->with('stats', $stats);

            break;

            case 'cancelled':
                $reservations = Reservation::with('book', 'borrow')->where('status', '0')->orWhere('status', '7')->orderBy('id', 'desc')->get();
                $stats = 'Cancelled Status';

                return view('library.print.cancelled')
                        ->with('rss', $reservations)
                        ->with('stats', $stats);
            break;

            case 'approved':
                $reservations = Reservation::with('book', 'borrow')->where('status', '2')->orderBy('id', 'desc')->get();
                $stats = 'Approved Status';

                return view('library.print.approve')
                        ->with('rss', $reservations)
                        ->with('stats', $stats);


            break;

            case 'dissaproved':
                $reservations = Reservation::with('book', 'borrow')->where('status', '6')->orderBy('id', 'desc')->get();
                $stats = 'Disapproved Status';

                return view('library.print.disapproved')
                        ->with('rss', $reservations)
                        ->with('stats', $stats);
            break;

            case 'fetched':
                $reservations = Reservation::with('book', 'borrow')->where('status', '3')->orderBy('id', 'desc')->get();
                $stats = 'Fetched Status';

                return view('library.print.fetched')
                        ->with('rss', $reservations)
                        ->with('stats', $stats);
            break;

            case 'lost':
                $reservations = Reservation::with('book', 'borrow')->where('status', '8')->orderBy('id', 'desc')->get();
                $stats = 'Book Lost Status';

                return view('library.print.lost')
                        ->with('rss', $reservations)
                        ->with('stats', $stats);
            break;

            case 'returned':
                $reservations = Reservation::with('book', 'borrow')->where('status', '4')->orderBy('id', 'desc')->get();
                $stats = 'Returned Status';
                return view('library.print.returned')
                        ->with('rss', $reservations)
                        ->with('stats', $stats);
            break;

            case 'registered':

                $borrows = Borrow::where('stat', 1)->get();

                return view('library.print.registered')
                        ->with('borrows', $borrows);

            break;

            case 'books':

                $books = Book::all();
                return view('library.print.books')
                        ->with('books', $books);

            break;

            case 'logs':

                $logs = Logs::all();
                return view('library.print.log')
                        ->with('logs', $logs);

            break;
            
            default:
               return abort(404);
            break;
        }

        
    }



    public function view($id)
    {
        $reservation = Reservation::with('book.category','book.subject', 'borrow', 'library', 'accession')->where('id', $id)->get()->first();

        $accessions = Accession::where('book_id', $reservation->book->id)->where('status', '0')->get();
        return view('library.reservation.view')
                ->with('accessions', $accessions)
                ->with('reservation', $reservation);
    }

    public function approve(Request $request)
    {
        if($request->app_des == 2){

            $res = Reservation::find($request->res_id);
            $res->status = 6;
            $res->approve_by = Auth::user()->id;
            $res->approve_date = time();
            $res->save();

            Notification::create([
                'notif' => "Your request reservation with #RN-{$res->rn} has been disapproved.",
                'borrow_id' => $res->borrow_id,
                'status' => 6
            ]);

            return redirect()->back()->with('success', 'Reservation has been disapproved.');
        }else{

            $requestDay = stringToTime($request->reservation_days);

            $res = Reservation::find($request->res_id);
            $res->acc_id = $request->accession;
            $res->status = 2;
            $res->approve_by = Auth::user()->id;
            $res->approve_date = time();
            $res->end = $requestDay;
            $res->save();

            Notification::create([
                'notif' => "Your request reservation with #RN-{$res->rn} has been approved. You can now get the book in the library.",
                'borrow_id' => $res->borrow_id,
                'status' => 2
            ]);

            return redirect()->back()->with('success', 'Reservation has been approved.');

        }
    }

    public function cancelReservation($id)
    {
        $res = Reservation::find($id);
        $res->status = 7;
        $res->approve_by = Auth::user()->id;
        $res->save();

        Notification::create([
                'notif' => "Your request reservation with #RN-{$res->rn} has been cancelled by librarian.",
                'borrow_id' => $res->borrow_id,
                'status' => 7
            ]);

        return redirect()->back()->with('success', 'Reservation has been cancelled.');
    }

    public function fetchReservation($id)
    {
        $res = Reservation::find($id);

        $acc = Accession::find($res->acc_id);
        $acc->status = 1;
        $acc->save();

        $res->status = 3;
        $res->start = time();
        $res->save();

        $book = Book::find($res->book_id);
        $book->stocks = (int)$book->stocks - 1;
        $book->save();

        Notification::create([
                'notif' => "Your reservation with #RN-{$res->rn} has been fetched. Return the book before due date to avoid penalties.",
                'borrow_id' => $res->borrow_id,
                'status' => 3
            ]);

        return redirect()->back()->with('success', 'Reservation has been marked as fetched.');

    }

    public function lostBook($id)
    {
        $res = Reservation::find($id);
        $res->status = 8;
        $res->returned = time();
        $res->save();

        $acc = Accession::find($res->acc_id);
        $acc->status = 2;
        $acc->save();

        Notification::create([
                'notif' => "Your reservation with #RN-{$res->rn} has been marked as lost.",
                'borrow_id' => $res->borrow_id,
                'status' => 8
            ]);

        return redirect()->back()->with('success', 'Book has been marked as lost.');

    }

    public function return($id)
    {
        $res = Reservation::find($id);
        $res->returned = time();
        $res->status = 4;
        $res->save();

        $book = Book::find($res->book_id);
        $book->stocks = (int)$book->stocks + 1;
        $book->save();

        $acc = Accession::find($res->acc_id);
        $acc->status = 0;
        $acc->save();

        Notification::create([
                'notif' => "Your reservation with #RN-{$res->rn} has been complete.",
                'borrow_id' => $res->borrow_id,
                'status' => 4
            ]);

        return redirect()->back()->with('success', 'Reservation complete.');
    }

    public function walkin()
    {
        $borrows = Borrow::where('stat', '1')->get();
        $books = Book::with('category', 'subject')->get();
        return view('library.reservation.walkin')
                ->with('borrows', $borrows)
                ->with('books', $books);
    }

    public function walkinForm($student, $id)
    {
        $accessions = Accession::where('book_id', $id)->where('status', '0')->get();
        $book = Book::find($id);
        $borrow = Borrow::find($student);


        return view('library.reservation.walkin2')
                ->with('accessions', $accessions)
                ->with('book', $book)
                ->with('borrow', $borrow);
    }

    public function walkinPost(Request $request)
    {
        $resDay =  stringToTime($request->reservation_day);
        $res = Reservation::create([
            'rn' => time().unique_int(),
            'type' => 1,
            'borrow_id' => $request->borrow_id,
            'book_id' => $request->book_id,
            'acc_id' => $request->accession,
            'reserve_date' => time(),
            'approve_date' => time(),
            'approve_by' => Auth::user()->id,
            'start' => time(),
            'end' => $resDay,
            'notes' => '',
            'status' => 3
        ]);

        $book = Book::find($request->book_id);
        $book->stocks = $book->stocks - 1;
        $book->save();

        $acc = Accession::find($request->accession);
        $acc->status = 1;
        $acc->save();

        return redirect('/library/reservation/view/'.$res->id)->with('success', 'Borrow success');
    }
}
