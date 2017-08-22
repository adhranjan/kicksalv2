<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeDisplayPictureRequest extends FormRequest
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
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3072',
                ];
                break;
            case 'PUT':
                return [
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3072',
                ];
                break;

            default:
                return[];

        }
    }
}
