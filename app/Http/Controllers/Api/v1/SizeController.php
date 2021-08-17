<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 12:25:08
 * File: Size.php
 */

namespace App\Http\Controllers\Api\v1;

use App\Models\Size;
use App\Services\QueryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreSizeRequest;

class SizeController extends Controller
{
    /**
     * Size constructor.
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

			$queryService = new QueryService(new Size);
            $queryService->select = [];
            $queryService->columnSearch = ['name'];
            $queryService->withRelationship = ['products'];
            $queryService->search = $search;
            $queryService->betweenDate = $betweenDate;
            $queryService->limit = $limit;
            $queryService->ascending = $ascending;
            $queryService->orderBy = $orderBy;

            $query = $queryService->queryTable();
            $query = $query->paginate($limit);
            $size = $query->toArray();

			return $this->jsonTable($size);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * create
	 * @param StoreSizeRequest $request
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function store(StoreSizeRequest $request): JsonResponse
	{
		try {
		    $size = new Size();
		    $size->fill($request->all());
            $size->save();
			return $this->jsonData($size, Response::HTTP_CREATED);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * get once by id
	 * @param Size $size
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function show(Size $size): JsonResponse
	{
		try {
			return $this->jsonData($size);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * update once by id
	 * @param StoreSizeRequest $request
	 * @param Size $size
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function update(StoreSizeRequest $request, Size $size): JsonResponse
	{
		try {
		    $size->fill($request->all());
            $size->save();
			return $this->jsonData($size);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * delete once by id
	 * @param Size $size
	 * @return JsonResponse
	 * @author tanmnt
	 */
    public function destroy(Size $size): JsonResponse
    {
	    try {
			$size->delete();

		    return $this->jsonMessage(trans('messages.delete'));
	    } catch (\Exception $e) {
	    	return $this->jsonError($e);
	    }
    }

    /**
     * get all data from Size
     * @return JsonResponse
     */
    public function getSize(): JsonResponse
    {
        try {
            $sizes = Size::all();

            return $this->jsonData($sizes);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }
}
