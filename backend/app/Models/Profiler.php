<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profiler extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['state','color','permission'];
    
    public function user()
    {
        return $this->belongsTO('App\Models\User');
    }
    
}
