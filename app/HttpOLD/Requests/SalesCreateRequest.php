<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesCreateRequest extends FormRequest
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

            'unit_price' => 'required',
            'total_price' => 'required',
            'tax' => 'required',
            'quantity' => 'required',
            'product_name' => 'required',
            'sale_date' => 'required'
        //    'rowId' => 'required'
        ];
    }
}
