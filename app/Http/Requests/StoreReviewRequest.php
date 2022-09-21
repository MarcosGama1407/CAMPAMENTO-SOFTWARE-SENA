<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreReviewRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "title" => 'required|max:20',
            "text" => 'required|max:50',
            "rating" => 'required|numeric|min:1.0|max:10.0',
            "bootcamp_id" => 'required|exists:bootcamps,id',
            "user_id" => 'required|exists:users,id'
        ]
        ;
    }

    public function messages()
    {
        return [
            'title.required' => 'Nombre obligatorio',
            'text.required' => 'Texto obligatorio',
            'rating.required' => 'Rating obligatorio',
            'bootcamp_id.exists' => 'Bootcamp no existe',
            'user_id.exists' => 'Usuario no existe',
        ];
    }

    protected function failedValidation(Validator $v){
        //Si la validacion es fallida
        //Se lanza una exceocion Http
        throw new HttpResponseException( 
            response()->json( [ "success" => false ,
                                "errors" =>  $v->errors() 
                              ], 422 )
        );
    }
}
