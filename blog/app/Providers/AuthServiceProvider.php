<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Models\Calendar' => 'App\Policies\CalendarPolicy',
         'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        Gate::define('isAdmin',function($user){
           return $user->permission == 1 or 2;
           // 2=作成者、1=共同管理者、0=メンバー
        });
        
        Gate::define('isUser',function($user){
           return ($user->permission == 1 or 2) ;
        });

        //
    }
}
