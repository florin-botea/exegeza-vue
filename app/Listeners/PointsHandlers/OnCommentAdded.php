<?php

namespace App\Listeners\PointsHandlers;

use App\Events\CommentAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class OnCommentAdded
{
    public function handle(CommentAdded $event)
    {
        Auth::user()->decrement('points', config('action_costs')['post_comment']);
    }
}
