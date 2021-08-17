<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2021-08-17 10:51:26
 * File: Category.php
 */
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{
	use SoftDeletes;

    //Declare table name
    protected $table = 'categories';
    //{{TIMESTAMPS_NOT_DELETE_THIS_LINE}}
    protected $fillable = [
    	'name',
    ];

    

	/**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function products(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    //{{RELATIONS_NOT_DELETE_THIS_LINE}}
}
