<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
   public function AdminDashboard()
   {
      return view('admin.index');
   } 

   public function AdminLogin()
   {
      return view('admin.admin_login');
   }

   public function AdminDestroy(Request $request)
   {
      Auth::guard('web')->logout();

      $request->session()->invalidate();

      $request->session()->regenerateToken();

      return redirect('/admin/login');
   }

   public function AdminProfile()
   {
      $id = Auth::user()->id;
      $adminData = User::find($id);

      return view('admin.admin_profile_view',compact('adminData'));
   }

   public function AdminProfileStore(Request $request)
   {
      $id = Auth::user()->id;
      $data = User::find($id);

      $data->name = $request->name;
      $data->email = $request->email;
      $data->phone = $request->phone;
      $data->address = $request->address;

      if ($request->file('photo')) {
         $file = $request->file('photo');
         $filename = date('YmdHi').$file->getClientOriginalName();
         $file->move(public_path('upload/admin_images'),$filename);
         $data['photo'] = $filename;
      }

      $data->save();

      $notification = array(
         'message' => 'Admin profile update succesfully',
         'alert-type' => 'success'
      );
        
      return redirect()->back()->with($notification);
   }

   public function AdminChangePassword()
   {
      return view('admin.admin_change_password');
   }

   public function AdminUpdatePassword(Request $request)
   {
      $request->validate([
         'old_password' => 'required',
         'new_password' => 'required|confirmed',
      ]);

      if (!Hash::check($request->old_password, auth::user()->password)) {
         return back()->with('error', "Old password doesn't match!");
      }

      User::whereId(auth()->user()->id)->update([
         'password' => Hash::make($request->new_password)
      ]);
      
      return back()->with('status', "Password changed successfully.");
   }

   public function InactiveVendor()
   {
      $inActiveVendor = User::where('status','inactive')->where('role','vendor')->latest()->get();
      return view('backend.vendor.inactive_vendor',compact('inActiveVendor'));
   }

   public function ActiveVendor()
   {
      $activeVendor = User::where('status','active')->where('role','vendor')->latest()->get();
      return view('backend.vendor.active_vendor',compact('activeVendor'));
   }

   public function InactiveVendorDetails($id)
   {
      $inActiveVendorDetails = User::findOrFail($id);
      return view('backend.vendor.inactive_vendor_detail',compact('inActiveVendorDetails'));
   }

   public function ActiveVendorApprove(Request $request)
   {
      $vendor_id = $request->id;
      $user = User::findOrFail($vendor_id)->update([
         'status' => 'active'
      ]);

      $notification = array(
         'message' => 'Vendor active succesfully',
         'alert-type' => 'success'
      );
        
      return redirect()->route('active.vendor')->with($notification);

   }

   public function ActiveVendorDetails($id)
   {
      $activeVendorDetails = User::findOrFail($id);
      return view('backend.vendor.active_vendor_detail',compact('activeVendorDetails'));
   }

   public function InactiveVendorApprove(Request $request)
   {
      $vendor_id = $request->id;
      $user = User::findOrFail($vendor_id)->update([
         'status' => 'inactive'
      ]);

      $notification = array(
         'message' => 'Vendor inactive succesfully',
         'alert-type' => 'success'
      );
        
      return redirect()->route('inactive.vendor')->with($notification);
   }
}
