<?php

namespace AirAroma\Repository;

use AirAroma\Model\State;

class StateRepository
{
    
    public function __construct(State $state)
    {
        $this->state = $state;
    }

    public function getStateById($stateId)
    {
        return $this->state->where('sta_id', '=', $stateId)->first();
    }

}
