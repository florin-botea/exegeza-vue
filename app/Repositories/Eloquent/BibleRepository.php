<?php
namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use \App\Repositories\Eloquent\Maps\BibleMap;

class BibleRepository extends MainBibleRepository
{
	public function get()
	{
		return $this->fetch();
	}
	
	public function store(array $data){
		Cache::forget('app_');
		
		$bible = \App\Bible::create($data);
		$table_name = 'v_' . $bible->id . '_verses';
		if (! Schema::hasTable($table_name)) {
			Schema::create($table_name, function (Blueprint $table) {
				$table->increments('id');
				//$table->integer('global_id')->unsigned();
				$table->integer('book_id')->unsigned();
				// $table->integer('book_index')->unsigned();
				$table->integer('chapter_id')->unsigned();
				// $table->integer('chapter_index')->unsigned();
				$table->integer('index')->unsigned();
				$table->string('text')->length(700);
			});
		}

		
	}
	
	public function update(string $slug, array $data){
		Cache::forget('app_');
		
		\App\Bible::where('slug', $slug)->update([
			'name' => $data['name'],
			'alias' => $data['alias'],
			'slug' => $data['slug'],
			'public' => $data['public'],
		]);
	}
	
	public function destroy(string $version){
		Cache::forget('app_');
		
		$version = \App\Bible::where('slug', $version)->latest('id')->first();
		$table_name = 'v_' . $version->id . '_verses';
		if (Schema::hasTable($table_name)){
			Schema::drop($table_name);
		}
		$version->delete();
	}
}