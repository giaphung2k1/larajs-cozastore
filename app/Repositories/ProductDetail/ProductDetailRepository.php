<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2021-08-19 17:43:10
 * File: ProductDetail.php
 */

namespace App\Repositories\ProductDetail;

use App\Models\ProductDetail;
use App\Repositories\EloquentRepository;

class ProductDetailRepository extends EloquentRepository implements ProductDetailInterface
{
	public function getModel(): string
	{
		return ProductDetail::class;
	}
}