<?php
namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MainBibleRepository
{
	protected function fetch($version = '', $book = '', $chapter_index = '', $verse_index = '')
	{
		return Cache::remember('app_'.$version.$book.$chapter_index, 3600, function () use ($version,$book,$chapter_index,$verse_index) {
			return $this->fetchFromDB($version, $book, $chapter_index, $verse_index);
		});
	}
	
	public function fetchFromDB(string $version = null, string $book = null, string $chapter_index = null, string $verse_index = null){
		$data = [ 'versions' => ['data' => \App\Bible::all()] ];
		if (! $version) return $data;
		$version = $data['versions']['data']->firstWhere('slug', $version) ?? abort(404);
		$data['books'] = [
			'meta' => ['version' => $version],
			'data' => $version->books
		];
		
		if (! $book) return $data;
		$book = $data['books']['data']->firstWhere('slug', $book) ?? abort(404);
		$data['chapters'] = [
			'meta' => [
				'version' => $version,
				'book' => $book
			],
			'data' => $book->chapters
		];
		
		if (! $chapter_index) return $data;
		$table_name = 'v_' . $version->id . '_verses';
		$chapter = $data['chapters']['data']->firstWhere('index', $chapter_index) ?? abort(404);
		$verses = DB::table($table_name)
			->join('books', $table_name.'.book_id', '=', 'books.id')
			->join('chapters', $table_name.'.chapter_id', '=', 'chapters.id')
			->where('chapter_id', $chapter->id)
			->get([$table_name.'.id', $table_name.'.index', $table_name.'.text', 'books.index as book_index', 'books.name as book_name', 'chapters.index as chapter_index']);
		
		$data['verses'] = [
			'meta' => [
				'version' => $version,
				'book' => $book,
				'chapter' => $chapter
			],
			'data' => $verses
		];
		return $data;
	}
}	