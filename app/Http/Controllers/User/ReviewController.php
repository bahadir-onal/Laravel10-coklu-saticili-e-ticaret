<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review; 
use Carbon\Carbon;
use Auth;

class ReviewController extends Controller
{
    public function StoreReview(Request $request)
    {
        $product = $request->product_id;
        $vendor = $request->hvendor_id;

        $request->validate([
            'comment' => 'required'
        ]);

        Review::insert([
            'product_id' => $product,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'rating' => $request->quality,
            'vendor_id' => $vendor,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Review will approve by admin.',
            'alert-type' => 'success'
        );

        return redirect()->route('dashboard')->with($notification);
    }
    
    //ADMİN REVİEW FUNCTİON
    public function PendingReview()
    {
        $review = Review::where('status', 0)->orderBy('id','DESC')->get();
        return view('backend.review.pending_review',compact('review'));
    }

    public function ReviewApprove($id)
    {
        Review::where('id',$id)->update(['status' => 1]);

        $notification = array(
            'message' => 'Review approve successfully.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function PublishReview()
    {
        $review = Review::where('status', 1)->orderBy('id','DESC')->get();
        return view('backend.review.publish_review',compact('review'));
    }

    public function ReviewDelete($id)
    {
        Review::where('id',$id)->delete();

        $notification = array(
            'message' => 'Review delete successfully.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    //VENDOR REVİEW FUNCTİON
    public function VendorAllReview()
    {
        $id = Auth::user()->id;

        $review = Review::where('id',$id)->where('status',1)->orderBy('id','DESC')->get();

        return view('vendor.backend.review.approve_review',compact('review'));
    }
}
