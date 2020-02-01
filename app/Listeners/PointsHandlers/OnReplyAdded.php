<?php

namespace App\Listeners\PointsHandlers;

use App\Events\ReplyAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class OnReplyAdded
{
    public function handle(ReplyAdded $event)
    {
        Auth::user()->decrement('points', config('action_costs')['post_reply']);
    }
}
