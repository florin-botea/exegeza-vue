<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests\BibleBookPost;
use \App\Repositories\Eloquent\BibleRepository;
use \App\Repositories\Eloquent\BookRepository;
use \App\Repositories\Eloquent\ChapterRepository;
use \App\Repositories\Eloquent\VerseRepository;
use Illuminate\Support\Facades\DB;

class BibleSearchController extends Controller
{
	private $bibleRepository;
	private $bookRepository;
	private $chapterRepository;
	
	public function __construct(
		BibleRepository $bibleRepository,
		BookRepository $bookRepository,
		ChapterRepository $chapterRepository
	){
		$this->bibleRepository = $bibleRepository;
		$this->bookRepository = $bookRepository;
		$this->ChapterRepository = $chapterRepository;
	}
	
    public function index(Request $req)
    {
		if (! $req->words || $req->words == '' || $req->words === null || strlen($req->words) < 3 ){
			return redirect('/traduceri');
		}
		$bible = \App\Bible::where('slug', $req->translation)->firstOrFail();
		$table_name = 'v_'.$bible->id.'_verses';
		
		$words = explode(' ', $req->words);
		if ( $req->flexibility === 'relative' ){
			$words = array_map( function($word){
				return strlen($word) > 5 ? substr($word, 1, -2) : $word;
			}, $words);
		}
		
		$query = DB::table($table_name);
		
		if ( $req->eager === 'all' ){//sa le contina pe toate
			foreach( $words as $word ){
				$query->where('text', 'like', '%'.$word.'%');
			}
		}
		elseif ( $req->eager === 'expression' ){
			$words = implode(' ', $words);
			$query->where($table_name.'.text', 'like', '%'.$word.'%');
		}
		else { //flexible
			foreach( $words as $i => $word ){
				$i === 0 ? $query->where($table_name.'.text', 'like', '%'.$word.'%') : $query->orWhere($table_name.'.text', 'like', '%'.$word.'%');
			}
		}
		if ( $req->book !== 'all' ){
			$book = \App\Book::where(['bible_id' => $bible->id, 'slug' => $req->book])->firstOrFail();
			$query->where($table_name.'.book_id', $book->id);
		}
		$query->join('books', $table_name.'.book_id', '=', 'books.id');
		$query->join('chapters', $table_name.'.chapter_id', '=', 'chapters.id')
			->select(['books.name as book_name', 'books.index as book_index', 'chapters.index as chapter_index', $table_name.'.index', $table_name.'.text']);
		$data = [
			'versions' => ['data'=>[], 'meta'=>[]],
			'verses' => $query->paginate(50)->withPath(request()->fullUrl())
			// [
				// 'data' => ,
				// 'meta' => []
			// ]
		];
		
		return view('search')->with(['data' => $data]);
		// ?words=&flexibility=option1&eager=option1&book=all&translation=NTR
		
		// version = req get version or versions all first
		// rule = cuv exact ? where text contains words. cuv cu aproximatie ? stirbesc din ele.
				// toate cuv ? explod words. ca si expresie ? words intregi. cel putin un cuv ? or condition dupa ce le explodez
    }
}
