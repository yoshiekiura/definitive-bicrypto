<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{

    protected $table = 'user_metas';
    protected $fillable = ['userId'];
}
