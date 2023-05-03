<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class ReturnController extends Controller
{
    public function ReturnRequest()
    {
        $orders = Order::where('return_order', 1)->orderBy('id','DESC')->get();
        return view('backend.return_order.return_request',compact('orders'));
    }

    public function ReturnRequestApproved($order_id)
    {
        Order::where('id',$order_id)->update(['return_order' => 2]);

        $notification = array(
            'message' => 'Return order successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function CompleteReturnRequest()
    {
        $orders = Order::where('return_order',2)->orderBy('id','DESC')->get();
        return view('backend.return_order.complete_return_request',compact('orders'));
    }
}
