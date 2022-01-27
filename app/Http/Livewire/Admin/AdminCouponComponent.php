<?php

namespace App\Http\Livewire\Admin;

use App\Models\Coupon;
use Livewire\Component;

class AdminCouponComponent extends Component
{
    public function deleteCoupon($coupon_id)
    {
        $coupon = Coupon::find($coupon_id);
        $coupon->delete();

        session()->flash('message' , 'Coupon Has Been Deleted Successfully');
    }

    public function render()
    {
        $coupons = Coupon::paginate(5);
        return view('livewire.admin.admin-coupon-component' , ['coupons' => $coupons])->layout('layouts.base');
    }
}
