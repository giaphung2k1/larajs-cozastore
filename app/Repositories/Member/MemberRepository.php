<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2021-08-17 12:35:43
 * File: Member.php
 */

namespace App\Repositories\Member;

use App\Models\Member;
use App\Repositories\EloquentRepository;

class MemberRepository extends EloquentRepository implements MemberInterface
{
	public function getModel(): string
	{
		return Member::class;
	}
}