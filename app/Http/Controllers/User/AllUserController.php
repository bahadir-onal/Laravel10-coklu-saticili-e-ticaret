<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AllUserController extends Controller
{
    public function UserAccount()
    {
        $id = Auth::id();
        $userData = User::find($id);

        return view('frontend.userdashboard.account_details',compact('userData'));
    }

    public function UserChangePassword()
    {
        return view('frontend.userdashboard.user_change_password');
    }

    public function UserOrderPage()
    {
        $id = Auth::id();
        $orders = Order::where('user_id', $id)->orderBy('id','DESC')->get();
        return view('frontend.userdashboard.user_order_page', compact('orders'));
    }

    public function UserOrderDetails($order_id)
    {
        $order = Order::with('division','district','state','user')->where('id', $order_id)->where('user_id', Auth::id())->first();
        $orderItem = OrderItem::with('product')->where('order_id', $order_id)->orderBy('id','DESC')->get();

        return view('frontend.order.order_details', compact('order','orderItem'));
    }

    public function UserOrderInvoice($order_id)
    {
        $order = Order::with('division','district','state','user')->where('id', $order_id)->where('user_id', Auth::id())->first();
        $orderItem = OrderItem::with('product')->where('order_id', $order_id)->orderBy('id','DESC')->get();

        $pdf = Pdf::loadView('frontend.order.order_invoice', compact('order','orderItem'))
               ->setPaper('a4')
               ->setOption([
                    'temp_dir' => public_path(),
                    'chroot' => public_path()
               ]);

        return $pdf->download('invoice.pdf');
    }

    public function ReturnOrder(Request $request, $order_id)
    {
        Order::findOrFail($order_id)->update([
            'return_date' => Carbon::now()->format('d F Y'),
            'return_reason' => $request->return_reason,
            'return_order' => 1,
        ]);

        $notification = array(
            'message' => 'Return request send succesfully',
            'alert-type' => 'success'
        );

        return redirect()->route('user.order.page')->with($notification);
    }

    public function ReturnOrderPage()
    {
        $orders = Order::where('user_id',Auth::id())->where('return_reason','!=',NULL)->orderBy('id','DESC')->get();
        return view('frontend.order.return_order_view', compact('orders'));
    }
}
