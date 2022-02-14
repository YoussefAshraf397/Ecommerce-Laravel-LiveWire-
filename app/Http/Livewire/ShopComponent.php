<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;
class ShopComponent extends Component
{

    public $sorting;
    public $pageSize;

    public $min_price;
    public $max_price;


    public function mount()
    {
        $this->sorting = "default" ;
        $this->pageSize = 12 ;

        $this->min_price = 1 ;
        $this->max_price = 1000 ;

    }

    public function Store($product_id  , $product_name , $product_price)
    {
        Cart::instance('cart')->add($product_id , $product_name , 1 , (float)$product_price)->associate('App\Models\Product');
        session()->flash('success_message' , 'Item Added in Your Cart');
        return redirect()->route('product.cart');
    }

    public function addToWishList($product_id  , $product_name , $product_price)
    {
        Cart::instance('wishlist')->add($product_id , $product_name , 1 , (float)$product_price)->associate('App\Models\Product');
        $this->emitTo('wishlist-count-component' , 'refreshComponent');
    }

    public function removeFromWishlist($product_id)
    {
        foreach (Cart::instance('wishlist')->content() as $wishItem)
        {
            if($wishItem->id == $product_id)
            {
                Cart::instance('wishlist')->remove($wishItem->rowId);
                $this->emitTo('wishlist-count-component' , 'refreshComponent');
                return ;
            }
        }
    }

    use WithPagination  ;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        if($this->sorting == "date")
        {
            $products = Product::whereBetween('regular_price' , [$this->min_price , $this->max_price])->orderBy('created_at' , 'DESC')->paginate($this->pageSize);
        }
        elseif ($this->sorting == "price")
        {
            $products = Product::whereBetween('regular_price' , [$this->min_price , $this->max_price])->orderBy('regular_price' , 'ASC')->paginate($this->pageSize);
        }
        elseif ($this->sorting == "price-desc")
        {
            $products = Product::whereBetween('regular_price' , [$this->min_price , $this->max_price])->orderBy('regular_price' , 'DESC')->paginate($this->pageSize);
        }
        else
        {
            $products = Product::whereBetween('regular_price' , [$this->min_price , $this->max_price])->paginate($this->pageSize);
        }

        $categories = Category::all();

        if(Auth::check())
        {
            Cart::instance('cart')->store(Auth::user()->email);
        }

        return view('livewire.shop-component' , ['products' => $products , 'categories' => $categories])->layout('layouts.base');
    }


}
