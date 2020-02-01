<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\TagAdded;

class ModelHasTagController extends Controller
{
    public function __construct(){
		$this->authorizeResource(\App\ModelHasTag::class, 'tag');
	}
	
    public function index()
    {
		$qs = request('qs');
		$suggestions = \App\Tag::where('name', 'LIKE', $qs.'%')->take(5)->get();
		return response()->json($suggestions);
    }

    public function create()
    {
        //
    }

    public function store(Request $tag, $comment_id)
    {
		$tag = \App\Tag::firstOrCreate(['name' => $tag->name], [
			'created_by' => Auth::id()
		]);
		$modelHasTag = \App\ModelHasTag::where(['tag_id' => $tag->id, 'comment_id' => $comment_id])->first();
		if (! $modelHasTag ){
			$tegged = \App\ModelHasTag::create([
				'tag_id' => $tag->id,
				'comment_id' => $comment_id,
				'assigned_by' => Auth::id(),
			]);
			
			return response()->json(\App\ModelHasTag::with('details')->find($tegged->id));
		}
		return response()->json($modelHasTag, 409);
    }
		
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($comment_id, $modelHasTag_id)
    {
        \App\ModelHasTag::find($modelHasTag_id)->delete();
		return response()->json(['id' => $modelHasTag_id]);
    }
}
