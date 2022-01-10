<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart ;

class CategoryComponent extends Component
{
    public $sorting;
    public $pageSize;
    public $categorySlug;

    public function mount($category_slug)
    {
        $this->sorting = "default" ;
        $this->pageSize = 12 ;
        $this->categorySlug = $category_slug ;

    }

    public function Store($product_id  , $product_name , $product_price)
    {
        Cart::add($product_id , $product_name , 1 , (float)$product_price)->associate('App\Models\Product');
        session()->flash('success_message' , 'Item Added in Your Cart');
        return redirect()->route('product.cart');
    }

    use WithPagination  ;
    public function render()
    {
        $category = Category::where('slug' , $this->categorySlug)->first();
//        dd($category);
        $categoryId = $category->id;
        $categoryName = $category->name;
        if($this->sorting == "date")
        {
            $products = Product::where('category_id' , $categoryId)->orderBy('created_at' , 'DESC')->paginate($this->pageSize);
        }
        elseif ($this->sorting == "price")
        {
            $products = Product::where('category_id' , $categoryId)->orderBy('regular_price' , 'ASC')->paginate($this->pageSize);
        }
        elseif ($this->sorting == "price-desc")
        {
            $products = Product::where('category_id' , $categoryId)->orderBy('regular_price' , 'DESC')->paginate($this->pageSize);
        }
        else
        {
            $products = Product::where('category_id' , $categoryId)->paginate($this->pageSize);
        }

        $categories = Category::all();

        return view('livewire.category-component' , ['products' => $products , 'categories' => $categories , 'categoryName' => $categoryName])->layout('layouts.base');
    }
}
