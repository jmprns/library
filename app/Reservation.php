<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'rn', 
    	'type', 
    	'borrow_id', 
        'book_id', 
    	'acc_id', 
    	'reserve_date', 
        'approve_date', 
    	'approve_by', 
    	'start', 
    	'end', 
    	'returned', 
    	'status', 
    	'notes'
    ];

    public function book()
    {
        return $this->belongsTo('App\Book', 'book_id');
    }

    public function borrow()
    {
        return $this->belongsTo('App\Borrow', 'borrow_id');
    }

    public function library()
    {
        return $this->belongsTo('App\Library', 'approve_by');
    }

    public function accession()
    {
        return $this->belongsTo('App\Accession', 'acc_id');
    }
}
