<?php 

namespace App\Traits;

trait BibleTrait 
{
	public function versions (){
		return \App\Bible::all();
	}	
	
	public function books ($v){
		return \App\Book::where('bible_id', $v)->orderBy('index')->get();
	}
	
	public function book($v, $b){
		return \App\Book::where([
			['bible_id', $v],
			['index', $b]
		])->first();
	}
	
	public function chapters($v, $b){
		return \App\Book::with([
			'chapters' => function($q){ $q->orderBy('index'); }
		])->where([
			['bible_id', $v],
			['index', $b],
		])->first();
	}
	
	public function chapter($v, $b, $c){ //not sure
		return \App\Book::with([
			'chapter' => function($q) use ($c){
				$q->where('index', $c);
			}
		])->where([
			['bible_id', $v],
			['index', $b]
		])->first()->chapter;
	}
	
	public function verses($ve, $b, $c){
		return \App\Book::with([
			'chapter' => function($q) use ($c){ $q->where('index', $c); },
			'chapter.verses'
		])->where([
			['bible_id', $ve],
		])->first();
	}
	
	public function verse($ve, $b, $c, $vr){
		return \App\Book::with([
			'chapter' => function($q) use ($c){
				$q->where('index', $c);
			},
			'chapter.verse' => function($q) use ($vr){
				$q->where('index', $vr);
			}
		])->where([
			['bible_id', $ve],
			['index', $b],
		])->first()->chapter->verse;
	}	
	
	public function getMissingOrNext ($collection){
		if (count($collection) === 0){
			return 1;
		}
		for($i=0;$i<count($collection)-1;$i++){
			if ( $collection[$i+1] && (($collection[$i+1]->index - $collection[$i]->index) > 1) ){
				return $collection[$i]->index + 1;
			}
		}
		return $collection->last()->index + 1;
	}
}