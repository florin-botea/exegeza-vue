<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repport extends Model
{
    protected $fillable = ['model_type', 'repported_by', 'reason'];
}
