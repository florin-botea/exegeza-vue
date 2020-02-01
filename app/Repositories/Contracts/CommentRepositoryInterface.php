<?php

namespace App\Repositories\Contracts;

interface CommentRepositoryInterface
{
   public function fetch($verse_id, $comment_id);
   
   public function find($comment_id);
}