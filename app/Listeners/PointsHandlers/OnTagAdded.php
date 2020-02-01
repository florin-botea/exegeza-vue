<?php

namespace App\Listeners\PointsHandlers;

use App\Events\TagAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class OnTagAdded
{
    public function handle(TagAdded $event)
    {
        Auth::user()->decrement('points', 1);
    }
}
