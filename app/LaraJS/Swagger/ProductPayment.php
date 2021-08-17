<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 12:27:50
 */

/**
 * @OA\Get(
 *     path="/product-payments",
 *     tags={"ProductPayment"},
 *     summary="List ProductPayment",
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
 *     path="/product-payments",
 *     tags={"ProductPayment"},
 *     summary="Create ProductPayment",
 *     security={{"authApi":{}}},
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id", "product_id", "size_id", "color_id", "member_id"},
 *                  @OA\Property(property="total", type="INT", default="0", example="5987", description=""),
     *                  @OA\Property(property="price", type="FLOAT", default="NULL", example="1809.85", description=""),
     *                  @OA\Property(property="note", type="TEXT", default="NULL", example="Ut non est voluptas nemo reprehenderit ut. In voluptatibus eos sit eveniet similique. Molestias nostrum voluptatem est consequuntur qui. In placeat libero iste officiis omnis. Veniam deserunt eaque quo ut.", description=""),
 *                  @OA\Property(property="product_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  @OA\Property(property="size_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  @OA\Property(property="color_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  @OA\Property(property="member_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  x="{{SWAGGER_PROPERTY_JSON_CONTENT_NOT_DELETE_THIS_LINE}}"
 *              )
 *          )
 *     ),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 * @OA\Get(
 *     path="/product-payments/{id}",
 *     tags={"ProductPayment"},
 *     summary="Edit ProductPayment",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 *
 * @OA\Put(
 *     path="/product-payments/{id}",
 *     tags={"ProductPayment"},
 *     summary="Update ProductPayment",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id", "product_id", "size_id", "color_id", "member_id"},
 *                  @OA\Property(property="total", type="INT", default="0", example="5987", description=""),
     *                  @OA\Property(property="price", type="FLOAT", default="NULL", example="1809.85", description=""),
     *                  @OA\Property(property="note", type="TEXT", default="NULL", example="Ut non est voluptas nemo reprehenderit ut. In voluptatibus eos sit eveniet similique. Molestias nostrum voluptatem est consequuntur qui. In placeat libero iste officiis omnis. Veniam deserunt eaque quo ut.", description=""),
 *                  @OA\Property(property="product_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  @OA\Property(property="size_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  @OA\Property(property="color_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  @OA\Property(property="member_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
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
 *     path="/product-payments/{id}",
 *     tags={"ProductPayment"},
 *     summary="Delete ProductPayment",
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
 *     title="ProductPayment",
 *     required={"id", "product_id", "size_id", "color_id", "member_id"},
 * )
 */
class ProductPayment
{
    /**
     * @OA\Property(property="id", type="BIGINT", description="AUTO_INCREMENT")
     */

    /**
     * <###> @OA\Property(property="total", type="INT", default="0", description="")
     */

    /**
     * <###> @OA\Property(property="price", type="FLOAT", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="note", type="TEXT", default="NULL", description="")
     */

    /**
     * @OA\Property(property="product_id", default="NONE", description="hasMany")
     * @var Product
     */

    /**
     * @OA\Property(property="size_id", default="NONE", description="hasMany")
     * @var Size
     */

    /**
     * @OA\Property(property="color_id", default="NONE", description="hasMany")
     * @var Color
     */

    /**
     * @OA\Property(property="member_id", default="NONE", description="hasMany")
     * @var Member
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
