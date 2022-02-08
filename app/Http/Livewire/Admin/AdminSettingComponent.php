<?php

namespace App\Http\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class AdminSettingComponent extends Component
{

    public $email;
    public $phone1;
    public $phone2;
    public $map;
    public $address;
    public $twitter;
    public $facebook;
    public $instagram;
    public $pinterest;
    public $youtube;

    public function mount()
    {
        $setting = Setting::find(1);
        if($setting)
        {
             $this->email = $setting->email;
             $this->phone1 = $setting->phone1;
             $this->phone2 = $setting->phone2;
             $this->map = $setting->map;
             $this->address = $setting->address;
             $this->twitter = $setting->twitter;
             $this->facebook = $setting->facebook;
             $this->instagram = $setting->instagram;
             $this->pinterest = $setting->pinterest;
             $this->youtube = $setting->youtube;
        }
    }

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'email'  =>  'required | email',
            'phone1' => 'required',
            'phone2'=>'required',
            'map'=>'required',
            'address'=>'required',
            'twitter'=>'required',
            'facebook'=>'required',
            'instagram'=>'required',
            'pinterest'=>'required',
            'youtube'=>'required',
        ]);
    }

    public function saveSettings()
    {
        $this->validate(
               [ 'email'  =>  'required | email',
                 'phone1' => 'required',
                 'phone2'=>'required',
                 'map'=>'required',
                 'address'=>'required',
                 'twitter'=>'required',
                 'facebook'=>'required',
                 'instagram'=>'required',
                 'pinterest'=>'required',
                 'youtube'=>'required',
                   ]
        );
        $setting = Setting::find(1);
        if(!$setting)
        {
            $setting = new Setting();
             $setting->email = $this->email;
             $setting->phone1 = $this->phone1;
             $setting->phone2 = $this->phone2;
             $setting->map = $this->map;
             $setting->address = $this->address;
             $setting->twitter = $this->twitter;
             $setting->facebook = $this->facebook;
             $setting->instagram = $this->instagram;
             $setting->pinterest = $this->pinterest;
             $setting->youtube = $this->youtube;
             $setting->save();
             session()->flash('message' , 'Settings Has Been Saved Successfully');
        }
        else
        {
        $setting->email = $this->email;
        $setting->phone1 = $this->phone1;
        $setting->phone2 = $this->phone2;
        $setting->map = $this->map;
        $setting->address = $this->address;
        $setting->twitter = $this->twitter;
        $setting->facebook = $this->facebook;
        $setting->instagram = $this->instagram;
        $setting->pinterest = $this->pinterest;
        $setting->youtube = $this->youtube;
        $setting->save();
        session()->flash('message' , 'Settings Has Been Saved Successfully');
        }

    }

    public function render()
    {
        return view('livewire.admin.admin-setting-component')->layout('layouts.base');
    }
}
