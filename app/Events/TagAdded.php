<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use \App\Comment;

class TagAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
		
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
