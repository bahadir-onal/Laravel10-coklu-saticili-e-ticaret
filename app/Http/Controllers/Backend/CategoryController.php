<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Image;

class CategoryController extends Controller
{
    public function AllCategory()
    {
        $categories = Category::latest()->get();
        return view('backend.category.category_all',compact('categories'));
    }

    public function AddCategory()
    {
        return view('backend.category.category_add');
    }

    public function StoreCategory(Request $request)
    {
        $image = $request->file('category_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/category/'.$name_gen);
        $save_url = 'upload/category/'.$name_gen;

        Category::insert([
            'category_name'  => $request->category_name,
            'category_slug'  => strtolower(str_replace(' ', '-', $request->category_name)),
            'category_image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Category inserted successfully',
            'alert-type' => 'success'
         );
           
        return redirect()->route('all.category')->with($notification);
    }

    public function EditCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.category.category_edit',compact('category'));
    }

    public function UpdateCategory(Request $request)
    {
        $category_id = $request->id;
        $old_image = $request->old_image;

        if ($request->file('category_image')) {
            $image = $request->file('category_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('upload/category/'.$name_gen);
            $save_url = 'upload/category/'.$name_gen;

            if (file_exists($old_image)) {
                unlink($old_image);
            }

            Category::findOrFail($category_id)->update([
                'category_name'  => $request->category_name,
                'category_slug'  => strtolower(str_replace(' ', '-', $request->category_name)),
                'category_image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Category updated with image successfully',
                'alert-type' => 'success'
            );
            
            return redirect()->route('all.category')->with($notification);

        } else {

            Category::findOrFail($category_id)->update([
                'category_name'  => $request->category_name,
                'category_slug'  => strtolower(str_replace(' ', '-', $request->category_name)),
            ]);

            $notification = array(
                'message' => 'Category updated without image successfully',
                'alert-type' => 'success'
            );
            
            return redirect()->route('all.category')->with($notification);            
        }
    }

    public function DeleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $image = $category->category_image;
        unlink($image);

        Category::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Category deleted successfully',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);  
    }
    
}
