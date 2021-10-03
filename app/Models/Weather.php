<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $table = 'weathers';
    
    protected $fillable = [
        'sky',
        'desc',
        'city',
        'humidity',
        'temp',
        'dt_txt',
    ];
    /**
     * データベースで変更
     *
     * Postgresの場合はコメントアウトを解除
    */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
