<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhtan96@gmail.com
 * Date Time: 2021-08-17 12:13:07
 * File: Product.php
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:191',
            'image' => 'nullable|max:191',
            'description' => 'nullable|string',
            'stock_in' => 'nullable|numeric',
            'stock_out' => 'nullable|numeric',
            'inventory' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'status' => 'nullable|boolean',
            'code' => 'required|string|max:191',
            //{{REQUEST_RULES_NOT_DELETE_THIS_LINE}}
        ];
    }
}
