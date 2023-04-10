<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WishlistController extends Controller
{
    public function AddToWishList(Request $request, $product_id)
    {

        if (Auth::check()) {
        $exists = Wishlist::where('user_id',Auth::id())->where('product_id',$product_id)->first();

            if (!$exists) {
               Wishlist::insert([
                'user_id' => Auth::id(),
                'product_id' => $product_id,
                'created_at' => Carbon::now(),

               ]);
               return response()->json(['success' => 'Successfully added on your wishlist' ]);
            } else{
                return response()->json(['error' => 'This product has already on your wishlist' ]);

            } 

        }else{
            return response()->json(['error' => 'At first login your account' ]);
        }
    }

    public function AllWishlist()
    {
        return view('frontend.wishlist.view_wishlist');
    }

    public function GetWishlistProduct()
    {
        $wishlist = Wishlist::with('product')->where('user_id', Auth::id())->latest()->get();

        $wishlistQuantity = wishlist::count();

        return response()->json(['wishlist' => $wishlist, 'wishlistQuantity' => $wishlistQuantity]);
    }

    public function WishlistRemove($id)
    {
        Wishlist::where('user_id', Auth::id())->where('id', $id)->delete();
        
        return response()->json(['success' => 'Product remove successfully']);
    }
}
