<?php

namespace AirAroma\Repository\Store;

use AirAroma\Model\Product;
use AirAroma\Model\Producttranslations;
use AirAroma\Model\Productimages;
use AirAroma\Model\Productvariations;
use AirAroma\Model\Oilgroupsproduct;
use AirAroma\Model\Productwebsite;
use Illuminate\Http\Request;
use DB;



class ProductRepository
{
    /**
     *
     *
     * @var array
     */
    public function __construct(
    	Product $product,
    	Productvariations $productVariations,
        Producttranslations $productTranslations,
        Productwebsite $productWebsite,
        Productimages $productimages,
        Request $request,
        Oilgroupsproduct $oilgroupsproduct)
    {
        $this->product = $product;
        $this->request = $request;
        $this->productVariations = $productVariations;
        $this->productTranslations = $productTranslations;
        $this->productWebsites = $productWebsite;
        $this->oilgroupsproduct = $oilgroupsproduct;
        $this->productimages = $productimages;
    }

    /**
     * Get product item
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getProductBySlug($categorySlug, $productSlug)
    {
        $products = $this->getProducts();

        $products->where('pro_slug', $productSlug);

        if (isset($categorySlug)) {
            $products->where('cat_slug', $categorySlug);
        }

        return $products;
    }

    /**
     * Get product item
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getProductDetailsById($productIds)
    {
        return $this->productVariations
            ->join('productwebsites', function($join) {
                $join->on('productwebsites.proweb_prv_id', '=', 'productvariations.prv_id');
                $join->where('productwebsites.proweb_website_id', '=', websiteId());
            }, null, null, 'full')
            ->join('products', 'products.pro_id', '=', 'productvariations.prv_pro_id')
            ->join('category', 'category.cat_id', '=', 'products.pro_cat_id')
            ->join('colours', 'colours.col_id', '=', 'productvariations.prv_col_id')
            ->join('unitsizes', 'unitsizes.uni_id', '=', 'productvariations.prv_uni_id')
            ->whereIn('productvariations.prv_id', $productIds);
    }

    public function getProductImagesById($productIds)
    {
        $pro =  $this->productimages
            ->where('pri_pro_id', $productIds)->get();

        return $pro;
    }

    /**
     * Fetch all products from database
     *
     * @return Model
     */
    public function getProducts($variationId = null)
    {
        return $this->product
            ->select('pro_id','pro_name','pro_description','pro_slug','pro_title','pro_linkprefix','pro_characteristics','pro_quality', 'pro_meta_desc')
            ->join('category', 'category.cat_id', '=', 'products.pro_cat_id')
            ->join('productvariations', 'products.pro_id', '=', 'productvariations.prv_pro_id')
                ->join('productwebsites', function($join) {
                    $join->on('productwebsites.proweb_prv_id', '=', 'productvariations.prv_id');
                    $join->where('productwebsites.proweb_website_id', '=', websiteId());
                })
                ->with(['variations' => function($query) use ($variationId) {
                $query->where('proweb_website_id', websiteId());
                $query->where('proweb_available', 1);
                if ($variationId) {
                    $query->where('prv_id', $variationId);
                }
            }])->distinct('pro_id');
    }

    /**
     * Fetch all products from database without Variation List
     *
     * @return Model
     */
    public function getProductswithoutVariation($variationId = null)
    {
        $productList = $this->product
            ->select('pro_id','pro_name','pro_description','pro_slug','pro_linkprefix', 'cat_name', DB::raw('SUM(proweb_available) As available'))
            ->join('category', 'category.cat_id', '=', 'products.pro_cat_id')
            ->join('productvariations', 'products.pro_id', '=', 'productvariations.prv_pro_id')
                ->join('productwebsites', function($join) {
                    $join->on('productwebsites.proweb_prv_id', '=', 'productvariations.prv_id');
                    $join->where('productwebsites.proweb_website_id', '=', websiteId());
                })
                ->distinct('pro_id');
        return $productList;
    }

    /**
     * Get list of products
     * @param  $request request fields
     *
     * @return json
     */
    public function getProductsByCategory($category)
    {
        $products = $this->getProducts();

        $products->where('category.cat_slug', $category);

        return $products;
    }

    /**
     * Get list of products
     * @param  $request request fields
     *
     * @return json
     */
    public function getProductsByFeatured()
    {
        $products = $this->getProducts();

        $products->where('products.pro_featured', true)->get();

        return $products;
    }

    /**
     * insert Product
     * @param  $request request fields
     *
     * @return json
     */
    public function insertProduct()
    {

        // Inserting row in Products table
        $product = $this->product->create([
            'pro_cat_id' => (int) $this->request->get('product-category'),
            'pro_name' => $this->request->get('pro_name'),
            'pro_description' => $this->request->get('pro_description'),
            'pro_characteristics' => $this->request->get('pro_characteristics'),
            'pro_quality' => $this->request->get('pro_quality'),
            'pro_slug' => $this->request->get('pro_slug'),
            'pro_image_delete' => '',
            'pro_imagetile_delete' => '',
            'pro_linkprefix' => $this->request->get('pro_linkprefix'),
            'pro_title' => '',
            'pro_weight' => 1,
        ]);

        for ($x = 0; $x < $this->request->get('imgrowcount'); $x++) {

            if ($this->request->file('image')[$x] != null)
            {
                $image = $this->request->file('image')[$x];
                $this->request->file('image')[$x]->move(
                    base_path() . '/public/images/tiles/', $image->getClientOriginalName()
                );

                $fullscreen = 0;

                if($this->request->get('chkfullscreen')[$x] != null)
                {
                    $fullscreen = 1;
                }

                $this->productimages->create([
                'pri_image' => '/images/tiles/'.$image->getClientOriginalName(),
                'pri_pro_id' => (int) $product->pro_id,
                'pri_fullscreen' => $fullscreen
            ]);
            }

        }

        // Inserting row in Product Translation table
        $this->productTranslations->create([
            'prt_pro_id' => (int) $product->pro_id,
            'prt_website_id' => websiteId(),
            'prt_pro_name' => $this->request->get('pro_name'),
            'prt_pro_description' => $this->request->get('pro_description'),
            'prt_pro_slug' => $this->request->get('pro_slug')
            ]);

        // Inserting row in OilGroupProducts table
        if ($this->request->get('oil-group') != "0")
        {
            $this->oilgroupsproduct->create([
                'olgpro_pro_id' => (int) $product->pro_id,
                'olgpro_olg_id' => (int) $this->request->get('oil-group')
                ]);
        }

        //Inserting row in ProductVariations table
        $prodVar = $this->request->get('unitsizes');
        $counter = 0;

        foreach($prodVar as $pro)
        {
            $prodVariations = $this->productVariations->create([
                'prv_pro_id' => (int) $product->pro_id,
                'prv_col_id' => (int) $this->request->get('colours')[$counter],
                'prv_uni_id' => (int) $this->request->get('unitsizes')[$counter],
                'prv_available' => 1,
                'prv_shippingunits' => (int) $this->request->get('shippingunits')[$counter],
                'prv_shippingweight' => (int) $this->request->get('shippingweight')[$counter],
                'prv_shippingdimensions' => $this->request->get('shippingdimensions')[$counter],
            ]);

            // Adding Thumbnails and Tiles
            $tile = $this->request->file('tile')[$counter];
            if ($tile != null)
            {
                $this->request->file('tile')[$counter]->move(
                    base_path() . '/public/images/tiles/', $tile->getClientOriginalName()
                );

                $this->productVariations->where('prv_id', $prodVariations->prv_id)
                    ->update([
                'prv_image' => '/images/tiles/'.$tile->getClientOriginalName(),
                ]);
            }

            $thumb = $this->request->file('thumb')[$counter];
            if ($thumb != null)
            {
                $this->request->file('thumb')[$counter]->move(
                    base_path() . '/public/images/thumbnails/', $thumb->getClientOriginalName()
                );

                $this->productVariations->where('prv_id', $prodVariations->prv_id)
                    ->update([
                'prv_imagetile' => '/images/thumbnails/'.$thumb->getClientOriginalName(),
                ]);
            }

            $available = 0;
            $outofStock = 0;

            if($this->request->get('chkAvailable')[$counter] != null)
            {
                $available = 1;
            }
            if($this->request->get('outofStock')[$counter] != null)
            {
                $outofStock = 1;
            }

            $this->productWebsites->create([
                'proweb_prv_id' => (int) $prodVariations->prv_id,
                'proweb_price' => (float) $this->request->get('txtPrice')[$counter],
                'proweb_website_id' => websiteId(),
                'proweb_available' => $available,
                'proweb_outofstock' => $outofStock
            ]);

            $counter++;
        }

    }

    /**
     * Get list of products by category and group
     *
     * @param  $category product category
     * @param  $group oil group
     *
     * @return json
     */
    public function getProductsByCategoryGroup($category, $group)
    {

        $products = $this->getProducts();

        $products->join('oilgroupsproducts', 'oilgroupsproducts.olgpro_pro_id', '=', 'products.pro_id');
        $products->join('oilgroups', 'oilgroups.olg_id', '=', 'oilgroupsproducts.olgpro_olg_id');
        $products->where('category.cat_slug', $category);
        $products->where('olg_slug', $group);

        return $products;
    }

    /**
     * Get Product Details by Id
     *
     * @param string $Id
     * @return \Illuminate\Database\Eloquent\Model
     */

    public function getProductDetails($Id)
    {

        return $this->product
                ->join('producttranslations', function ($join) {
                     $join->on('products.pro_id', '=', 'producttranslations.prt_pro_id');
                     $join->where('producttranslations.prt_website_id', '=', websiteId());
                })
                ->join('productvariations', 'products.pro_id', '=', 'productvariations.prv_pro_id')
                ->join('productwebsites', function($join) {
                    $join->on('productwebsites.proweb_prv_id', '=', 'productvariations.prv_id');
                    $join->where('productwebsites.proweb_website_id', '=', websiteId());
                })
                ->leftjoin('oilgroupsproducts', 'oilgroupsproducts.olgpro_pro_id', '=', 'products.pro_id')
                ->leftjoin('oilgroups', 'oilgroups.olg_id', '=', 'oilgroupsproducts.olgpro_olg_id')
                ->join('unitsizes', 'unitsizes.uni_id', '=', 'productvariations.prv_uni_id')
                ->join('colours', 'colours.col_id', '=', 'productvariations.prv_col_id')
                ->join('category', 'category.cat_id', '=', 'products.pro_cat_id')
                ->where('pro_id', $Id)
                ->orderBy('producttranslations.prt_pro_name', 'asc')
                ->orderBy('unitsizes.uni_size', 'asc');
    }

    public function getProductStock($prvid)
    {
        return $this->productWebsites
            ->where('proweb_prv_id', $prvid)
            ->where('proweb_website_id', websiteId())->get();
    }

    /* Update Product Details by Id */

    public function updateProduct($id)
    {
        $prodWeb = $this->productWebsites
            ->join('productvariations', 'productvariations.prv_id', '=', 'productwebsites.proweb_prv_id')
            ->where('prv_pro_id', $id)
            ->where('proweb_website_id', websiteId())->get();

        $prodImg = $this->productimages->where('pri_pro_id', $id)->get();

        foreach ($prodImg as $proi)
        {
            if ($this->request->get('imghyper_'.$proi->pri_id) != null)
            {
                $image = $this->request->file('image'.'_'.$proi->pri_id);

                if ($image != null)
                {
                    $this->request->file('image'.'_'.$proi->pri_id)->move(
                        base_path() . '/public/images/tiles/', $image->getClientOriginalName()
                    );

                    $fullscreen = 0;

                    if($this->request->get('chkfullscreen_'.$proi->pri_id) != null)
                    {
                        $fullscreen = 1;
                    }

                    $this->productimages->where('pri_id', $proi->pri_id)
                        ->update([
                    'pri_image' => '/images/tiles/'.$image->getClientOriginalName(),
                    'pri_fullscreen' => $fullscreen
                    ]);
                }
                else
                {
                    $fullscreen = 0;

                    if($this->request->get('chkfullscreen_'.$proi->pri_id) != null)
                    {
                        $fullscreen = 1;
                    }

                    $this->productimages->where('pri_id', $proi->pri_id)
                        ->update([
                    'pri_fullscreen' => $fullscreen
                    ]);
                }
            }
            else
            {
                $this->productimages->where('pri_id', $proi->pri_id)->delete();
            }

        }

        for ($x = 0; $x < $this->request->get('imgrowcount'); $x++) {

            if ($this->request->file('image')[$x] != null)
            {
                $image = $this->request->file('image')[$x];
                $this->request->file('image')[$x]->move(
                    base_path() . '/public/images/tiles/', $image->getClientOriginalName()
                );

                $fullscreen = 0;

                if($this->request->get('chkfullscreen')[$x] != null)
                {
                    $fullscreen = 1;
                }

                $this->productimages->create([
                'pri_image' => '/images/tiles/'.$image->getClientOriginalName(),
                'pri_pro_id' => $id,
                'pri_fullscreen' => $fullscreen
            ]);
            }

        }

        foreach($prodWeb as $pro)
        {
            $available = 0;
            $outofStock = 0;

            if($this->request->get('chkAvailable_'.$pro->proweb_prv_id) != null)
            {
                $available = 1;
            }
            if($this->request->get('outofStock_'.$pro->proweb_prv_id) != null)
            {
                $outofStock = 1;
            }

            $tile = $this->request->file('tile'.'_'.$pro->proweb_prv_id);

            if ($tile != null)
            {
                $this->request->file('tile'.'_'.$pro->proweb_prv_id)->move(
                    base_path() . '/public/images/tiles/', $tile->getClientOriginalName()
                );

                $this->productVariations->where('prv_id', $pro->proweb_prv_id)
                    ->update([
                'prv_image' => '/images/tiles/'.$tile->getClientOriginalName(),
                ]);
            }

            $thumb = $this->request->file('thumb'.'_'.$pro->proweb_prv_id);
            if ($thumb != null)
            {
                $this->request->file('thumb'.'_'.$pro->proweb_prv_id)->move(
                    base_path() . '/public/images/thumbnails/', $thumb->getClientOriginalName()
                );

                $this->productVariations->where('prv_id', $pro->proweb_prv_id)
                    ->update([
                'prv_imagetile' => '/images/thumbnails/'.$thumb->getClientOriginalName(),
                ]);
            }

            $this->productVariations->where('prv_id', $pro->proweb_prv_id)
                    ->update([
                'prv_shippingunits' => $this->request->get('shipUnit_'.$pro->proweb_prv_id),
                'prv_shippingweight' => $this->request->get('shipWeight_'.$pro->proweb_prv_id),
                'prv_shippingdimensions' => $this->request->get('shipDimension_'.$pro->proweb_prv_id),
                ]);

            $this->productWebsites->where('proweb_id', $pro->proweb_id)
                ->update([
                'proweb_available' => $available,
                'proweb_outofstock' => $outofStock,
                'proweb_price' => $this->request->get('txtPrice_'.$pro->proweb_prv_id)
            ]);
        }

        $this->oilgroupsproduct->where('olgpro_pro_id', $id)
            ->update([
                'olgpro_olg_id' => $this->request->get('oil-group'),
            ]);

        $profeature = 0;

        if($this->request->get('pro_featured') != null)
        {
            $profeature = 1;
        }

        return $this->product->where('pro_id', $id)
            ->update([
                'pro_name' => $this->request->get('pro_name'),
                'pro_slug' => $this->request->get('pro_slug'),
                'pro_title' => $this->request->get('pro_title'),
                'pro_featured' => $profeature,
                'pro_linkprefix' => $this->request->get('pro_linkprefix'),
                'pro_description' => $this->request->get('pro_description'),
                'pro_characteristics' => $this->request->get('pro_characteristics'),
                'pro_quality' => $this->request->get('pro_quality'),
                'pro_cat_id' => $this->request->get('product-category'),
            ]);
    }

}