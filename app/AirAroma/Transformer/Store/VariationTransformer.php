<?php 

namespace AirAroma\Transformer\Store;

use League\Fractal\TransformerAbstract;

class VariationTransformer extends TransformerAbstract
{

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform($product)
    {
        $availability = ($product['proweb_available']) ? true : false;

        return [
            'id'  => $product['prv_id'],
            'name'  => $product['pro_name'],
            'description'  => $product['pro_description'],
            'link' => $product['pro_linkprefix'] . '/' . $product['pro_slug'],
            'image'  => $product['prv_image'],
            'tile'  => $product['prv_imagetile'],   
            'price'  => number_format($product['proweb_price'], 2),
            'weight' => $product['prv_shippingweight'],
            'stock' => $product['proweb_outofstock'],
            'available' => $availability,
            'dimensions' => $product['prv_shippingdimensions'],   
            'unit' => [ 
                'name' => $product['uni_size'] ? $product['uni_name'] : null,
                'size' => $product['uni_size'],
                'type' => $product['uni_type'],
            ],
            'colour' => [ 
                'name' => $product['col_hex'] ? $product['col_name'] : null,
                'hex' => $product['col_hex'],
            ],
        ];
    }
}

