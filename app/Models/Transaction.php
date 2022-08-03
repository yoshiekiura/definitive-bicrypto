<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = "transactions";

    protected  $guarded = ['id'];
    protected $fillable = [
        'txHash',
        'amount',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pendingTransactions()
    {
        return $this->where('status', 1)->where('created_at', '<', Carbon::NOW()->subMinutes(20))->get();
    }

}
