<?php

namespace App\Http\Controllers\Library;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Category;
use App\Book;

use Auth;

use App\Logs;

class CategoryController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth:library');
    }

    public function index()
    {
    	$categories = Category::all();
    	return view('library.settings.category')->with('categories', $categories);
    }

    public function store(Request $request)
    {

    	$create = Category::create([
    		'name' => $request->name,
            'hex' => $request->hex
    	]);

        Logs::create([
            'action' => "Create category - {$request->name}",
            'lib_id' => Auth::user()->id
        ]);

    	return redirect()->back()->with('success', 'Category has been added.');

    }

    public function destroy($id)
    {
    	$category = Category::find($id);
        $books = Book::where('cat_id', $id)->delete();

        Logs::create([
            'action' => "Delete category - {$category->name}",
            'lib_id' => Auth::user()->id
        ]);

        $category->delete();

    	return redirect()->back()->with('success', 'Category has been deleted.');
    }

    public function update(Request $request)
    {
        $category = Category::find($request->cat_id);

        $category->name = $request->name;
        $category->hex = $request->hex;
        $category->update();

        Logs::create([
            'action' => "Update category - {$category->name}",
            'lib_id' => Auth::user()->id
        ]);

        return redirect()->back()->with('success', 'Category has been updated.');
    }
}
