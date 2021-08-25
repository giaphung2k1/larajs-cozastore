<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2021-08-19 17:43:10
 * File: ProductDetail.php
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'price' => 'required|string|max:191',
            'amount' => 'required|numeric',
            //{{REQUEST_RULES_NOT_DELETE_THIS_LINE}}
        ];
    }
}
