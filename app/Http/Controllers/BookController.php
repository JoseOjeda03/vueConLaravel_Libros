<?php

namespace App\Http\Controllers;
use App\Models\Author;

use Inertia\Inertia;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $books = Book::all();


            return Inertia::render('Books/Index', [
                'books'=> Book::paginate(10)
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return Inertia::render('Books/Create',[
            'authors'=> Author::all()
         ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
  
        $request->validate([
            'isbn'=> 'required|max:13',
            'description'=> 'required|max:200',
            'title'=> 'required|max:100',
            'publisher'=> 'required|max:100',
            'release_date'=> 'required|date',
            'pages'=> 'required|numeric',
            'image'=>'required|file|mimes:png,jpg,gif'
          
        ]);
        $book = Book::create($request->all());

        
        if($request->hasFile('image')) {
           
            $imgName=microtime(true).'.'.$request->file('image')->getClientOriginalExtension();

            $request->file('image')->storeAs('public/img',$imgName);
            $book->image = '/img/'.$imgName;
            $book->save();
            

        }
        return redirect('books/create')->with('success','Book created');


    }

    public function updateBook(Request $request){

        $request->validate([
            'isbn'=> 'required|max:13',
            'description'=> 'required|max:200',
            'title'=> 'required|max:100',
            'publisher'=> 'required|max:100',
            'release_date'=> 'required|date',
            'pages'=> 'required|numeric',
            'id'=>'required|numeric'
          
        ]);
        $book = Book::find($request->id);

        $book->update($request->input());
        if($request->hasFile('image')) {
            Storage::disk('public')->delete($book->image);
            $imgName=microtime(true).'.'.$request->file('image')->getClientOriginalName();

            $request->file('image')->storeAs('public/img', $imgName);
            $book->image = '/img/'.$imgName;
            $book->save();

        }
        
        return redirect('books/')->with('success','Book update');


    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return Inertia::render('Books/Show', [
            'book'=> $book, 'authors'=>$book->authors
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return Inertia::render('Books/Edit',[
            'authors'=> Author::all(),
            'book'=> $book,
            'authorsOfBook'=> $book->authors
         ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('books')->with('success','Book deleted');
    }
}
