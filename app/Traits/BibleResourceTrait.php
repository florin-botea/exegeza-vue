<?php 

namespace App\Traits;

trait BibleResourceTrait
{
	public function urlFromGlobalId(int $global_id, $qs = []){
		$version = \App\Bible::firstOrFail();
		$book = \App\Book::where(['bible_id'=>$version->id,'index'=>floor($global_id/1000000)])->firstOrFail();
		$chapter = floor(($global_id%1000000)/1000);
		$verse = $global_id%1000;
		
		$base = '/traduceri/'.$version->slug.'/carti/'.$book->slug.'/capitole/';
		if ( $chapter > 0 ){
			$base .= ($chapter.'/versete');
		}
		if ( $chapter>0 && $verse>0 ){
			$qs['verse'] = $verse;
		}
		return $base.'?'.http_build_query($qs);
	}
}