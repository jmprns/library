<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $fillable = ['action', 'lib_id'];

    public function librarian()
    {
    	return $this->belongsTo('App\Library', 'lib_id');
    }
}
