<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Tymon\JWTAuth\Token;
use JWTAuth;
use App\User;
use Auth;

class OrganizationReviewRequest extends Request
{

    /**
     * A volunteer can't write more than one review
     */
    public function authorize()
    {
        $organization_id = $this->route()->getParameter('id');


        return !$this->get('volunteer')->organizationReviews()
                            ->where('organization_id', $organization_id)->first();
    }

    public function rules()
    {
        return [
            'rating'   => 'required|numeric|min:1|max:5',
            'review' => 'required'
        ];
    }
}
