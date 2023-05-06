<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Image;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function AllBlogCategory()
    {
        $blogCategories = BlogCategory::latest()->get();
        return view('backend.blog.category.blogcategory_all',compact('blogCategories'));
    }

    public function AddBlogCategory()
    {
        return view('backend.blog.category.blogcategory_add');
    }

    public function StoreBlogCategory(Request $request)
    {
        BlogCategory::insert([
            'blog_category_name' => $request->blog_category_name,
            'blog_category_slug' => strtolower(str_replace(' ', '-', $request->blog_category_name)),
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Blog category inserted successfully',
            'alert-type' => 'success'
         );
           
        return redirect()->route('admin.blog.category')->with($notification);
    }

    public function EditBlogCategory($id)
    {
        $blogCategories = BlogCategory::findOrFail($id);

        return view('backend.blog.category.blogcategory_edit',compact('blogCategories'));
    }

    public function UpdateBlogCategory(Request $request)
    {
        $blog_id = $request->id;

        BlogCategory::findOrFail($blog_id)->update([
            'blog_category_name' => $request->blog_category_name,
            'blog_category_slug' => strtolower(str_replace(' ', '-', $request->blog_category_name)),
        ]);

        $notification = array(
            'message' => 'Blog category updated successfully',
            'alert-type' => 'success'
         );
           
        return redirect()->route('admin.blog.category')->with($notification);
    }

    public function DeleteBlogCategory($id)
    {
        BlogCategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Blog category deleted successfully',
            'alert-type' => 'success'
         );
           
        return redirect()->route('admin.blog.category')->with($notification);
    }
}
