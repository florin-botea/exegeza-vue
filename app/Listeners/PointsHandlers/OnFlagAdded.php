<?php

namespace App\Listeners\PointsHandlers;

use App\Events\FlagAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OnFlagAdded
{
    public function handle(FlagAdded $event)
    {
				$bilance = $event->new_flag->value - $event->initial_flag->value;
        \App\User::find( \App\Comment::find($event->comment_id)->author )->increment('points', $bilance);
    }
}
