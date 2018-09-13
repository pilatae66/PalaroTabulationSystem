<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;

class Contestant extends Model
{
    public function event(){
        return $this->belongsTo(Event::class);
    }
}
