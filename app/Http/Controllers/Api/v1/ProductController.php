<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 12:13:07
 * File: Product.php
 */

namespace App\Http\Controllers\Api\v1;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Services\QueryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    /**
     * Product constructor.
     * @author tanmnt
     */
    public function __construct()
    {
        $this->middleware('permission:' . \ACL::PERMISSION_VISIT, ['only' => ['index']]);
        $this->middleware('permission:' . \ACL::PERMISSION_CREATE, ['only' => ['store']]);
        $this->middleware('permission:' . \ACL::PERMISSION_EDIT, ['only' => ['show', 'update']]);
        $this->middleware('permission:' . \ACL::PERMISSION_DELETE, ['only' => ['destroy']]);
    }

	/**
	 * lists
	 * @param Request $request
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function index(Request $request): JsonResponse
	{
		try {
			$limit = $request->get('limit', 25);
			$ascending = $request->get('ascending', '');
			$orderBy = $request->get('orderBy', '');
			$search = $request->get('search', '');
			$betweenDate = $request->get('updated_at', []);

			$queryService = new QueryService(new Product);
            $queryService->select = [];
            $queryService->columnSearch = ['name'];
            $queryService->withRelationship = ['category','productDetails.size','productDetails.color'];
            $queryService->search = $search;
            $queryService->betweenDate = $betweenDate;
            $queryService->limit = $limit;
            $queryService->ascending = $ascending;
            $queryService->orderBy = $orderBy;

            $query = $queryService->queryTable();
            $query = $query->paginate($limit);
            $product = $query->toArray();

			return $this->jsonTable($product);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * create
	 * @param StoreProductRequest $request
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function store(StoreProductRequest $request): JsonResponse
	{
		try {
			$requestAll = $request->all();
			$requestAll['stock_out'] = 0;
			$requestAll['inventory'] = 0;	
		    $product = new Product();
		    $product->fill($requestAll);
			if($request->hasFile('image')){
				$disk = \Storage::disk();
				$fileName = $disk->putFile(Product::FOLDER_UPLOAD,$request->file('image'));
				$product->image = $disk->url($fileName);
			}
            $product->save();
			$productDetails = json_decode($requestAll['product_details'],true)??[];
			foreach($productDetails as $key =>  $detail){
				$productDetails[$key]['product_id'] = $product->id;
			}
			
			ProductDetail::upsert($productDetails,['product_id','size_id','color_id'],['amount','price']);

			$colorId = $request->get('color_id', []);
			if($colorId){
				$product->colors()->attach($colorId);
			}
           
            $sizeId = $request->get('size_id', []);
			if($sizeId){
				$product->sizes()->attach($sizeId);
			}
            
			return $this->jsonData($product, Response::HTTP_CREATED);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * get once by id
	 * @param Product $product
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function show(Product $product): JsonResponse
	{
		try {	
			$product->load('productDetails');
			return $this->jsonData($product);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * update once by id
	 * @param StoreProductRequest $request
	 * @param Product $product
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function update(StoreProductRequest $request, Product $product): JsonResponse
	{
		try {
			$urlImageOld = parse_url($product->image,PHP_URL_PATH);
		    $product->fill($request->all());
			if($request->hasFile('image')){	
				$disk = \Storage::disk();
				$fileName = $disk->putFile(Product::FOLDER_UPLOAD,$request->file('image'));
				if($disk->exists($urlImageOld)){
					$disk->delete($urlImageOld);
				}
				$product->image = $disk->url($fileName);
			}
            $product->save();
			$productDetails = json_decode($request->product_details,true)??[];
			foreach($productDetails as $key =>  $detail){
					unset($productDetails[$key]['created_at']);
					$productDetails[$key]['updated_at'] = now();
					$productDetails[$key]['product_id'] = $product->id;
			}
			ProductDetail::upsert($productDetails,['product_id','size_id','color_id'],['amount','price']);

            // $colorId = $request->get('color_id', []);
            // $product->colors()->sync($colorId);
            // $sizeId = $request->get('size_id', []);
            // $product->sizes()->sync($sizeId);
           
           

			return $this->jsonData($product);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * delete once by id
	 * @param Product $product
	 * @return JsonResponse
	 * @author tanmnt
	 */
    public function destroy(Product $product): JsonResponse
    {
	    try {
			$urlImageOld = parse_url($product->image,PHP_URL_PATH);
			$disk = \Storage::disk();
			if($disk->exists($urlImageOld)){
				$disk->delete($urlImageOld);
			}
	        $product->colors()->detach();
            $product->sizes()->detach();
            $product->colors()->detach();
            $product->colors()->detach();
            //{{CONTROLLER_RELATIONSHIP_MTM_DELETE_NOT_DELETE_THIS_LINE}}
			$product->delete();

		    return $this->jsonMessage(trans('messages.delete'));
	    } catch (\Exception $e) {
	    	return $this->jsonError($e);
	    }
    }

    /**
     * get all data from Product
     * @return JsonResponse
     */
    public function getProduct(): JsonResponse
    {
        try {
            $products = Product::all();

            return $this->jsonData($products);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }
	/**
	 * 	
	 */
	public function detail($id){
		try {
			$productDetails = ProductDetail::where('product_id',$id)->get()->toArray();
			dd($productDetails);
			$sizesId = array_unique(\Arr::pluck($productDetails,'size_id'));
			$colorsId = array_unique(\Arr::pluck($productDetails,'color_id'));
			$sizes = Size::find($sizesId);
			$colors = Color::find($colorsId);
           

            return $this->jsonData([
				'sizes' => $sizes,
				'colors' => $colors
			]);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
	}
}
