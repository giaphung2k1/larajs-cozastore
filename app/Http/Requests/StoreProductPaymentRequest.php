<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2021-08-17 12:27:50
 * File: ProductPayment.php
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ProductDetail;

class StoreProductPaymentRequest extends FormRequest
{
    const OUT_STOCK = 0;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * 
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'total' => [
                'nullable',
                'numeric',
                function ($attribute,$value,$fail){
                    $productDetail = ProductDetail::select(['amount'])->where('product_id',$this->request->get('product_id'))
                    ->where('color_id',$this->request->get('color_id')) 
                    ->where('size_id',$this->request->get('size_id'))
                    ->where('amount','>',self::OUT_STOCK)
                    ->first();
                    if($productDetail && $productDetail->amount < $value){
                        $fail(trans('validation.max.numeric',['max' => $productDetail->amount]));
                    }
                    
                },
            ],
            'note' => 'nullable|string',
           
        ];
    }
}
