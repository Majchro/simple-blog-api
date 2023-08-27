<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Attachment;
use App\Models\User;

class AttachmentPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Attachment $attachment): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Attachment $attachment): bool
    {
        return false;
    }

    public function delete(User $user, Attachment $attachment): bool
    {
        return $user->can('delete', $attachment->connection()->first());
    }

    public function restore(User $user, Attachment $attachment): bool
    {
        return false;
    }

    public function forceDelete(User $user, Attachment $attachment): bool
    {
        return false;
    }
}
