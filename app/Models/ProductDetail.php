<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2021-08-19 17:43:10
 * File: ProductDetail.php
 */
namespace App\Models;



class ProductDetail extends BaseModel
{
	const OUT_STOCK = 0;

    //Declare table name
    protected $table = 'product_details';
    //{{TIMESTAMPS_NOT_DELETE_THIS_LINE}}
    protected $fillable = [
        'price',
        'amount',
        'product_id',
        'size_id',
        'color_id'
    ];

    

	/**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function product(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function size(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function color(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

   
}
