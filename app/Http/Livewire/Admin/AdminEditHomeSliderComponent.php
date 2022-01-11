<?php

namespace App\Http\Livewire\Admin;

use App\Models\HomeSlider;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminEditHomeSliderComponent extends Component
{
    use withFileUploads ;

    public $title;
    public $subtitle;
    public $price;
    public $link;
    public $image;
    public $newImage;
    public $status;
    public $slider_id;

    public function mount($slider_id)
    {
        $slider = HomeSlider::find($slider_id) ;

        $this->title = $slider->title ;
        $this->subtitle = $slider->subtitle ;
        $this->price = $slider->price ;
        $this->link = $slider->link ;
        $this->status = $slider->status;
        $this->slider_id = $slider->id ;
        $this->image = $slider->image;
    }

    public function editSlide()
    {
        $slider = HomeSlider::find($this->slider_id) ;

        $slider->title = $this->title ;
        $slider->subtitle = $this->subtitle ;
        $slider->price = $this->price ;
        $slider->link = $this->link ;
        $slider->status = $this->status;

        if($this->newImage)
        {
            $imageName = Carbon::now()->timestamp.'.'.$this->newImage->extension() ;
            $this->newImage->storeAs('sliders' , $imageName) ;
            $slider->image = $imageName ;
        }
        $slider->save();
        session()->flash('message' , 'Slider Has Been Updated Successfully');
    }

    public function render()
    {
        return view('livewire.admin.admin-edit-home-slider-component')->layout('layouts.base');
    }
}
