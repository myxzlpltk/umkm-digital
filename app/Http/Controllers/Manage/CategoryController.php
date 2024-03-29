<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class CategoryController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        Gate::authorize('view-any', Category::class);

        return view('categories.index', [
            'categories' => $request->user()
                ->seller
                ->categories()
                ->with('products')
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        Gate::authorize('create', Category::class);

        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        Gate::authorize('create', Category::class);

        $request->validate([
            'category_name' => [
                'required',
                'string',
                Rule::unique(Category::class, 'name')->where(function ($query) use($request){
                    return $query->where('seller_id', $request->user()->seller->id);
                })
            ]
        ]);

        $category = new Category;
        $category->seller_id = $request->user()->seller->id;
        $category->name = $request->category_name;
        $category->save();

        return redirect()->route('manage.categories.index')->with([
            'success' => 'Data berhasil ditambahkan.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category){
        Gate::authorize('update', $category);

        return view('categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category){
        Gate::authorize('update', $category);

        $request->validate([
            'category_name' => [
                'required',
                'string',
                Rule::unique(Category::class, 'name')->where(function ($query) use($request){
                    return $query->where('seller_id', $request->user()->seller->id);
                })->ignore($category->id)
            ]
        ]);

        $category->name = $request->category_name;
        $category->save();

        return redirect()->route('manage.categories.index')->with([
            'success' => 'Data berhasil diperbarui.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Category $category){
        Gate::authorize('delete', $category);

        if($category->products()->count() > 0){
            return redirect()->route('manage.categories.index')->with([
                'error' => 'Data tidak bisa dihapus karena masih terdapat produk dengan kategori tersebut.'
            ]);
        }
        else{
            $category->delete();

            return redirect()->route('manage.categories.index')->with([
                'success' => 'Data berhasil dihapus.'
            ]);
        }
    }
}
