<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 12:13:07
 */

/**
 * @OA\Get(
 *     path="/products",
 *     tags={"Product"},
 *     summary="List Product",
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
 *     path="/products",
 *     tags={"Product"},
 *     summary="Create Product",
 *     security={{"authApi":{}}},
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id", "name", "category_id", "code"},
 *                  @OA\Property(property="name", type="VARCHAR", default="NONE", example="Josie Legros I", description=""),
     *                  @OA\Property(property="image", type="VARCHAR", default="NULL", example="Morton Ritchie", description=""),
     *                  @OA\Property(property="description", type="TEXT", default="NULL", example="Ad odit optio temporibus veritatis. Quia alias consequatur eos et. Reprehenderit beatae vel saepe quos. Perspiciatis vel ut aut quaerat cupiditate ipsa.", description=""),
     *                  @OA\Property(property="stock_in", type="INT", default="NULL", example="5052", description=""),
     *                  @OA\Property(property="stock_out", type="INT", default="NULL", example="2158", description=""),
     *                  @OA\Property(property="inventory", type="INT", default="NULL", example="2874", description=""),
     *                  @OA\Property(property="price", type="FLOAT", default="NULL", example="1986.71", description=""),
     *                  @OA\Property(property="discount", type="INT", default="NULL", example="1406", description=""),
     *                  @OA\Property(property="status", type="BOOLEAN", default="1", example="1", description=""),
 *                  @OA\Property(property="code", type="VARCHAR", default="NONE", example="Miss Kavon Glover", description=""),
 *                  @OA\Property(property="category_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  x="{{SWAGGER_PROPERTY_JSON_CONTENT_NOT_DELETE_THIS_LINE}}"
 *              )
 *          )
 *     ),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 * @OA\Get(
 *     path="/products/{id}",
 *     tags={"Product"},
 *     summary="Edit Product",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 *
 * @OA\Put(
 *     path="/products/{id}",
 *     tags={"Product"},
 *     summary="Update Product",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id", "name", "category_id", "code"},
 *                  @OA\Property(property="name", type="VARCHAR", default="NONE", example="Josie Legros I", description=""),
     *                  @OA\Property(property="image", type="VARCHAR", default="NULL", example="Morton Ritchie", description=""),
     *                  @OA\Property(property="description", type="TEXT", default="NULL", example="Ad odit optio temporibus veritatis. Quia alias consequatur eos et. Reprehenderit beatae vel saepe quos. Perspiciatis vel ut aut quaerat cupiditate ipsa.", description=""),
     *                  @OA\Property(property="stock_in", type="INT", default="NULL", example="5052", description=""),
     *                  @OA\Property(property="stock_out", type="INT", default="NULL", example="2158", description=""),
     *                  @OA\Property(property="inventory", type="INT", default="NULL", example="2874", description=""),
     *                  @OA\Property(property="price", type="FLOAT", default="NULL", example="1986.71", description=""),
     *                  @OA\Property(property="discount", type="INT", default="NULL", example="1406", description=""),
     *                  @OA\Property(property="status", type="BOOLEAN", default="1", example="1", description=""),
 *                  @OA\Property(property="code", type="VARCHAR", default="NONE", example="Miss Kavon Glover", description=""),
 *                  @OA\Property(property="category_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
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
 *     path="/products/{id}",
 *     tags={"Product"},
 *     summary="Delete Product",
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
 *     title="Product",
 *     required={"id", "name", "category_id", "code"},
 * )
 */
class Product
{
    /**
     * @OA\Property(property="id", type="BIGINT", description="AUTO_INCREMENT")
     */

    /**
     * <###> @OA\Property(property="name", type="VARCHAR", default="NONE", description="")
     */

    /**
     * <###> @OA\Property(property="image", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="description", type="TEXT", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="stock_in", type="INT", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="stock_out", type="INT", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="inventory", type="INT", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="price", type="FLOAT", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="discount", type="INT", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="status", type="BOOLEAN", default="1", description="")
     */

    /**
     * <###> @OA\Property(property="code", type="VARCHAR", default="NONE", description="")
     */

    /**
     * @OA\Property(property="category_id", default="NONE", description="hasMany")
     * @var Category
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
