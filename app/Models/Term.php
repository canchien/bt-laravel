<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    //
    protected $table = 'terms';

    public function posts()
    {
        return $this->belongsToMany("App\Models\Post",'term_relationships','term_id','post_id');
    }

}
