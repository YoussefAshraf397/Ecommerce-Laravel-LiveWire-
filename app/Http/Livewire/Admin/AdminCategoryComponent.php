<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCategoryComponent extends Component
{
    public function deleteCategory($id)
    {
        $category = Category::find($id) ;
        $category->delete() ;
        session()->flash('message' , 'Category Has Been Deleted Successfully');
    }

    use WithPagination;
    public function render()
    {
        $categories = Category::paginate(5);
        return view('livewire.admin.admin-category-component' , ['categories' => $categories])->layout('layouts.base');
    }
}
