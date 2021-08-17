<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 17:18:34
 */

/**
 * @OA\Schema(
 *     type="object",
 *     title="RefColorProduct",
 *     required={"id", "product_id", "color_id"},
 *     description="belongsToMany",
 * )
 */
class RefColorProduct
{
    /**
     * @OA\Property(property="id", type="BIGINT", description="AUTO_INCREMENT")
     */

    /**
     * @OA\Property(property="product_id", default="NONE", description="belongsToMany")
     * @var Product
     */

    /**
     * @OA\Property(property="color_id", default="NONE", description="belongsToMany")
     * @var Color
     */

    //{{SWAGGER_PROPERTY_NOT_DELETE_THIS_LINE}}

    /**
     * @OA\Property(property="created_at", type="TIMESTAMP", default="NULL", description="")
     */

    /**
     * @OA\Property(property="updated_at", type="TIMESTAMP", default="NULL", description="")
     */
}
