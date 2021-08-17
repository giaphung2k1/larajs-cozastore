<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2021-08-17 17:18:34
 * File: RefColorProduct.php
 */
namespace App\Models;

//{{USE_CLASS_NOT_DELETE_THIS_LINE}}

class RefColorProduct extends BaseModel
{
	//{{USE_NOT_DELETE_THIS_LINE}}

    //Declare table name
    protected $table = 'ref_color_product';
    //{{TIMESTAMPS_NOT_DELETE_THIS_LINE}}
    protected $fillable = [
    	'product_id',
        'color_id',
    ];

    

	//{{RELATIONS_NOT_DELETE_THIS_LINE}}
}
