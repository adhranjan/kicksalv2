<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMyFutsalUser extends FormRequest
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
        switch ($this->method()){
            case 'POST':
                return [
                    'name'=>'required',
                    'email'=>'required|email|unique:users',
                ];
            break;
            case 'PUT':
                return [
                    'name'=>'required',
                    'email'=>'required|email|unique:users,email,'.$this->id,
                ];
            break;

            default:
            return[];

        }
    }
}
