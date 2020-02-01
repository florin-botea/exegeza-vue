<?php
namespace App\Repositories\Eloquent;

use App\Reply;

class ReplyRepository extends PaginationRepository
{
	protected function path()
	{
		return '/raspunsuri';
	}
	
	protected function query()
	{
		return Reply::with('author')
			->with('repportedByMe');
	}
}