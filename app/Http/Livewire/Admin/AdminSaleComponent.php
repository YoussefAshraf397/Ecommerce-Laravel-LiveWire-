<?php

namespace App\Http\Livewire\Admin;

use App\Models\Sale;
use Livewire\Component;

class AdminSaleComponent extends Component
{
    public $sale_date;
    public $status;

    function mount()
    {
        $sale = Sale::find(1);
        $this->sale_date = $sale->sale_date ;
        $this->status = $sale->status ;
    }

    public function updateSale()
    {
//        dd()
        $sale = Sale::find(1);
        $sale->status = $this->status ;
        $sale->sale_date = $this->sale_date ;


//        dd($this->sale_date);
        $sale->Save();
        session()->flash('message' , 'Sale Has Been Updated Successfully');
    }

    public function render()
    {
        return view('livewire.admin.admin-sale-component')->layout('layouts.base');
    }
}
