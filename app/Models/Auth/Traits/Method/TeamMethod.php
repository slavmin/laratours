<?php

namespace App\Models\Auth\Traits\Method;

/**
 * Trait TeamMethod.
 */
trait TeamMethod
{
    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->name === config('access.users.admin_role');
    }
}
