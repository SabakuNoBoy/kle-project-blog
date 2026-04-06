<?php

namespace App\Policies;

use App\Models\Agreement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AgreementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_agreements');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Agreement $agreement): bool
    {
        return $user->hasPermissionTo('view_agreements');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_agreements');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Agreement $agreement): bool
    {
        return $user->hasPermissionTo('edit_agreements');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Agreement $agreement): bool
    {
        return $user->hasPermissionTo('delete_agreements');
    }
}
