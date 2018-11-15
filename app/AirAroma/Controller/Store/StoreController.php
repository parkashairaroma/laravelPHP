<?php

namespace AirAroma\Controller\Store;

use AirAroma\Repository\Store\ProductRepository;
use AirAroma\Repository\Store\StoreRepository;
use AirAroma\Repository\Store\OrderRepository;
use AirAroma\Service\FormService;
use AirAroma\Service\HmvcService;
use AirAroma\Service\Store\TransformService;
use AirAroma\Transformer\Store\ProductTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Console\Scheduling\Schedule;


class StoreController extends Controller
{

    public function __construct(
        HmvcService $hmvcService,
        TransformService $transformService,
        FormService $formService,
        StoreRepository $storeRepository,
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        Schedule $schedule
    ) {

        $this->hmvcService = $hmvcService;
        $this->transformService = $transformService;
        $this->storeRepository = $storeRepository;
        $this->formService = $formService;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->schedule = $schedule;
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function showPage()
    {
        return view('pages'.request()->get('blade'));
    }

    public function showTranslationPage()
    {
        return view('translatingstore');
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function viewStore()
    {
        $products = $this->productRepository->getProductsByFeatured();
        $products = $this->transformService->transformResults($products, new ProductTransformer, 'categories,oilgroups,variations')->collection();

        $bannerRepository = app('AirAroma\Repository\BannerRepository');

        $banners = $bannerRepository->getBannersFromSiteConfig(['status' => 1, 'limit' => 6]);

        return view('pages.store')->with(compact('products', 'banners'));
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function viewCart()
    {
        $sessionCart = session()->get('cart.products')?:[];
        $products = $this->storeRepository->getCart($sessionCart);
        $subtotal = $products->sum('subtotal');

        return view('pages.store.cart')->with(compact('products', 'sessionCart', 'subtotal'));
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function updateAddressBook()
    {
        $sessionCart = session()->get('cart.products')?:[];
        $products = $this->storeRepository->getCart($sessionCart);
        $subtotal = $products->sum('subtotal');

        return view('pages.store.cart')->with(compact('products', 'sessionCart', 'subtotal'));
    }


    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function viewAromax()
    {
        $product = $this->transformService->transformResults(
            $this->productRepository->getProductBySlug(null, 'aromax'),
            new ProductTransformer,
            'categories,oilgroups,variations'
        )->item();

        $producttileurl = explode("/", $product['link']);

        view()->share('storeImage', url('/images/tiles/tile-aromax-silver.jpg'));

        return view('pages.store.aromax')->with(compact('product'));
    }


     /**
     * Description
     * @param type $lang
     * @return type
     */
    public function viewOils($lang = null, $categorySlug = null, $productSlug = null, $groupSlug = null)
    {
        if (! isLanguageSet($lang)) {
            $groupSlug = $productSlug;
            $productSlug = $categorySlug;
            $categorySlug = $lang;
        }

        $pageName = $this->storeRepository->parsePageName($categorySlug);

        if ($pageName == "Fragrances" || $pageName == "Candles")
        {
            $a=1;
        }
        else
        {
            return abort(404);
        }

        if ($productSlug == "group") {

            $oilGroup = $this->storeRepository->getOilGroupBySlug($groupSlug);

            if ($oilGroup != null) {
                $group = $oilGroup['olg_slug'];
            }
        }

        $currentSubNav = $this->storeRepository->getCurrentSubNavByCategorySlug($categorySlug);

        if ($productSlug && ! isset($group)) {

            $productItem = $this->productRepository->getProductBySlug($categorySlug, $productSlug);

            if (!count($productItem->get())) {
                return abort(404);
            }

            $product = $this->transformService->transformResults(
                $productItem,
                new ProductTransformer,
                'categories,oilgroups,variations'
            )->item();

            if (count($product['variations']) == 0)
            {
                return abort(404);
            }

            $productimages = $this->productRepository->getProductImagesById($product['id']);

            $producttileurl = explode("/", $product['link']);

            if ($product['url'] == '/candles')
            {
                view()->share('storeImage', url('/images/tiles/tile-store-candle-'.$producttileurl[2].'.jpg'));
            }
            else
            {
                view()->share('storeImage', url('/images/tiles/tile-store-oils-'.$producttileurl[2].'.jpg'));
            }

            return view('pages.store.oil-product')->with(compact('product', 'categorySlug', 'currentSubNav', 'productimages'));
        }

        $oilgroups = $this->storeRepository->getOilgroupsList($categorySlug);

        if (isset($categorySlug) && ! isset($group)) {
            $products = $this->productRepository->getProductsByCategory($categorySlug);
        }

        if (isset($categorySlug) && isset($group)) {
            $products = $this->productRepository->getProductsByCategoryGroup($categorySlug, $group);
        }

        if (!isset($group)) {
            $group = '';
        }

        $products = $this->transformService->transformResults($products, new ProductTransformer, 'categories,oilgroups,variations')->collection();

        if (!count($products)) {
            return abort(404);
        }
        return view('pages.store.oils')->with(compact('products', 'categorySlug', 'oilgroups', 'group', 'pageName', 'currentSubNav'));
    }
}
