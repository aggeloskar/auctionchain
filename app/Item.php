<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'image_path', 'starting_price', 'reserve_price', 'currency', 'end_date', 'contract_address', 'status',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function bids() {
        return $this->hasMany('App\Bid');
    }
}
