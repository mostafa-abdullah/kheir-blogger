<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OrganizationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $organization_id = $this->route()->getParameter('organization');

        return $organization_id == auth()->guard('organization')->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route()->getParameter('organization');
        return [
            "name"   => "required",
            "email"  => "unique:organizations,email,".$id,
            "phone"  => "digits:11",
            "slogan" => "max:50"
        ];
    }
}
