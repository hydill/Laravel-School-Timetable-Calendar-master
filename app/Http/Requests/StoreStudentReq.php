<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentReq extends FormRequest
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
            'named'      => [
                'required'
            ],
            'phone_number' => [
                'required',
                'numeric'
            ],
            'address'   => [
                'required'
            ],
            'class_id' => [
                'required',
                'integer'
                
            ],
            'phone_number' => [
                
                'required',
                'regex:/^62[0-9]{9,}$/',
            ]
        ];
    }

    public function messages(){
        return [
            'named.required' => 'Nama wajib di isi!',
            'phone_number.required' => 'Nomor WA Ortu wajib di isi!',
            'address.required' => 'Alamat siswa wajib di isi!',
         
        ];
    }
}
