<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\HomeCategory;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Cart;

class HomeComponent extends Component
{
    public function render()
    {
        $sliders = HomeSlider::where('status' , 1)->get();

        $latestProducts = Product::orderBy('created_at' , 'DESC')->get()->take(8);

        $category = HomeCategory::find(1);
        $cats = explode(',' , $category->sel_categories);
        $categories = Category::whereIn('id' , $cats)->get();
        $no_of_products = $category->no_of_products;

        $saleProducts = Product::where('sale_price' , '>' , 0)->inRandomOrder()->get()->take(8);
        $sale = Sale::find(1);

        if (Auth::check())
        {
            Cart::instance('cart')->restore(Auth::user()->email);
        }
        return view('livewire.home-component' ,
            ['sliders' => $sliders ,
                'latestProducts' => $latestProducts ,
                'categories' => $categories ,
                'no_of_products' => $no_of_products ,
                'saleProducts' => $saleProducts ,
                'sale' => $sale])->layout('layouts.base');
    }
}
