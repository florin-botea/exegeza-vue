<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Eloquent\CommentRepository;
use App\Repositories\Eloquent\ReplyRepository;
use App\Repositories\Eloquent\VerseRepository;

class VersesController extends Controller
{
	use \App\Traits\BibleTrait;
	
	private $verses;
	private $comments;
	private $replies;
		
	public function __construct (
		VerseRepository $verseRepository,
		CommentRepository $commentRepository, 
		ReplyRepository $replyRepository
	){
		$this->verses = $verseRepository;
		$this->comments = $commentRepository;
		$this->replies = $replyRepository;
	}
		
    public function index(Request $req, $ve, $b, $c)
    {
		$c = intval($c);
		(is_int($c) && $c > 0) || abort(404);
		$verse_index = $req->query('verse', 0);
		$comment_id = $req->query('comment', 0);
		$reply_id = $req->query('reply', 0);
		$data = $this->verses->get($ve, $b, $c);
		$global_id = ($data['verses']['meta']['chapter']['index'] * 1000) + ($data['verses']['meta']['book']['index'] * 1000000) + $verse_index;

		$data['comments'] = $comment_id > 0 ? $this->comments->where(['target'=>$global_id])->getPageContainingId($comment_id) : $this->comments->where(['target'=>$global_id])->getPaginated();
		if ($reply_id && $comment_id){
			$data['replies'] = $this->replies->where(['comment_id'=>$comment_id])->getPageContainingId($reply_id);
		}

		return view('verses')->with(['data' => $data]);
    }

    public function store(Request $request, $version_name, $book_name, $chapter_index)
    {
		if ( $request->submit === 'add' ){
			$this->verses->store($version_name, $book_name, $chapter_index, $request->all());
			return back();
		}
		elseif ( $request->submit === 'preview' ){
			$verses = $this->verses->parseText($request->regexp, $request->texts);
			return back()->withInput()->with('verses_preview', $verses); ;
		}
    }
}