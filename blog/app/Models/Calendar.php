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
    'start_time',
    'finish_time',
    
    ];
    
}

