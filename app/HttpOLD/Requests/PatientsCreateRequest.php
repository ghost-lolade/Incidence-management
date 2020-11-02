<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientsCreateRequest extends FormRequest
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
            'surname'=>'required',
            'firstname'=>'required',
            'address'=>'required',
            'city_id'=>'required',
            'state_id'=>'required',
            'phone'=>'required|numeric',
            'birthdate'=>'required|date',
            'gender'=>'required',
            'nok'=>'required',
            'nokphone'=>'required|numeric',
            'regfee'=>'required|numeric',
            'insurance_id'=>'required',
        ];





    }
}
