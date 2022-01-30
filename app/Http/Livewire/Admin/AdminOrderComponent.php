<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AdminOrderComponent extends Component
{

    public function updateOrderStatus($order_id , $status)
    {
        $order = Order::find($order_id);
        $order->status = $status;

        if($status == 'delivered')
        {
            $order->delivered_date = DB::raw('CURRENT_TIMESTAMP');
        }
        elseif($status == 'canceled')
        {
            $order->canceled_Date = DB::raw('CURRENT_TIMESTAMP');
        }
        $order->save();
        session()->flash('order_message' , 'Order Status Has Been Updated Successfully');
    }

    use WithPagination;
    public function render()
    {
        $orders = Order::orderBy('created_at' , 'DESC')->paginate(12);
        return view('livewire.admin.admin-order-component' , ['orders' => $orders])->layout('layouts.base');
    }
}
