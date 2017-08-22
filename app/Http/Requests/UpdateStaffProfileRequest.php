<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffProfileRequest extends FormRequest
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
               abort(404);
            break;
            case 'PUT':
                return [
                    'user_name'=>'required|NotIn:Staff',
                    'phone'=>'required|phone_number|unique:staff_profile,phone,'.$this->staff_profile,
                    'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                ];
            break;

            default:
            return[];

        }
    }
}
