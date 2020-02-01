<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use \App\Flag;

class FlagAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

		public $comment_id;
    public $initial_flag;
    public $new_flag;
		
    public function __construct($comment_id, Flag $initial_flag, Flag $new_flag)
    {
        $this->initial_flag = $initial_flag;
        $this->new_flag = $new_flag;
        $this->comment_id = $comment_id;
    }
}
