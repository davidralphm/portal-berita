<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/resetPassword/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Gate::define('isEditor', function($user) {
            return $user->type == 'editor';
        });

        Gate::define('isAdmin', function($user) {
            return $user->type == 'admin';
        });

        Gate::define('isEditorOrAdmin', function($user) {
            return $user->type == 'editor' || $user->type == 'admin';
        });

        Gate::define('isOwner', function($user, $item) {
            return $user->id == $item->user_id || $user->type == 'admin';
        });

        //
    }
}
