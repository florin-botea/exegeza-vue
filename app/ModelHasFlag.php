<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelHasFlag extends Model
{
    protected $fillable = ['flag_id', 'comment_id', 'author'];
}
