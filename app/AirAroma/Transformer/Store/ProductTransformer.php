<?php

namespace AirAroma\Transformer\Store;

use AirAroma\Transformer\Store\CategoryTransformer;
use AirAroma\Transformer\Store\OilgroupTransformer;
use AirAroma\Transformer\Store\VariationTransformer;
use AirAroma\Transformer\Store\ImageTransformer;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'categories',
        'oilgroups',
        'variations',
        'images'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform($product)
    {
        return [
            'id'  => (int) $product['pro_id'],
            'name'  => $product['pro_name'],
            'slug'  => $product['pro_slug'],
            'title'  => $product['pro_title'],
            'meta_desc' => $product['pro_meta_desc'],
            'link' => $product['pro_linkprefix'] . '/' . $product['pro_slug'],
            'image'  => $product['pro_image'],
            'tile'  => $product['pro_imagetile'],
            'description' => $product['pro_description'],
            'url' => $product['pro_linkprefix'],
            'characteristics' => $product['pro_characteristics'],
            'quality' => $product['pro_quality'],
        ];
    }

    /**
     * Include Category
     *
     * @return League\Fractal\ItemResource
     */
    public function includeCategories($product)
    {
        return $this->item($product, new CategoryTransformer);
    }

    /**
     * Include Variations
     *
     * @return League\Fractal\ItemResource
     */
    public function includeVariations($product)
    {
        return $this->collection($product->variations, new VariationTransformer);
    }

    /**
     * Include Images
     *
     * @return League\Fractal\ItemResource
     */
    public function includeImages($product)
    {
        return $this->collection($product, new ImageTransformer);
    }

    /**
     * Include Oil Groups
     *
     * @return League\Fractal\ItemResource
     */
    public function includeOilgroups($product)
    {
        if (is_object($product->oilgroups)) {
            return $this->collection($product->oilgroups, new OilgroupTransformer);
        }
        return $this->item($product, new OilgroupTransformer);
    }
}