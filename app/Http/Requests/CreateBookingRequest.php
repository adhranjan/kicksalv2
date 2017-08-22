<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateBookingRequest extends FormRequest
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
                    'book_time' => 'required|unique:game_bookings,book_time,NULL,id,game_day,'.$this->game_day.',ground_id,'.$this->ground_id,
                    'game_day'=>'required|date|after:yesterday',
                    'phone'=>'required',
                    'ground_id'=>'required'
                ];
            break;
            case 'PUT':
                return [


                ];
            break;

            default:
            return[];

        }
    }

    public function __construct()
    {
    }

    public function messages()
    {
        return [
            'game_day.after' => 'Booking date must be today or greater date.'
        ];
    }

}
