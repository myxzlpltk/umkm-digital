<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        Gate::authorize('view-any', Product::class);

        if(Gate::allows('isSeller')){
            return view('products.index', [
                'products' => $request->user()
                    ->seller
                    ->products()
                    ->with('category')
                    ->get(),
            ]);
        }
        elseif(Gate::allows('isAdmin')){
            return view('products.index', [
                'products' => Product::with([
                    'category',
                    'seller',
                ])->get(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        Gate::authorize('create', Product::class);

        return view('products.create', [
            'categories' => $request->user()->seller->categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        Gate::authorize('create', Product::class);

        $request->validate([
            'image' => 'required|image|dimensions:min_width=200,min_height=200',
            'food_name' => 'required|string',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:1000',
            'discount' => 'required|integer|min:0|max:95',
        ]);

        $image = Image::make($request->file('image'));
        $dim = min($image->width(), $image->height(), 500);

        $filename = Str::random(64).'.jpg';
        Storage::put("products/$filename", $image->fit($dim)->encode('jpg', 80));

        $product = new Product;
        $product->seller_id = $request->user()->seller->id;
        $product->category_id = $request->category_id;
        $product->image = $filename;
        $product->name = $request->food_name;
        $product->description = $request->description;
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->save();

        $request->session()->flash('success', 'Data produk telah ditambahkan.');

        return redirect()->route('manage.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        Gate::authorize('view', $product);

        return view('products.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Product $product){
        Gate::authorize('update', $product);

        return view('products.edit', [
            'product' => $product,
            'categories' => $request->user()->seller->categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product){
        Gate::authorize('update', $product);

        $request->validate([
            'image' => 'nullable|image|dimensions:min_width=200,min_height=200',
            'food_name' => 'required|string',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:1000',
            'discount' => 'required|integer|min:0|max:95',
        ]);

        if($request->file('image')){
            $image = Image::make($request->file('image'));
            $dim = min($image->width(), $image->height(), 500);

            $filename = Str::random(64).'.jpg';
            Storage::put("products/$filename", $image->fit($dim)->encode('jpg', 80));

            $product->image = $filename;
        }

        $product->category_id = $request->category_id;
        $product->name = $request->food_name;
        $product->description = $request->description;
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->save();

        $request->session()->flash('success', 'Data produk telah diperbarui.');

        return redirect()->route('manage.products.show', $product);
    }

    /**
     * Update Stock
     *
     * @param Request $request
     */
    public function updateStock(Request $request, Product $product){
        Gate::authorize('update', $product);

        $request->validate(['stock' => 'required|integer|min:0']);

        $product->stock = $request->stock;
        $product->save();

        $request->session()->flash('success', 'Stok produk telah diperbarui.');
        return redirect()->route('manage.products.show', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        Gate::authorize('delete', $product);

        $product->delete();

        $request->session()->flash('success', 'Data produk telah dihapus.');

        return redirect()->route('manage.products.index');
    }
}
