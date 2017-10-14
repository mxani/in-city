<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class places extends Model
{
    
    protected $table = 'places';


    public function location()
    {
        return $this->belongsTo('App\locations');
    }
}
