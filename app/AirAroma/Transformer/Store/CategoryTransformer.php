<?php 

namespace AirAroma\Transformer\Store;

use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform($product)
    {
        return [
            'name' => $product['cat_name'],
            'slug' => $product['cat_slug'],
        ];
    }
}

