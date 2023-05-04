<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use App\Models\Order;
use App\Models\User;

class ReportController extends Controller
{
    public function ReportView()
    {
        return view('backend.report.report_view');
    }

    public function SearchByDate(Request $request)
    {
        $date = new DateTime($request->date);
        $formatDate = $date->format('d F Y');

        $orders = Order::where('order_date',$formatDate)->latest()->get();

        return view('backend.report.report_by_date',compact('formatDate','orders'));
    }

    public function SearchByMonth(Request $request)
    {
        $month = $request->month;
        $year = $request->year_name;

        $orders = Order::where('order_month',$month)->where('order_year',$year)->latest()->get();
        return view('backend.report.report_by_month',compact('month','year','orders'));
    }

    public function SearchByYear(Request $request)
    {
        $year = $request->year;

        $orders = Order::where('order_year',$year)->latest()->get();
        return view('backend.report.report_by_year',compact('year','orders'));
    }

    public function OrderByUser()
    {
        $users = User::where('role','user')->latest()->get();
        return view('backend.report.report_by_user',compact('users'));
    }

    public function SearchByUser(Request $request)
    {
        $users = $request->user;
        $orders = Order::where('user_id',$users)->latest()->get();

        return view('backend.report.report_by_user_show',compact('users','orders'));
    }
}
