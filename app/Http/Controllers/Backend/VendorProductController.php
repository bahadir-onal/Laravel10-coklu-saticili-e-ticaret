<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Brand;
use App\Models\MultiImage;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\User;
use Image;
use Auth;
use Carbon\Carbon;

class VendorProductController extends Controller
{
    public function VendorAllProduct()
    {
        $id = Auth::user()->id;
        $products = Product::where('vendor_id',$id)->latest()->get();
        return view('vendor.backend.product.vendor_product_all',compact('products'));
    }

    public function VendorAddProduct()
    {
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        return view('vendor.backend.product.vendor_product_add',compact('brands','categories'));
    }

    public function VendorGetSubCategory($category_id)
    {
        $subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name','ASC')->get();
        return json_encode($subcat);
    }

    public function VendorProductStore(Request $request)
    {
        $image = $request->file('product_thumbnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(800,800)->save('upload/products/thumbnail/'.$name_gen);
        $save_url = 'upload/products/thumbnail/'.$name_gen;

        $product_id = Product::insertGetId([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),

            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,

            'product_thumbnail' => $save_url,
            'vendor_id' => Auth::user()->id,
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);

        //MULTIPLE IMAGE UPLOAD

        $images = $request->file('multi_images');
        foreach ($images as $img) {

            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(800,800)->save('upload/products/multi-image/'.$make_name);
            $uploadPath = 'upload/products/multi-image/'.$make_name;

            MultiImage::insert([
                'product_id' => $product_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now()
            ]);
        }

        $notification = array(
            'message' => 'Vendor Product inserted successfully',
            'alert-type' => 'success'
        );
           
        return redirect()->route('vendor.all.product')->with($notification);
    }

    public function VendorEditProduct($id)
    {
        $multiImages = MultiImage::where('product_id',$id)->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $products = Product::findOrFail($id);
        $subcategory = SubCategory::latest()->get();
        return view('vendor.backend.product.vendor_product_edit',compact('brands','categories','products','subcategory','multiImages'));
    }

    public function VendorProductUpdate(Request $request)
    {
            $product_id = $request->id;

            Product::findOrFail($product_id)->update([

            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),

            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,

            'status' => 1,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Vendor Product updated without image successfully',
            'alert-type' => 'success'
        );
           
        return redirect()->route('vendor.all.product')->with($notification);
    }

    public function VendorUpdateProductThumbnail(Request $request)
    {
        $product_id = $request->id;
        $old_image = $request->old_image;

        $image = $request->file('product_thumbnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(800,800)->save('upload/products/thumbnail/'.$name_gen);
        $save_url = 'upload/products/thumbnail/'.$name_gen;

        if (file_exists($old_image)) {
            unlink($old_image);
        }

        Product::findOrFail($product_id)->update([
            'product_thumbnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Vendor Product image thumbnail updated successfully',
            'alert-type' => 'success'
        );
           
        return redirect()->back()->with($notification);
    }

    public function VendorUpdateProductMultiimage(Request $request)
    {
        $images = $request->multi_images;

        foreach ($images as $id => $image) {
            $imageDelete = MultiImage::findOrFail($id);
            unlink($imageDelete->photo_name);

            $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(800,800)->save('upload/products/multi-image/'.$make_name);
            $uploadPath = 'upload/products/multi-image/'.$make_name;

            MultiImage::where('id',$id)->update([
                'photo_name' => $uploadPath,
                'updated_at' => Carbon::now()
            ]);
        }

        $notification = array(
            'message' => 'Vendor Product multi image updated successfully',
            'alert-type' => 'success'
        );
           
        return redirect()->back()->with($notification);
    }

    public function VendorMultiImageDelete($id)
    {
        $oldImage = MultiImage::findOrFail($id);
        unlink($oldImage->photo_name);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Vendor Product multi image deleted successfully',
            'alert-type' => 'success'
        );
           
        return redirect()->back()->with($notification);

    }

    public function VendorProductInactive($id)
    {
        Product::findOrFail($id)->update(['status' => 0]);

        $notification = array(
            'message' => 'Vendor Product Inactive',
            'alert-type' => 'success'
        );
           
        return redirect()->back()->with($notification);
    }

    public function VendorProductActive($id)
    {
        Product::findOrFail($id)->update(['status' => 1]);

        $notification = array(
            'message' => 'Vendor Product active',
            'alert-type' => 'success'
        );
           
        return redirect()->back()->with($notification);
    }

    public function VendorProductDelete($id)
    {
        $product = Product::findOrFail($id);
        unlink($product->product_thumbnail);

        $product->delete();

        $images = MultiImage::where('product_id',$id)->get();
        foreach ($images as $image) {
            unlink($image->photo_name);
            $image->delete();
        }

        $notification = array(
            'message' => 'Vendor Product deleted succesfully',
            'alert-type' => 'success'
        );
           
        return redirect()->back()->with($notification);
    }
    
}
