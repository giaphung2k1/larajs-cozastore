<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2021-08-17 12:35:43
 * File: Member.php
 */
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends BaseModel
{
	use SoftDeletes;

    //Declare table name
    protected $table = 'members';
    //{{TIMESTAMPS_NOT_DELETE_THIS_LINE}}
    protected $fillable = [
    	'code',
        'name',
        'sns_link',
        'is_block',
    ];

    

	/**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function productPayments(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(ProductPayment::class, 'member_id', 'id');
    }

    //{{RELATIONS_NOT_DELETE_THIS_LINE}}
}
