<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Validations\ValidReply;
use App\Repositories\Eloquent\ReplyRepository;
use App\Reply;

class ReplyController extends Controller
{
	private $replies;
	
	public function __construct(ReplyRepository $replyRepository){
		$this->authorizeResource(\App\Reply::class, 'reply');
		$this->replies = $replyRepository;
	}
		
	public function index(){
		$comment_id = request('comment');
		return response()->json(
			$this->replies->where(['comment_id'=>$comment_id])->getPaginated()
		);
	}

    public function store(ValidReply $request)
    {
		$reply = \App\Reply::create( $request->all() );
		$data = $this->replies->find($reply->id);

		return response()->json($data);
    }

    public function update(ValidReply $edited_reply, Reply $reply)
    {
		$edited = $edited_reply['data'];
		if ( $reply->author === Auth::id() ){
			$reply->text = $edited['text'];
			$reply->save();
			$fresh_reply = $this->replies->find($reply->id);	
			return response()->json( $fresh_reply );
		} else {
			//edit request
		}
    }

    public function destroy(Reply $reply)
    {
		$reply_id = $reply->id;
		$reply->delete();
		return ['id' => $reply_id];
    }
}
