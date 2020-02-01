<?php
namespace App\Repositories\Eloquent;

use App\Comment;

class CommentRepository extends PaginationRepository
{
	protected function path()
	{
		return '/comentarii';
	}
	
	protected function query()
	{
		return Comment::with('author')
			->withCount('replies')
			->with('tags.details')
			->with('tags.author')
			->with('repportedByMe');
	}
}