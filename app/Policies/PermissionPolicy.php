<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function sales(User $user) : bool
    {
        return $user->rol->p_sales == 1;
    }

    public function sell(User $user) : bool
    {
        return $user->rol->p_sell == 1;
    }

    public function users(User $user) : bool
    {
        return $user->rol->p_users == 1;
    }

    public function config(User $user) : bool
    {
        return $user->rol->p_config == 1;
    }

    public function reports(User $user) : bool
    {
        return $user->rol->p_reports == 1;
    }

    public function listCredits(User $user) : bool
    {
        return $user->rol->p_s_credits == 1;
    }

    public function manageCredits(User $user) : bool
    {
        return $user->rol->p_e_credits == 1;
    }

    public function listClients(User $user) : bool
    {
        return $user->rol->p_s_clients == 1;
    }

    public function manageClients(User $user) : bool
    {
        return $user->rol->p_e_clients == 1;
    }

    public function listInventory(User $user) : bool
    {
        return $user->rol->p_s_inventory == 1;
    }

    public function manageInventory(User $user) : bool
    {
        return $user->rol->p_e_inventory == 1;
    }

    public function discount(User $user) : bool
    {
        return $user->rol->p_discount == 1;
    }
}
