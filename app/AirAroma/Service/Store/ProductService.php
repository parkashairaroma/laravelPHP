<?php

namespace AirAroma\Service\Store;

use AirAroma\Model\Product;
use AirAroma\Repository\Store\ProductRepository;
use AirAroma\Service\Store\TransformService;
use AirAroma\Transformer\Store\ProductTransformer;
use Illuminate\Validation\Factory as Validator;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request as Request;

class ProductService
{
    public function __construct(TransformService $transformService, Product $product, ProductRepository $productRepository, Config $config, Request $request, Validator $validator)
    {
        $this->product = $product;
        $this->transformService = $transformService;
        $this->productRepository = $productRepository;
        $this->config = $config;
        $this->request = $request;
        $this->validator = $validator;
    }

    /**
     * Get list of related products
     *
     * @param  $count integer
     * @param  $product array
     *
     * @return json
     */
    public function getRelatedProducts($count, $productId)
    {
        $productIds = [];
        $results = \DB::select( \DB::raw('select popular.prv_pro_id from (
                select prv_pro_id, sum(ordpro_quantity)
                from ordersproducts
                inner join productvariations on prv_id = ordpro_prv_id
                inner join productwebsites on proweb_prv_id = prv_id and proweb_website_id = 1
                where proweb_available = 1
                and prv_available = 1
                and ordpro_ord_id in (
                    select ordpro_ord_id
                    from ordersproducts
                    inner join productvariations on ordpro_prv_id = prv_id
                    where prv_pro_id = :productid )
                and prv_pro_id != :productid
                group by prv_pro_id
                order by sum(ordpro_quantity) desc
                limit 10
            ) as popular
            order by random()
            limit :count '), array('count' => $count, 'productid' => $productId));

        if(count($results)) {
            foreach($results as $result) {
                $productIds[] = $result->prv_pro_id;
            }
        }

        $productList = $this->productRepository->getProducts();
        return $this->transformService->transformResults($productList->whereIn('products.pro_id', $productIds), new ProductTransformer, 'categories,oilgroups,variations')->collection();

    }

    /**
     * Validate
     *
     * @param null
     * @return validator object
     */
    public function validateForm($fields)
    {
        $rules = [
            'required' => 'Required',
            'unique' => 'Item already exists',
            'min' => 'A minimum of :min required'
            ];
        return $this->validator->make($this->request->all(), $fields, $rules);
    }
}