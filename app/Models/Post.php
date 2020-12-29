<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table= 'posts';

    public function categories()
    {
        return $this->belongsToMany("App\Models\Term",'term_relationships','post_id','term_id');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User','author','id');
    }

    public function postmeta()
    {
        return $this->hasMany('App\Models\Postmeta','post_id','id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comments','post_id','id');
    }
}
