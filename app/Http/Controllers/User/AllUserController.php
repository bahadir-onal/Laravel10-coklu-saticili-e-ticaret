<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        return view('frontend.userdashboard.user_order_page');
    }
}
