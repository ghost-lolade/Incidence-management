<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id'=>'required',
            'supplier_id'=>'required',
            'category_id'=>'required',
            'strength_id'=>'required',
            'quantity'=>'required',
            'purchased_date'=>'required',
            'purchased_price'=>'required',
            'sales_price'=>'required',
            'expired_date'=>'required',
            'drugpresentation_id'=>'required'

        ];
    }
}
