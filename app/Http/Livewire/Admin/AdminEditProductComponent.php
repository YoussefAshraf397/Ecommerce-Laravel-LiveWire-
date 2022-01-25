<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminEditProductComponent extends Component
{
    use withFileUploads;

    public $name;
    public $slug;
    public $short_description;
    public $description;
    public $regular_price;
    public $sale_price;
    public $sku;
    public $stock_status;
    public $featured;
    public $quantity;
    public $image;
    public $category_id;
    public $newImage;
    public $productId ;


    public function mount($product_slug)
    {
        $product = Product::where('slug' , $product_slug)->first() ;
         $this->name = $product->name;
         $this->slug = $product->slug;
         $this->short_description = $product->short_description;
         $this->description = $product->description;
         $this->regular_price = $product->regular_price;
         $this->sale_price = $product->sale_price;
         $this->sku = $product->SKU;
         $this->stock_status = $product->stock_status;
         $this->featured = $product->featured;
         $this->quantity = $product->quantity;
         $this->image= $product->image;
         $this->category_id = $product->category_id;
         $this->productId = $product->id;

    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name , '-');
    }

    public function updated($fields)
    {
        $this->validateOnly($fields , [
            'name' => 'required' ,
            'slug' => 'required | unique:categories' ,
            'short_description' => 'required' ,
            'description' => 'required' ,
            'regular_price' => 'required | numeric' ,
            'sale_price' => 'required | numeric' ,
            'sku' => 'required' ,
            'stock_status' => 'required' ,
            'featured' => 'required' ,
            'quantity' => 'required | numeric' ,
            'image' => 'required' ,
            'category_id' => 'required'
        ]);
    }

    public function editProduct()
    {
        $this->validate([
            'name' => 'required' ,
            'slug' => 'required | unique:categories' ,
            'short_description' => 'required' ,
            'description' => 'required' ,
            'regular_price' => 'required | numeric' ,
            'sale_price' => 'required | numeric' ,
            'sku' => 'required' ,
            'stock_status' => 'required' ,
            'featured' => 'required' ,
            'quantity' => 'required | numeric' ,
            'image' => 'required' ,
            'category_id' => 'required'
        ]);

        $product = Product::find($this->productId);

        $product->name = $this->name ;
        $product->slug = $this->slug ;
        $product->short_description = $this->short_description ;
        $product->description = $this->description ;
        $product->regular_price = $this->regular_price ;
        $product->sale_price = $this->sale_price ;
        $product->sku = $this->sku ;
        $product->stock_status = $this->stock_status ;
        $product->featured = $this->featured ;
        $product->quantity = $this->quantity ;

        if($this->newImage)
        {
            $imageName = Carbon::now()->timestamp.'.'.$this->newImage->extension() ;
            $this->newImage->storeAs('products' , $imageName) ;
            $product->image = $imageName ;
        }
        $product->category_id = $this->category_id ;

        $product->save() ;
        session()->flash('message' , 'Product Has Been Updated Successfully');
    }
    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.admin-edit-product-component' , ['categories' => $categories])->layout('layouts.base');
    }
}
