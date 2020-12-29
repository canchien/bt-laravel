<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table= "comments";

    public function users()
    {
        return $this->belongsTo('App\Models\User','author','id');
    }

    public function posts()
    {
        return $this->belongsTo('App\Models\Post','post_id','id');
    }
}
