<?php

namespace AirAroma\Repository;

use AirAroma\Model\Unitsize;

class UnitSizeRepository
{

    public function __construct(Unitsize $unitsize)
    {
        $this->unitsize = $unitsize;
    }

    public function getUnitSizes()
    {
        return $this->unitsize->orderBy('unitsizes.uni_id','asc')->get();
    }


}
