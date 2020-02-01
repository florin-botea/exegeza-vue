<?php

namespace App\Repositories\Contracts;

interface ReplyRepositoryInterface
{
   public function fetch($comment_id, $reply_id);
   
   public function find($reply_id);
}