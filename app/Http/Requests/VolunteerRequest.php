<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VolunteerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = $this->route()->getParameter('volunteer');

        return $id == auth()->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route()->getParameter('volunteer');
        return [
            "first_name"   => "required|max:255",
            "last_name"   => "required|max:255",
            "email"  => "unique:users,email,".$id,
        ];
    }
}
