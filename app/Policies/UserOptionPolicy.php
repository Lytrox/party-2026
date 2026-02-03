<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\UserOption;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserOptionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:UserOption');
    }

    public function view(AuthUser $authUser, UserOption $userOption): bool
    {
        return $authUser->can('View:UserOption');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:UserOption');
    }

    public function update(AuthUser $authUser, UserOption $userOption): bool
    {
        return $authUser->can('Update:UserOption');
    }

    public function delete(AuthUser $authUser, UserOption $userOption): bool
    {
        return $authUser->can('Delete:UserOption');
    }

    public function restore(AuthUser $authUser, UserOption $userOption): bool
    {
        return $authUser->can('Restore:UserOption');
    }

    public function forceDelete(AuthUser $authUser, UserOption $userOption): bool
    {
        return $authUser->can('ForceDelete:UserOption');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:UserOption');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:UserOption');
    }

    public function replicate(AuthUser $authUser, UserOption $userOption): bool
    {
        return $authUser->can('Replicate:UserOption');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:UserOption');
    }

}