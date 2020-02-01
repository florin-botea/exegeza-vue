<?php
namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use \App\Repositories\Eloquent\Maps\BibleMap;
use \App\Repositories\Eloquent\Maps\BookMap;

class VerseRepository extends MainBibleRepository
{
	public function get(string $version, string $book, int $chapter_index)
	{
		return $this->fetch($version, $book, $chapter_index);
	}
	
	public function store(string $version, string $book, int $chapter_index, $data){
		$db = $this->fetchFromDB($version, $book, $chapter_index);
		$version = $db['versions']['data']->firstWhere('slug', $version) ?? abort(404);
		$book = $db['books']['data']->firstWhere('slug', $book) ?? abort(404);
		$chapter = $db['chapters']['data']->firstWhere('index', $chapter_index) ?? abort(404);		
		
		$table_name = 'v_' . $version->id . '_verses';
		$verses = $this->parseText($data['regexp'], $data['texts']);
		$verses = $this->integrateVerses($book, $chapter, $verses);

		DB::table($table_name)->where(['book_id' => $book->id, 'chapter_id' => $chapter->id])->delete();
		DB::table($table_name)->insert($verses);

		Cache::forget('app_'.$version->slug.$book->slug.$chapter_index);
	}
	
	public function update($id, $data){
		//
	}
	
	public function destroy(){
		//
	}
	
	public function parseText($regex, $text){
		return preg_split($regex, $text);
	}
	
	public function integrateVerses(\App\Book $book, \App\Chapter $chapter, $verses){
		$stack = [
			[
				//'global_id' => ($book->index*1000000) + ($chapter->index*1000),
				'book_id' => $book->id,
				//'book_index' => $book->index,
				'chapter_id' => $chapter->id,
				//'chapter_index' => $chapter->index,
				'index' => 0,
				'text' => $chapter->text
			]
		];
		for ($i=0;$i<count($verses);$i++){
			$stack[] = [
				//'global_id' => ($book->index*1000000) + ($chapter->index*1000) + $i+1,
				'book_id' => $book->id,
				//'book_index' => $book->index,
				'chapter_id' => $chapter->id,
				//'chapter_index' => $chapter->index,
				'index' => $i + 1,
				'text' => $verses[$i]
			];
		}
		return $stack;
	}
}