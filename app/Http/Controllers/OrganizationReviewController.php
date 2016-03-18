<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Organization_Review;

class OrganizationReviewController extends Controller
{
    public function create($id){

        return view ('organization.organization_review',compact('id'));


    }

    public function store( $id,Request $request){

        $user_id = Auth::user()->id;




        $this->validate($request,['rate'=>'required|numeric|min:1|max:5']);

        $review = new Organization_Review;

        $review->organization_id = $id;
        $review->user_id = $user_id;
        $review->review = $request->review;
        $review->rate = $request->rate;
        $review->save();

        return redirect('home');



    }



}
