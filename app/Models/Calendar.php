<?php
//https://readouble.com/laravel/6.x/ja/migrations.html

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendar extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'date',
        'date_fin',
        'start_time',
        'finish_time',
    ];
    
    /**
     * テーブルの主キー
     *
     * @var string
    */
    
    protected $primaryKey = 'calendar_id';
    
    /**
     * データベースで変更
     *
     * Postgresの場合はコメントアウトを解除
    */
    protected $dateFormat = 'Y-m-d H:i:sO';
    
}

