<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;
use Auth;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register the blade directives.
     *
     * @return void
     */
    public function boot()
    {
        $user = Auth::user();
        // @can('module.changeModule')
        // @elsecan('user.create')
        // @elsecan('user.create||user.update')
        // @else
        // @endcan
        Blade::if('can', function ($permission) {

            if (Auth::user()->IsRootOrSuper()) return true;

            foreach (Auth::user()->roles as $rol) {
                if ($rol->special == 'all-access') return true;
                if ($rol->special == 'no-access') return false;
            }

            if (str_contains($permission, '||')) {
                $quests = explode('||', $permission);
                foreach ($quests as $quest) {
                    $permission = explode('.', $quest);
                    if (Auth::user()->canActMod($permission[1], $permission[0])) return true;
                }
            } else {
                $permission = explode('.', $permission);
                if (Auth::user()->canActMod($permission[1], $permission[0])) return true;
            }
            return false;
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
