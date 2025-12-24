<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use App\Models\User;
use App\Models\Comment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        Gate::define('comment', function(User $user, Comment $comment) {
            return ($user->id == $comment->user_id) 
            ? Response::allow()
            : Response::deny('You are not admin');
        });

        Gate::before(function(User $user){
            if ($user->role == "admin")
                return true;
        });
    }
}
