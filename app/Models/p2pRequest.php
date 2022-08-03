<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class p2pRequest extends Model
{
    use HasFactory;
    public function p2pOffer()
    {
        return $this->belongsTo(p2pOffer::class);
    }

    public function chats()
    {
        return $this->hasMany(p2pChat::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class,'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }
}
