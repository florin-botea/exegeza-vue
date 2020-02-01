<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Validations\ValidChapter;
use App\Repositories\Eloquent\CommentRepository;
use App\Repositories\Eloquent\ReplyRepository;
use App\Repositories\Eloquent\ChapterRepository;
use App\Repositories\Eloquent\VerseRepository;

class ChapterController extends Controller
{
	use \App\Traits\BibleTrait;
	
	private $chapters;
	private $verses;
	private $comments;
	private $replies;
		
	public function __construct (
		ChapterRepository $chapterRepository,
		CommentRepository $commentRepository, 
		ReplyRepository $replyRepository
	){
		$this->authorizeResource(\App\Chapter::class, 'chapter');
		$this->chapters = $chapterRepository;
		$this->comments = $commentRepository;
		$this->replies = $replyRepository;
	}
	
    public function index(Request $req, string $version, string $book)
    {
		$comment_id = $req->query('comment', 0);
		$reply_id = $req->query('reply', 0);
		$data = $this->chapters->get($version, $book);
		$global_id = $data['chapters']['meta']['book']['id'] * 1000000;
		$data['comments'] = $comment_id > 0 ? $this->comments->where(['target'=>$global_id])->getPageContainingId($comment_id) : $this->comments->where(['target'=>$global_id])->getPaginated();
		if ($reply_id && $comment_id){
			$data['replies'] = $this->replies->where(['comment_id'=>$comment_id])->getPageContainingId($reply_id);
		}
		return view('chapters')->with(['data' => $data]);
    }

    public function store(ValidChapter $request, VerseRepository $verseRepository, string $version, string $book)
    {
		if ( $request->submit === 'add' ){
			$this->chapters->store($version, $book, $request->all());
			if ( isset($request->add_verses) ){
				$chapter = $request->index;
				$verseRepository->store($version, $book, $chapter, $request->all());
			}
			return back();
		}
		elseif ( $request->submit === 'preview' ){
			$verses = $verseRepository->parseText($request->regexp, $request->texts);
			return back()->withInput()->with('verses_preview', $verses); ;
		}
		
		return back();
    }

    public function update(ValidChapter $req, string $version, string $book, int $chapter_index)
    {
		$this->chapters->update( $version, $book, $chapter_index, $req->all() );
			
		return back();
    }

    public function destroy(string $version, string $book, string $chapter_index)
    {
        $this->chapters->destroy($version, $book, $chapter_index);
		
		return back();
    }
}
