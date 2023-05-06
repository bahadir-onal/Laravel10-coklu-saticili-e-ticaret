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
           
        return redirect()->back()->with($notification);
    }
    
    /////////////////////// BLOG POST CONTROLLER ///////////////////////

    public function AllBlogPost()
    {
        $blogPost = BlogPost::latest()->get();
        
        return view('backend.blog.post.blogpost_all',compact('blogPost'));
    }

    public function AddBlogPost()
    {
        $blogCategories = BlogCategory::latest()->get();

        return view('backend.blog.post.blogpost_add',compact('blogCategories'));
    }

    public function StoreBlogPost(Request $request)
    {
        $image = $request->file('post_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(1103,906)->save('upload/blog/'.$name_gen);
        $save_url = 'upload/blog/'.$name_gen;

        BlogPost::insert([
            'category_id' => $request->category_id,
            'post_title' => $request->post_title,
            'post_slug' => strtolower(str_replace(' ', '-',$request->post_title)),
            'post_short_description' => $request->post_short_description,
            'post_long_description' => $request->post_long_description,
            'post_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Blog post inserted successfully',
            'alert-type' => 'success'
         );
           
        return redirect()->route('admin.blog.post')->with($notification);
    }

    public function EditBlogPost($id)
    {
        $blogCategories = BlogCategory::latest()->get();
        $blogPost = BlogPost::findOrFail($id);

        return view('backend.blog.post.blogpost_edit',compact('blogCategories','blogPost'));
    }

    public function UpdateBlogPost(Request $request)
    {
        $post_id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('post_image')) {

            $image = $request->file('post_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(1103,906)->save('upload/blog/'.$name_gen);
            $save_url = 'upload/blog/'.$name_gen;

            if (file_exists($old_img)) {
                unlink($old_img);
            }

            BlogPost::findOrFail($post_id)->update([
                'category_id' => $request->category_id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-',$request->post_title)),
                'post_short_description' => $request->post_short_description,
                'post_long_description' => $request->post_long_description,
                'post_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Blog post updated with image successfully',
                'alert-type' => 'success'
             );
               
            return redirect()->route('admin.blog.post')->with($notification);
            
        } else {

            BlogPost::findOrFail($post_id)->update([
                'category_id' => $request->category_id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-',$request->post_title)),
                'post_short_description' => $request->post_short_description,
                'post_long_description' => $request->post_long_description,
                'created_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Blog post updated without image successfully',
                'alert-type' => 'success'
             );
               
            return redirect()->route('admin.blog.post')->with($notification);
        }
    }

    public function DeleteBlogPost($id)
    {
        $blogPost = BlogPost::findOrFail($id);
        $img = $blogPost->post_image;
        unlink($img);

        $blogPost->delete();

        $notification = array(
            'message' => 'Blog post deleted successfully',
            'alert-type' => 'success'
         );
           
        return redirect()->back()->with($notification);
    }
}
