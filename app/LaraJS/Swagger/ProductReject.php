<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 12:31:00
 */

/**
 * @OA\Get(
 *     path="/product-rejects",
 *     tags={"ProductReject"},
 *     summary="List ProductReject",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(
 *          name="search",
 *          in="query",
 *          @OA\Schema (type="string")
 *     ),
 *     @OA\Parameter(
 *          name="limit",
 *          in="query",
 *          @OA\Schema (type="integer")
 *     ),
 *     @OA\Parameter(
 *          name="ascending",
 *          in="query",
 *          description="0: asc, 1: desc",
 *          @OA\Schema (type="integer", default=1)
 *     ),
 *     @OA\Parameter(
 *          name="page",
 *          in="query",
 *          @OA\Schema (type="integer", default=1)
 *     ),
 *     @OA\Parameter(
 *          name="orderBy",
 *          in="query",
 *          description="column order by",
 *          @OA\Schema (type="string", default="updated_at")
 *     ),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 *
 * @OA\Post(
 *     path="/product-rejects",
 *     tags={"ProductReject"},
 *     summary="Create ProductReject",
 *     security={{"authApi":{}}},
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id", "product_id", "product_detail_id"},
 *                  @OA\Property(property="total", type="INT", default="NULL", example="1746", description=""),
     *                  @OA\Property(property="price", type="FLOAT", default="NULL", example="6206.91", description=""),
     *                  @OA\Property(property="note", type="VARCHAR", default="NULL", example="Demarco Larson", description=""),
 *                  @OA\Property(property="product_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  @OA\Property(property="product_detail_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  x="{{SWAGGER_PROPERTY_JSON_CONTENT_NOT_DELETE_THIS_LINE}}"
 *              )
 *          )
 *     ),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 * @OA\Get(
 *     path="/product-rejects/{id}",
 *     tags={"ProductReject"},
 *     summary="Edit ProductReject",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 *
 * @OA\Put(
 *     path="/product-rejects/{id}",
 *     tags={"ProductReject"},
 *     summary="Update ProductReject",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id", "product_id", "product_detail_id"},
 *                  @OA\Property(property="total", type="INT", default="NULL", example="1746", description=""),
     *                  @OA\Property(property="price", type="FLOAT", default="NULL", example="6206.91", description=""),
     *                  @OA\Property(property="note", type="VARCHAR", default="NULL", example="Demarco Larson", description=""),
 *                  @OA\Property(property="product_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  @OA\Property(property="product_detail_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  x="{{SWAGGER_PROPERTY_JSON_CONTENT_NOT_DELETE_THIS_LINE}}"
 *              )
 *          )
 *     ),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 *
 * @OA\Delete(
 *     path="/product-rejects/{id}",
 *     tags={"ProductReject"},
 *     summary="Delete ProductReject",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 */

/**
 * @OA\Schema(
 *     type="object",
 *     title="ProductReject",
 *     required={"id", "product_id", "product_detail_id"},
 * )
 */
class ProductReject
{
    /**
     * @OA\Property(property="id", type="BIGINT", description="AUTO_INCREMENT")
     */

    /**
     * <###> @OA\Property(property="total", type="INT", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="price", type="FLOAT", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="note", type="VARCHAR", default="NULL", description="")
     */

    /**
     * @OA\Property(property="product_id", default="NONE", description="hasMany")
     * @var Product
     */

    /**
     * @OA\Property(property="product_detail_id", default="NONE", description="hasMany")
     * @var ProductDetail
     */

    //{{SWAGGER_PROPERTY_NOT_DELETE_THIS_LINE}}

    /**
     * @OA\Property(property="created_at", type="TIMESTAMP", default="NULL", description="")
     */

    /**
     * @OA\Property(property="updated_at", type="TIMESTAMP", default="NULL", description="")
     */

    /**
     * @OA\Property(property="deleted_at", type="TIMESTAMP", default="NULL", description="")
     */
}
