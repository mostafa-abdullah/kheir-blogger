<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EventPostRequest extends Request
{
    public function authorize()
    {
        $event_id = $this->route()->getParameter('id');
        return $this->get('organization')->user()->events()->find($event_id);
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required'
        ];
    }
}
