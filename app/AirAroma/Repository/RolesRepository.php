<?php

namespace AirAroma\Repository;

use AirAroma\Model\Role;

class RolesRepository
{
    function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * list with available roles
     */
    public function getRolesSelectList() 
    {
        return $this->role->get()->lists('rol_name', 'rol_id');
    }
}