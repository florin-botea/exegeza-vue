<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Auth;

class FlagsController extends Controller
{
	public function setUserFlag($comment_id){
		$payload = Request::all();
		//return response()->json($payload['flag_id']);
		if ($payload['flag_id'] > 0){
			\App\Flags::updateOrCreate(['comment_id' => $comment_id, 'author' => Auth::id()], ['flag_id' => $payload['flag_id']]);
		} else {
			\App\Flags::where(['comment_id' => $comment_id, 'author' => Auth::id()])->delete();
		}
	}
}
