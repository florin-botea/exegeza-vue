<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ModelHasTag;

class TagController extends Controller
{
	public function __construct(){
		//old
	}
	
	public function store(Request $req){
		$tag_item = $req->all();
		//return response()->json($tag_item);
		$tag = \App\Tag::firstOrCreate(['name' => $tag_item['name']], [
			'created_by' => Auth::id()
		]);
		if ( \App\ModelHasTag::where(['tag_id' => $tag->id, 'comment_id' => $tag_item['comment_id']])->count() < 1 ){
			$tegged = \App\ModelHasTag::create([
				'tag_id' => $tag->id,
				'comment_id' => $tag_item['comment_id'],
				'assigned_by' => Auth::id(),
			]);
			$tag = \App\ModelHasTag::with('details')->find($tegged->id);
			return response()->json($tag);
		}
		return response()->json(false, 409);
	}
	
	public function index(Request $request){
		$qs = $request->query('qs');
		$suggestions = \App\Tag::where('name', 'LIKE', $qs.'%')->take(5)->get();
		return response()->json($suggestions);
	}
	
	public function destroy(ModelHasTag $tag){
		$tag_id = $tag->id;
		$tag->delete();
		return response()->json(['id' => $tag_id]);
	}
}
