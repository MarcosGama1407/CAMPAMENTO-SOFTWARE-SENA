<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCourseRequest extends FormRequest
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
            "title" => 'required|min:10|max:30',
            "description" => 'required|min:10',
            "weeks" => 'required|numeric|max:9',
            "enroll_cost" => 'required|numeric',
            "minimum_skill" => 'required|in:Beginner,Intermediate,Advanced,Expert',
            "bootcamp_id" => 'required|exists:bootcamps,id'
        ]
        ;
    }

    public function messages()
    {
        return [
            'title.required' => 'Nombre obligatorio',
            'description.required' => 'Descripción obligatoria',
            'weeks.required' => 'Valor obligatorio',
            'enroll_cost.required' => 'Costo de inscripción obligatorio',
            'minimum_skill.required' => 'Habilidad Obligatoria',
            'bootcamp_id.exists' => 'Bootcamp no existe'
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
