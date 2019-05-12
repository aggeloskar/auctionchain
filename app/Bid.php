<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = [
        'user_id', 'item_id', 'price',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function auction() {
        return $this->belongsTo('App\Auction');
    }
}
