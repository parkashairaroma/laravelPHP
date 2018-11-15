<?php

namespace AirAroma\Repository;

use AirAroma\Model\Colour;

class ColourRepository
{

    public function __construct(Colour $colour)
    {
        $this->colour = $colour;
    }

    public function getColours()
    {
        return $this->colour->orderBy('colours.col_id','asc')->get();
    }


}
