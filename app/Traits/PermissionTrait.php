<?php

namespace App\Traits;

use Auth;
use Carbon\Carbon;
use Closure;

trait PermissionTrait
{
    /**
     * Evalua si el usuario logueado es root o tiene el privilegio de superadmin.
     */
    public function IsRootOrSuper()
    {
        if (Auth::user()->id === 1) {
            return true;
        }
        foreach (Auth::user()->roles as $rol) {
            if ($rol->id == 1) {
                return true;
            }
        }
        return false;
    }

    /**
     * Evalua si la la hora esta entre las permitidas.
     */
    public function isHourToAccess()
    {
        $now = Carbon::now();
        foreach (Auth::user()->roles as $rol) {
            $t_init = Carbon::parse($rol->from_at);
            $t_stop = Carbon::parse($rol->to_at);
            if ($now >= $t_init && $now <= $t_stop) return true;
        }
        return false;
    }

    public function canActMod($action, $module)
    {
        return $permissions = \Auth::user()->permissions
        ->where('module', '=', $module)
        ->where('action', '=', $action)
        ->first();
    }

    public function specialAccess()
    {
        foreach (Auth::user()->roles as $rol) {
            if ($rol->special == 'all-access') return 1;
            if ($rol->special == 'no-access') return -1;
        }
        return 0;
    }

    public function iCan($action, $module)
    {
        if (self::IsRootOrSuper()) return true;

        $access = self::specialAccess();
        if ($access == 1) return true;
        if ($access == -1) return false;

        if (! self::isHourToAccess()) return false;

        if (self::canActMod($action, $module)) return true;
    }
}