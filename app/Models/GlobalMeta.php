<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalMeta extends Model
{

    protected $table = 'global_metas';

    protected $fillable = [
        'name',
    ];

    public static function get_value($name, $pid=null, $output=null)
    {
        if (!empty($pid)) {
            $result = self::where(['name' => $name, 'pid' => $pid])->first();
        } else {
            $result = self::where(['name' => $name])->first();
        }

        $return = (!empty($output) && isset($result->$output)) ? $result->$output : $result;

        return $return;
    }


}
