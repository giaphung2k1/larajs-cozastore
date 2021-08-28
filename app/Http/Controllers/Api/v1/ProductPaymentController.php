<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 12:27:50
 * File: ProductPayment.php
 */

namespace App\Http\Controllers\Api\v1;

use App\Models\ProductPayment;
use App\Models\ProductDetail;
use App\Models\Product;
use App\Models\Member;
use App\Services\QueryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreProductPaymentRequest;

class ProductPaymentController extends Controller
{
    /**
     * ProductPayment constructor.
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

			$queryService = new QueryService(new ProductPayment);
            $queryService->select = [];
            $queryService->columnSearch = [];
            $queryService->withRelationship = ['product','size','color','member'];
            $queryService->search = $search;
            $queryService->betweenDate = $betweenDate;
            $queryService->limit = $limit;
            $queryService->ascending = $ascending;
            $queryService->orderBy = $orderBy;

            $query = $queryService->queryTable();
            $query = $query->paginate($limit);
            $productPayment = $query->toArray();

			return $this->jsonTable($productPayment);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * create
	 * @param StoreProductPaymentRequest $request
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function store(StoreProductPaymentRequest $request): JsonResponse
	{
		try {
			\DB::beginTransaction();
			$productDetail = ProductDetail::where('product_id',$request->product_id)
			->where('color_id',$request->color_id) 
			->where('size_id',$request->size_id)
			->where('amount','>',0)
			->first();
			if(!$productDetail){
				return $this->jsonMessage(trans('error.product_detail_not_found'),false,500);
			}
			$requestAll = $request->all();
			$requestAll['product_detail_id'] = $productDetail->id;
			$requestAll['price'] = $productDetail->price * $requestAll['total'];
			$productDetail->decrement('amount',$requestAll['total']);
			$productPayment = new ProductPayment();
			$productPayment->fill($requestAll);
			$productPayment->save();
			$product = Product::find($request->product_id);
			$product->stock_out += $requestAll['total'];
			$product->inventory = $product->stock_in - $product->stock_out;
			$product->save();
			Member::find($requestAll['member_id'])->increment('amount',$requestAll['total']);
			\DB::commit();
			return $this->jsonData($productPayment, Response::HTTP_CREATED);
		} catch (\Exception $e) {
			\DB::rollBack();
			return $this->jsonError($e);
		}
	}

	/**
	 * get once by id
	 * @param ProductPayment $productPayment
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function show(ProductPayment $productPayment): JsonResponse
	{
		try {
		    //{{CONTROLLER_RELATIONSHIP_MTM_SHOW_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($productPayment);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * update once by id
	 * @param StoreProductPaymentRequest $request
	 * @param ProductPayment $productPayment
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function update(StoreProductPaymentRequest $request, ProductPayment $productPayment): JsonResponse
	{
		try {
		    $productPayment->fill($request->all());
            $productPayment->save();
            //{{CONTROLLER_RELATIONSHIP_MTM_UPDATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($productPayment);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * delete once by id
	 * @param ProductPayment $productPayment
	 * @return JsonResponse
	 * @author tanmnt
	 */
    public function destroy(ProductPayment $productPayment): JsonResponse
    {
	    try {
	        //{{CONTROLLER_RELATIONSHIP_MTM_DELETE_NOT_DELETE_THIS_LINE}}
			$productPayment->delete();

		    return $this->jsonMessage(trans('messages.delete'));
	    } catch (\Exception $e) {
	    	return $this->jsonError($e);
	    }
    }

    public function rollback(Request $request, ProductPayment $productPayment){
		try {
			\DB::beginTransaction();
			// dd($request->all());
			$productDetail = ProductDetail::find($request->get('product_detail_id'));
			$productDetail->increment('amount',$request->total);
			$product = Product::find($request->product_id);
			$product->stock_out -= $request->total;
			$product->inventory = $product->stock_in - $product->stock_out;
			$product->save();
			Member::find($request->get('member_id'))->decrement('amount',$request->total);
	        $productPayment->delete();
			
			\DB::commit();
		    return $this->jsonMessage(trans('messages.delete'));
	    } catch (\Exception $e) {
			\DB::rollback();
	    	return $this->jsonError($e);
	    }
	}
	public function exportExcel(){
		try{
			set_time_limit(0);
			// $productPayment = \DB::table('product_payments as prop')
			// ->where([
			// 	'prop.total',
			// 	'prop.price',
			// 	'products.name as product_name',
			// 	'sizes.name as size_name',
			// 	'colors.name as color_name',
			// 	'members.name as member_name',
			// 	'prop.note',
			// 	'prop.updated_at',
			// ])
			// ->leftJoin('products','products.id','prop.id')
			// ->leftJoin('sizes','sizes.id','prop.size_id')
			// ->leftJoin('colors','colors.id','prop.color_id')
			// ->leftJoin('members','members.id','prop.member_id')
			// ->get();
			$productPayment = ProductPayment::all();
			$productPaymentNew = [];
			foreach($productPayment as $item){
				$productPaymentNew[] = [
					'id' => $item->id,
					'total' => $item->total,
					'price' => $item->price,
					'product_name' => $item->product->name,
					'size_name' => $item->size->name,
					'color_name' => $item->color->name,
					'member_name' => $item->member->name,
					'note' => $item->note,
					'updated_at'=> $item->updated_at,
				];
			}
			return $this->jsonData($productPaymentNew);
		}catch (\Exception $e) {
			// \DB::rollback();
	    	return $this->jsonError($e);
	    }
	}
}
