<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function AllCoupon()
    {
        $coupon = Coupon::latest()->get();
        return view('backend.coupon.coupon_all',compact('coupon'));
    }

    public function AddCoupon()
    {
        return view('backend.coupon.coupon_add');
    }

    public function StoreCoupon(Request $request)
    {
        Coupon::insert([
            'coupon_name' => $request->coupon_name,
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Coupon inserted successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.coupon')->with($notification);
    }

    public function EditCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('backend.coupon.coupon_edit',compact('coupon'));
    }

    public function CouponUpdate(Request $request)
    {
        $coupon_id = $request->id;

        Coupon::findOrFail($coupon_id)->update([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Coupon updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.coupon')->with($notification);
        
    }

    public function DeleteCoupon($id)
    {
        Coupon::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Coupon deleted successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
