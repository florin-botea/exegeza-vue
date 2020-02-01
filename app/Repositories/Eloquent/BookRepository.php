<?php
namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BookRepository extends MainBibleRepository
{
	public function get(string $version)
	{
		return $this->fetch($version);
	}
	
	public function store(string $version, $data)
	{
		$db = $this->fetchFromDB($version);
		$version = $db['versions']['data']->firstWhere('slug', $version) ?? abort(404);
		Cache::forget('app_'.$version->slug);
		
		$version->books()->create($data);
	}
	
	public function update(string $version, string $book, $data)
	{
		$db = $this->fetchFromDB($version, $book);
		$version = $db['versions']['data']->firstWhere('slug', $version) ?? abort(404);
		$book = $db['books']['data']->firstWhere('slug', $book) ?? abort(404);
		Cache::forget('app_'.$version->slug);
		
		$book->update([
			'index' => $data['index'],
			'name' => $data['name'],
			'slug' => $data['slug'],
		]);
	}
	
	public function destroy(string $version, string $book)
	{
		$version = \App\Bible::where('slug', $version)->latest('id')->first();
		$book = \App\Book::where(['bible_id' => $version->id, 'slug' => $book])->latest('id')->first();
		$table_name = 'v_' . $version->id . '_verses';
		if (Schema::hasTable($table_name)){
			DB::table($table_name)->where(['book_id' => $book->id])->delete();
		}
		Cache::forget('app_'.$version->slug);
		
		$book->delete();
	}
}