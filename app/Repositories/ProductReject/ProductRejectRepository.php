<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2021-08-17 12:31:00
 * File: ProductReject.php
 */

namespace App\Repositories\ProductReject;

use App\Models\ProductReject;
use App\Repositories\EloquentRepository;

class ProductRejectRepository extends EloquentRepository implements ProductRejectInterface
{
	public function getModel(): string
	{
		return ProductReject::class;
	}
}