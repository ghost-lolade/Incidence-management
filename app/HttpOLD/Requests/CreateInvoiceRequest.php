<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
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
            //
            'client_name'=>'required',
            'invoice_date'=>'required',
            'contact_person'=>'required',
            'due_date'=>'required',
            'title'=>'required',
           // 'quantity[]'=>'required',
           // 'unit_price[]'=>'required',
            'client_address'=>'required'
        ];
    }
}
