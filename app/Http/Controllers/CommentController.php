<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Validations\ValidComment;
use App\Repositories\Eloquent\CommentRepository;
use App\Comment;

class CommentController extends Controller
{
	private $comments;
	
	public function __construct(CommentRepository $commentRepository){
		$this->authorizeResource(Comment::class, 'comment');
		$this->comments = $commentRepository;
	}

    public function index()
    {
		$verse_id = request('target');
		return response()->json(
			$this->comments->where(['target'=>$verse_id])->getPaginated()
		);
    }

    public function store(ValidComment $request)
    {
		$comment = \App\Comment::create( $request->all() );
		
		return response()->json(
			$this->comments->find($comment->id)
		);
    }

    public function update(ValidComment $edited_comment, Comment $comment)
    {
		$edited = $edited_comment['data'];
		if ( $comment->author === Auth::id() ){
			$comment->title = $edited['title'];
			$comment->text = $edited['text'];
			$comment->save();
			$fresh_comment = $this->comments->find($comment->id);
			return response()->json( $fresh_comment );
		} else {
			//edit request
		}
    }

    public function destroy(Comment $comment)
    {
		$comment_id = $comment->id;
		$comment->delete();
		return ['id' => $comment_id];
    }
}
