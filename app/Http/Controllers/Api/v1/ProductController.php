<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 12:13:07
 * File: Product.php
 */

namespace App\Http\Controllers\Api\v1;

use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\ProductDetail;
use App\Models\Member;
use App\Services\QueryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Validation\Rule;

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
			$product->code = Product::PREFIX_CODE.str_pad($product->id,2,'0',STR_PAD_LEFT);
			$productDetails = json_decode($requestAll['product_details'],true)??[];
			$stock_in = 0;
			foreach($productDetails as $key =>  $detail){
				$productDetails[$key]['product_id'] = $product->id;
				$stock_in += $detail['amount'];
			}
			$product->stock_in = $stock_in;
			$product->save();
			
			ProductDetail::upsert($productDetails,['product_id','size_id','color_id'],['amount','price']);
			
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
			foreach ($productDetails as $key => $detail) {
				unset($productDetails[$key]['created_at']);
				unset($productDetails[$key]['updated_at']);
				$productDetails[$key]['product_id'] = $product->id;
				$productDetails[$key]['id'] = $productDetails[$key]['id'] ?? \Str::uuid();		
            }
			// dd($productDetails);
			ProductDetail::upsert($productDetails, ['id	','product_id'], ['color_id', 'size_id','amount', 'price']);
			$idDeletes = $request->get('idDeletes') ?  explode(',',$request->get('idDeletes')) :[];
			$idDeletes && ProductDetail::whereIn('id',$idDeletes)->delete();

			return $this->jsonData($productDetails);
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
	        // $product->colors()->detach();
            // $product->sizes()->detach();
           foreach($product->productDetails as $detail){
			   ProductDetail::find($detail->id)->delete();
		   }
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
			$productDetails = ProductDetail::where('product_id',$id)
			->where('amount','>',ProductDetail::OUT_STOCK)->get()->toArray();
			$sizesId = array_unique(\Arr::pluck($productDetails,'size_id'));
			$colorsId = array_unique(\Arr::pluck($productDetails,'color_id'));
			$sizes = [];
			$colors = [];
			foreach($sizesId as $sizeId){
				$size = Size::find($sizeId);
				array_push($sizes,$size);
			}
			foreach($colorsId as $colorId){
				$color = Color::find($colorId);
				array_push($colors,$color);
			}
			$members = Member::latest('amount')->limit(Member::ORDER_AMOUNT)->get();
			
			

            return $this->jsonData([
				'sizes' => $sizes,
				'colors' => $colors,
				'members' => $members,
				'product_details' => $productDetails

			]);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
	}
}
