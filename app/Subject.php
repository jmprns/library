<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'cat_id'];

    public function category()
    {
    	return $this->belongsTo('App\Category', 'cat_id');
    }
}
