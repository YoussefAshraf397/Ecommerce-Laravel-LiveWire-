<?php

namespace App\Http\Livewire\Admin;

use App\Models\HomeSlider;
use Livewire\Component;
use Livewire\WithPagination;

class AdminHomeSliderComponent extends Component
{
    public function deleteSlider($id)
    {
        $slider = HomeSlider::find($id) ;
        $slider->delete() ;
        session()->flash('message' , 'Slider Has Been Deleted Successfully');
    }
    use WithPagination;
    public function render()
    {
        $sliders = HomeSlider::paginate(5);
        return view('livewire.admin.admin-home-slider-component' , ['sliders' => $sliders])->layout('layouts.base');
    }
}
