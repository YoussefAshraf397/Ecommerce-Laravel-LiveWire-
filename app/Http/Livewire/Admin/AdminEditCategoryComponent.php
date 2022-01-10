<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminEditCategoryComponent extends Component
{
    public $categorySlug ;
    public $categoryId ;
    public $name ;
    public $slug ;

    public function mount($category_slug)
    {
        $this->categorySlug = $category_slug ;
        $category = Category::where('slug' , $category_slug)->first() ;
        $this->categoryId = $category->id ;
        $this->slug = $category->slug ;
        $this->name = $category->name ;
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function updateCategory()
    {
        $category = Category::find($this->categoryId) ;
        $category->name = $this->name ;
        $category->slug = $this->slug ;

        $category->save() ;
        session()->flash('message' , 'Category Has Been Updated Successfully');
    }

    public function render()
    {
        return view('livewire.admin.admin-edit-category-component')->layout('layouts.base');
    }
}
