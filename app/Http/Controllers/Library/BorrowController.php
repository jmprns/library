<?php

namespace App\Http\Controllers\Library;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Borrow;
use App\Reservation;

class BorrowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:library');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $borrows = Borrow::where('stat', '0')->get();
        return view('library.borrower.pre-list')->with('borrows', $borrows);
    }

    public function list()
    {
        $borrows = Borrow::where('stat', '1')->get();
        return view('library.borrower.list')->with('borrows', $borrows);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $borrow = Borrow::find($id)->delete();
        $res = Reservation::where('borrow_id', $id)->delete();

        return redirect()->back()->with('success', 'Borrower has been deleted.');
    }

    /**
     * Activate the specific borrow
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $borrow = Borrow::find($id);
        $borrow->stat = 1;
        $borrow->save();

        return redirect()->back()->with('success', 'Borrower\'s account has been activated.');

    }
}
