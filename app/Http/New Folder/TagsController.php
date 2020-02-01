<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{
	public function store(){
		$tag_item = Request::all();
		//return response()->json($tag);
		$tag = \App\Tag_list::firstOrCreate(['name' => $tag_item['name']], [
			'created_by' => Auth::id()
		]);
		if ( \App\Tags::where(['tag_id' => $tag->id, 'comment_id' => $comment_id])->count() < 1 ){
			$tegged = \App\Tags::create([
				'tag_id' => $tag->id,
				'comment_id' => $tag_item->comment_id,
				'assigned_by' => Auth::id(),
			]);
			$tag = \App\Tags::with('details')->find($tegged->id);
			return response()->json($tag);
		}
		return response()->json(false, 409);
	}
	
	public function tagsSuggestions($qs){
		$suggestions = \App\Tag_list::where('name', 'LIKE', $qs.'%')->take(5)->get();
		return response()->json($suggestions);
	}
	
	public function destroy($comment_id, $tag_id){
		\App\Tags::find($tag_id)->delete();
		return response()->json($tag_id);
	}
}
