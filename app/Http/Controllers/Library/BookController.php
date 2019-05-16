<?php

namespace App\Http\Controllers\Library;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use File;
use Auth;

use App\Category;
use App\Book;
use App\Subject;
use App\Logs;

use App\RealSub;
use App\Accession;
use App\Reservation;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:library');
    }
    
    public function index()
    {
        $books = Book::with('category', 'subject', 'accession')->get();
    	return view('library.book.index')
                ->with('books', $books);
    }

    public function add()
    {
    	$subjects = Subject::with('category')->get();
        $realSubs = RealSub::all();

    	return view('library.book.add')
    			->with('subjects', $subjects)
                ->with('realSubs', $realSubs);
    }

    public function store(Request $request)
    {

        if(Book::where('isbn', $request->isbn)->get()->count() != 0){
            return redirect()->back()->withInput()->with('error', 'Book already registered.');
        }

        // Validating image
        if($request->image == "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCADIAMgDAREAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AJ/4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP//Z"){
            return redirect()->back()->withInput()->with('error', 'Invalid image file.');
        }

        if($request->image == ""){

            $imageName = 'default.jpg';

           
        }else{

            //Image Decoding
            $image = $request->image;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = unique_string().".jpg";
            $destination = public_path()."/img/books/".$imageName;
            $actualImage = base64_decode($image);
            $move = file_put_contents($destination, $actualImage);

        }

        $explode = explode('__', $request->category);

        $book = Book::create([
            'name' => $request->name,
            'author' => $request->authorf." ".$request->authorl,
            'isbn' => $request->isbn,
            'cat_id' => $explode[0],
            'sub_id' => $explode[1],
            'sub2_id' => $request->subject,
            'stocks' => 0,
            'img' => $imageName
        ]);

        Logs::create([
            'action' => "Add a new book with ISBN: {$book->isbn}",
            'lib_id' => Auth::user()->id
        ]);



        return redirect('/library/books/add')->with('success', 'Book has been added.');
    }

    public function edit($id)
    {
        $book = Book::with('category')->where('id', $id)->get()->first();
        $subjects = Subject::with('category')->get();
        $categories = Category::all();
        $realSub = RealSub::all();

        return view('library.book.edit')
                ->with('categories', $categories)
                ->with('subjects', $subjects)
                ->with('realSub', $realSub)
                ->with('book', $book);
    }

    public function update(Request $request)
    {


        $book = Book::find($request->id);

        $book->name = $request->name;
        $book->author = $request->author;
        $book->isbn = $request->isbn;

        $x = explode('__', $request->category);


        $book->cat_id = $x[0];
        $book->sub_id = $x[1];
        $book->sub2_id = $request->subject;


        if($request->image !== NULL){

            //Image Decoding
            $image = $request->image;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = unique_string().".jpg";
            $destination = public_path()."/img/books/".$imageName;
            $actualImage = base64_decode($image);
            $move = file_put_contents($destination, $actualImage);

            $book->img = $imageName;
            
        }

        $book->save();

        Logs::create([
            'action' => "Update book with ISBN: {$book->isbn}",
            'lib_id' => Auth::user()->id
        ]);

        return redirect('/library/books/')->with('success', 'Book has been updated.');

    }

    public function delete($id)
    {
        $book = Book::find($id);

        $reservations = Reservation::where('book_id', $id)->delete();

        if($book->img !== 'default.jpg'){
            //Deleting the current image
            $image_path = public_path()."/img/books/".$book->img;
            File::delete($image_path);
        }

        Logs::create([
            'action' => "Delete book with ISBN: {$book->isbn}",
            'lib_id' => Auth::user()->id
        ]);

        $book->delete();


        return redirect('/library/books/')->with('success', 'Book has been deleted.');
    }

    public function catsub($id){

        $categories = Category::all();

        if($id == 0){
            $subjects = Subject::all();
        }else{
            $subjects = Subject::where('cat_id', $id)->get();
        }

        return view('library.book.catsub')
                ->with('categories', $categories)
                ->with('subjects', $subjects)
                ->with('catd', $id);
    }

    public function copy(Request $request)
    {
        $book = Book::find($request->book_id);
        return view('library.book.copy')
                ->with('book', $book)
                ->with('copy', $request->copy);
    }

    public function accession(Request $request)
    {
        $book = Book::find($request->bid);

        $count = 0;

        foreach($request->accession as $accession){
            $count++;
            Accession::create([
                'name' => $accession,
                'book_id' =>$request->bid
            ]);
        }

        $book->stocks = $count;
        $book->save();

        Logs::create([
            'action' => "Add accession for book with ISBN: {$book->isbn}",
            'lib_id' => Auth::user()->id
        ]);

        return redirect('/library/books')->with('success', 'Copies has been added.');
    }
}
