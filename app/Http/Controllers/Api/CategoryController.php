<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $rules = [
        'name' => 'required|max:255',
        'description' => 'nullable',
        'is_active' => 'boolean'
    ];

    protected function model()
    {
        return Category::class;
    }

    protected function rulesStore()
    {
        return $this->rules;
    }

    protected function rulesUpdate()
    {
        return $this->rules;
    }

    public function index()
    {
        return Category::all();
    }

    // public function index(Request $request) //?only_trashed
    // {
    //     if($request->has('only_trashed')){
    //         return Category::onlyTrashed()->get();
    //     }
    //     return Category::all();
    // }
    
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $category = Category::create($request->all());
        
        // Include deleted_at, created_at, updated_at, etc.
        $category->refresh();
        return $category;
    }

    public function show(Category $category) //Route model binding
    {
        return $category;
    }

    public function update(Request $request, Category $category)
    {
        $this->validate($request, $this->rules);
        $category->update($request->all());
        return $category;        
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent(); // status 204 - No content
    }
}
