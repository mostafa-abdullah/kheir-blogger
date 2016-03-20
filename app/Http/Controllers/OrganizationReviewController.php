<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class OrganizationReviewController extends Controller
{
    public function create($id){

        return view ('organization.organization_review',compact('id'));
    }

    public function store( $id,Request $request){

        $user_id = Auth::user()->id;

        $this->validate($request,['rate'=>'required|numeric|min:1|max:5']);

        $review = new Review;

        $review->organization_id = $id;
        $review->user_id = $user_id;
        $review->review = $request->review;
        $review->rate = $request->rate;
        $review->save();

        return redirect('home');
    }

//    public function showReviews($organization_id){
//        //Any user can see organization reviews , no need for Authentication
//        return $organization_id;
//    }
}
