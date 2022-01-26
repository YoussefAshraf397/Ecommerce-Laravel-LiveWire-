<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;
class CartComponent extends Component
{

    public function increaseQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1 ;
        Cart::instance('cart')->update($rowId , $qty);
    }

    public function decreaseQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1 ;
        Cart::instance('cart')->update($rowId , $qty);
    }

    public function destroy($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        session()->flash('success_message' , 'Item Has Been Removed');
    }

    public function destroyAll()
    {
        Cart::instance('cart')->destroy();
        session()->flash('success_message' , 'All Items Has Been Removed');

    }

    public function render()
    {
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
