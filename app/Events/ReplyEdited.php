<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use \App\Reply;

class ReplyEdited
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reply;
		
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }
}
