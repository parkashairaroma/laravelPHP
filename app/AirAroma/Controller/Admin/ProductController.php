<?php

namespace AirAroma\Controller\Admin;

use Storage;
use AirAroma\Model\Product;
use AirAroma\Repository\Store\ProductRepository;
use AirAroma\Repository\CategoryRepository;
use AirAroma\Repository\OilgroupRepository;
use AirAroma\Repository\ColourRepository;
use AirAroma\Repository\UnitSizeRepository;
use AirAroma\Service\Store\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{

    public function __construct(Request $request, ProductRepository $productRepository, ProductService $productService, Input $input, CategoryRepository $categoryRepository, OilgroupRepository $oilgroupRepository,ColourRepository $colourRepository, UnitSizeRepository $unitsizeRepository)
	{
		$this->request = $request;
		$this->productRepository = $productRepository;
        $this->productService = $productService;
        $this->input = $input;
        $this->categoryRepository = $categoryRepository;
        $this->oilgroupRepository = $oilgroupRepository;
        $this->colourRepository = $colourRepository;
        $this->unitsizeRepository = $unitsizeRepository;
	}

	/**
	 * get list of products
	 */
	public function getProducts()
	{
        $products = $this->productRepository->getProductswithoutVariation(null)->get();
        return view('admin.products.list')->with(compact('products'));
	}

    /**
	 * view/edit informtion of a product
	 */
	public function editProduct($id)
	{
        if ($this->request->isMethod('post')) {

            $fields = [
                'pro_name' => 'required',
                'pro_slug' => 'required',
                'pro_description' => 'required',
            ];

            $valid = $this->productService->validateForm($fields);

            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }

            $this->productRepository->updateProduct($id);
		}
        //Storage::put(base_path() . '/resources/pages/clients/sample.blade.php', '121212');
        $product = $this->productRepository->getProductDetails($id)->get();
        $productimages = $this->productRepository->getProductImagesById($id);
        $categories = $this->categoryRepository->getCategories();
        $oilgroups = $this->oilgroupRepository->getOilgroups();
        return view('admin.products.form')->with(compact('product', 'categories', 'oilgroups', 'productimages'));
	}

    /**
     * createe a product
     */
	public function createProduct()
	{
        if ($this->request->isMethod('post'))
        {
            $this->productRepository->insertProduct();

            return redirect('admin/products');
        }
        $categories = $this->categoryRepository->getCategories();
        $oilgroups = $this->oilgroupRepository->getOilgroups();
        $colours = $this->colourRepository->getColours();
        $unitsizes = $this->unitsizeRepository->getUnitSizes();
        return view('admin.products.form')->with(compact('categories', 'oilgroups', 'colours', 'unitsizes'));
	}


}