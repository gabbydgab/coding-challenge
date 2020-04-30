<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => ["required"],
            "start_date" => ["required"],
            "end_date" => ["required"],
            "mon" => ["boolean", "nullable"],
            "tue" => ["boolean", "nullable"],
            "wed" => ["boolean", "nullable"],
            "thu" => ["boolean", "nullable"],
            "fri" => ["boolean", "nullable"],
            "sat" => ["boolean", "nullable"],
            "sun" => ["boolean", "nullable"],
        ];
    }
}
