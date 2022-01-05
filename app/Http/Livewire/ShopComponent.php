<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;
class ShopComponent extends Component
{

    public function Store($product_id  , $product_name , $product_price)
    {
//        $product_price = Cart::total($product_price);
//        dd((float)$product_price) ;
        Cart::add($product_id , $product_name , 1 , (float)$product_price)->associate('App\Models\Product');
        session()->flash('success_message' , 'Item Added in Your Cart');
        return redirect()->route('product.cart');
    }
    use WithPagination  ;
    public function render()
    {
        $products = Product::paginate(10);
        return view('livewire.shop-component' , ['products' => $products])->layout('layouts.base');
    }


}
