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
use App\Models\ProductReject;
use App\Models\Member;
use App\Services\QueryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreProductPaymentRequest;
use  Illuminate\Support\Carbon;

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
            $queryService->columnSearch = ['member.name'];
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
			$product = Product::find($request->product_id);
			$totalPrice = $productDetail->price * $requestAll['total'];
			$requestAll['price'] = $totalPrice - ($totalPrice * $product->discount /100);
			$productDetail->decrement('amount',$requestAll['total']);
			$productPayment = new ProductPayment();
			$productPayment->fill($requestAll);
			$productPayment->save();
			
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
			ProductReject::create([
				'total' => $request->get('total'),
				'price' => $request->get('price'),
				'note'  => $request->get('memo'),
				'product_id' => $product->id,
				'product_detail_id' =>  $productDetail->id,
			]);
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
	public function totalSold(Request $request){
		try{
			$updated_at = $request->updated_at;
			$startDate = Carbon::parse($updated_at[0])->startOfDay();
			$endDate = Carbon::parse($updated_at[1])->endOfDay();

			// $totalSold = ProductPayment::sum('price');
			$totalSold = \DB::table('product_payments')
			->where('deleted_at','=',null)
			->whereBetween('updated_at',[$startDate,$endDate])
			->sum('price');
			return $this->jsonData($totalSold);

		}catch (\Exception $e) {
			// \DB::rollback();
	    	return $this->jsonError($e);
	    }
	}

	public function chart(Request $request){
		try{
			$updated_at = $request->updated_at;
			$startDate = Carbon::parse($updated_at[0])->startOfDay();
			$endDate = Carbon::parse($updated_at[1])->endOfDay();
			$productPayment = \DB::table('product_payments')
			->where('deleted_at','=',null)
			->select([\DB::raw('SUM(price) as price'),'updated_at as date'])
			->whereBetween('updated_at',[$startDate,$endDate])
			->groupBy(\DB::raw('Date(updated_at)'))
			->get();
			$chartData = [
				'date' => [],
				'value' => []
			];
			foreach($productPayment as $item){
				$chartData['date'][] = date('Y-m-d', strtotime($item->date)) ;
				$chartData['value'][] = $item->price;
			}
			return $this->jsonData($chartData);


		}catch (\Exception $e) {
			// \DB::rollback();
	    	return $this->jsonError($e);
	    }
	}
}
