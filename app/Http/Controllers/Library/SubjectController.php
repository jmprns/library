<?php

namespace App\Http\Controllers\Library;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\Subject;
use App\Book;

class SubjectController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:library');
    }

    public function index($id)
    {

    	$categories = Category::all();


    	if($id == 0){

    		$subjects = Subject::with('category')->get();

    		return view('library.settings.subject')
    				->with('categories', $categories)
    				->with('subjects', $subjects)
    				->with('catd', $id);

    	}else{

    		$subjects = Subject::with('category')->where('cat_id', $id)->get();

    		return view('library.settings.subject')
    				->with('categories', $categories)
    				->with('subjects', $subjects)
    				->with('catd', $id);

    	}
    	
    }

    public function store(Request $request)
    {
    	$sub = Subject::create([
    		'name' => $request->name,
    		'cat_id' => $request->category
    	]);

    	return redirect()->back()->with('success', 'Subject has been added.');
    }

    public function destroy($id)
    {
    	$subject = Subject::find($id)->delete();
        $books = Book::where('sub_id', $id)->delete();

    	return redirect()->back()->with('success', 'Subject has been deleted.');
    }

    public function update(Request $request)
    {
        $update = Subject::find($request->id);
        $update->name = $request->name;
        $update->cat_id = $request->category;
        $update->save();

        return redirect()->back()->with('success', 'Subject has been updated.');
    }
}
