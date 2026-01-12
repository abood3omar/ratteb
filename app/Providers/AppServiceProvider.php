<?php

namespace App\Providers;

use Illuminate\Container\Attributes\Cache;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\Paginator as PaginationPaginator;
use Illuminate\Support\ServiceProvider;

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
         PaginationPaginator::useTailwind();
        // when do a migration you have to commment all of these lines - Abdalrhman Hamed
        
        $entities = cache()->remember('global_entities', 60 * 60, function () {
            return [
                'security' => \App\Models\Entity::where('EntityName', 'security')->first()?->EntityID,   
                'system-module' => \App\Models\Entity::where('EntityName', 'system-module')->first()?->EntityID,   
                'role-rights' => \App\Models\Entity::where('EntityName', 'role-rights')->first()?->EntityID,
                'users' => \App\Models\Entity::where('EntityName', 'users')->first()?->EntityID,
                'sessions' => \App\Models\Entity::where('EntityName', 'sessions')->first()?->EntityID,                                          
                'account' => \App\Models\Entity::where('EntityName', 'account')->first()?->EntityID,
                'admin-bookings' => \App\Models\Entity::where('EntityName', 'admin-bookings')->first()?->EntityID,
                'databank' => \App\Models\Entity::where('EntityName', 'databank')->first()?->EntityID,
            ];
        });
    
        $actions = cache()->remember('global_actions', 60 * 60, function () {
            return [            
                'show' => \App\Models\Action::where('ActionName', 'show')->first()?->ActionID,
            ];
        });
    
        view()->share('entities', $entities);
        view()->share('actions', $actions);
    }
}
