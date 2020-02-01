<?php
namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use \App\Repositories\Eloquent\Maps\BibleMap;
use \App\Repositories\Eloquent\Maps\BookMap;

class ChapterRepository extends MainBibleRepository
{
	public function get(string $version, string $book)
	{
		return $this->fetch($version, $book);
	}
	
	public function store(string $version, $book, $data)
	{
		$db = $this->fetchFromDB($version, $book);
		$version = $db['versions']['data']->firstWhere('slug', $version) ?? abort(404);
		$book = $db['books']['data']->firstWhere('slug', $book) ?? abort(404);
		Cache::forget('app_'.$version->slug.$book->slug);
		Cache::forget('app_'.$version->slug.$book->slug.$data['index']);
		
		$book->chapters()->create($data);
	}
	
	public function update(string $version, string $book, $chapter_index, $data){
		$db = $this->fetchFromDB($version, $book, $chapter_index);
		$version = $db['versions']['data']->firstWhere('slug', $version) ?? abort(404);
		$book = $db['books']['data']->firstWhere('slug', $book) ?? abort(404);
		$chapter = $db['chapters']['data']->firstWhere('index', $chapter_index) ?? abort(404);
		$chapter_id = $chapter->id;
		Cache::forget('app_'.$version->slug.$book->slug);
		Cache::forget('app_'.$version->slug.$book->slug.$chapter->index);
		
		$chapter->update([
			'index' => $data['index'],
			'text' => $data['text'],
		]);
		$table_name = 'v_' . $version->id . '_verses';
		DB::table($table_name)->where(['chapter_id' => $chapter_id, 'index' => 0])
			->update(['text' => $data['text']]);
	}
	
	public function destroy(string $version, string $book, int $chapter_index){
		$version = \App\Bible::where('slug', $version)->latest('id')->first();
		$book = \App\Book::where(['bible_id' => $version->id, 'slug' => $book])->latest('id')->first();
		$chapter = \App\Chapter::where(['book_id' => $book->id, 'index' => $chapter_index])->latest('id')->first();
		Cache::forget('app_'.$version->slug.$book->slug);
		Cache::forget('app_'.$version->slug.$book->slug.$chapter->index);
		
		$table_name = 'v_' . $version->id . '_verses';
		if (Schema::hasTable($table_name)){
			DB::table($table_name)->where(['chapter_id' => $chapter->id])->delete();
		}
		$chapter->delete();
	}
}