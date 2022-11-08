<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
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
            "card_number" => "required",
            "rfid" => "required",
            "qr_code" => "required",
            "nfc" => "required"
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Введите номер карты'
        ];
    }
}
