<?php

namespace App\Http\Requests;

use Symfony\Component\HttpFoundation\Response;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreKontenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * 
     */
    public function authorize()
    {
        // abort_if(Gate::denies('konten_create'), Response::HTTP_FORBIDDEN, '403 Forbid');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     *
     */
    public function rules()
    {
        return [
            'class_id' => [
                'required', 
                'integer'
            ],
            'desc' => [
                'required'
            ],
        ];
    }
}
