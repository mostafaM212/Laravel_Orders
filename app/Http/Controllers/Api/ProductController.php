<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;

use App\Requests\Products\CreateProductValidator;
use App\Requests\Products\UpdateProductValidator;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends BaseController
{
   public $productService ;
    public function __construct(ProductService $productService){
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $page = $request->query('page', 1);   // default = 1
        $size = $request->query('size', 10);  // default = 10
        $products = $this->productService->getProducts($page,$size);
        return $this->sendResponse($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductValidator $createProductValidator)
    {
        //
        if (!empty($createProductValidator->getErrors())){
            return response()->json($createProductValidator->getErrors(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $product = $this->productService->createProduct($createProductValidator->request->all());
        return $this->sendResponse($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $product = $this->productService->getProductById($id);
        return $this->sendResponse($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductValidator $updateProductValidator, string $id)
    {
        //
        if (!empty($updateProductValidator->getErrors())){
            return response()->json($updateProductValidator->getErrors(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $product = $this->productService->updateProduct($id,$updateProductValidator->request->all());
        return $this->sendResponse($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        if (Auth::id() !== $product->user_id){
            return  $this->sendResponse('you are not authorized to delete this product',403,403);
        }
         $this->productService->deleteProduct($product->id);
        return $this->sendResponse('product deleted successfully');
    }
}
