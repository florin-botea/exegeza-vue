<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Validations\ValidBook;
use \App\Repositories\Eloquent\BookRepository;

class BookController extends Controller
{
	private $bookRepository;
	
	public function __construct(BookRepository $bookRepository){
		$this->authorizeResource(\App\Book::class, 'book');
		$this->bookRepository = $bookRepository;
	}
	
    public function index(Request $req, string $version)
    {
		$data = $this->bookRepository->get($version);
		if ( $req->wantsJson() ){
			return response()->json($data);
		}
		return view('books')->with(['data' => $data]);
    }

    public function store(ValidBook $req, $v)
    {
		$this->bookRepository->store($v, $req->all());
		
		return back();
    }

    public function update(ValidBook $req, $version, $id)
    {
		$this->bookRepository->update($version, $id, $req->all());
		
		return back();
    }

    public function destroy(string $version, string $book)
    {
		$this->bookRepository->destroy($version, $book);
		
		return back();
    }
}
