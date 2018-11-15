<?php 

namespace AirAroma\Transformer\Store;

use League\Fractal\TransformerAbstract;

class OilgroupTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform($oilgroup)
    {
        return [
           'id' => $oilgroup->olg_id,
           'name' => $oilgroup->olg_name,
           'slug' => $oilgroup->olg_slug,
           'image' => $oilgroup->olg_image,
        ];
    }
}