<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EventRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'timing' => 'required',
        ];
    }
}
