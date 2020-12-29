<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postmeta extends Model
{
    //
    protected $table= 'postmeta';
    public $timestamps = false;

    public function posts()
    {
        return $this->belongsTo('App\Models\Post','post_id','id');
    }
}
