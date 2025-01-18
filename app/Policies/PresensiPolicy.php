<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Presensi;
use Illuminate\Auth\Access\HandlesAuthorization;

class PresensiPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_presensi');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Presensi $presensi): bool
    {
        return $user->can('view_presensi');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_presensi');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Presensi $presensi): bool
    {
        return $user->can('update_presensi');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Presensi $presensi): bool
    {
        return $user->can('delete_presensi');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_presensi');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Presensi $presensi): bool
    {
        return $user->can('force_delete_presensi');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_presensi');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Presensi $presensi): bool
    {
        return $user->can('restore_presensi');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_presensi');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Presensi $presensi): bool
    {
        return $user->can('replicate_presensi');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_presensi');
    }
}
