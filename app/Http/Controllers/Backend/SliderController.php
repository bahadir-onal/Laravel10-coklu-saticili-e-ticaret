<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Image;

class SliderController extends Controller
{
    public function AllSlider()
    {
        $sliders = Slider::latest()->get();
        return view('backend.slider.slider_all',compact('sliders'));
    }

    public function AddSlider()
    {
        return view('backend.slider.slider_add');
    }

    public function StoreSlider(Request $request)
    {
        $image = $request->file('slider_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(2376,807)->save('upload/slider/'.$name_gen);
        $save_url = 'upload/slider/'.$name_gen;

        Slider::insert([
            'slider_title'  => $request->slider_title,
            'short_title'  => $request->short_title,
            'slider_image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Slider inserted successfully',
            'alert-type' => 'success'
         );
           
        return redirect()->route('all.slider')->with($notification);
    }

    public function EditSlider($id)
    {
        $sliders = Slider::findOrFail($id);
        return view('backend.slider.slider_edit',compact('sliders'));
    }

    public function SliderUpdate(Request $request)
    {
        $slider_id = $request->id;
        $old_image = $request->old_image;

        if ($request->file('slider_image')) {
            $image = $request->file('slider_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(2376,807)->save('upload/slider/'.$name_gen);
            $save_url = 'upload/slider/'.$name_gen;

            if (file_exists($old_image)) {
                unlink($old_image);
            }

            Slider::findOrFail($slider_id)->update([
                'slider_title'  => $request->slider_title,
                'short_title'  => $request->short_title,
                'slider_image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Slider updated with image successfully',
                'alert-type' => 'success'
            );
            
            return redirect()->route('all.slider')->with($notification);

        } else {

            Slider::findOrFail($slider_id)->update([
                'slider_title'  => $request->slider_title,
                'short_title'  => $request->short_title,
            ]);

            $notification = array(
                'message' => 'Slider updated without image successfully',
                'alert-type' => 'success'
            );
            
            return redirect()->route('all.slider')->with($notification);            
        }
    }

    public function DeleteSlider($id)
    {
        $slider = Slider::findOrFail($id);
        $image = $slider->slider_image;
        unlink($image);

        Slider::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Slider deleted successfully',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);  
    } 
}
