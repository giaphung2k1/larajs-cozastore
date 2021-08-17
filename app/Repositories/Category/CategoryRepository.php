<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2021-08-17 10:51:26
 * File: Category.php
 */

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\EloquentRepository;

class CategoryRepository extends EloquentRepository implements CategoryInterface
{
	public function getModel(): string
	{
		return Category::class;
	}
}