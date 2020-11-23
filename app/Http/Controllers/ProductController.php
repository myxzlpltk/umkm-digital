<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;

class ProductController extends Controller{

    /**
     * Search products
     *
     * @param Request $request
     */
    public function search(Request $request){
        try{
            if($request->min && $request->min < 0){
                $request->min = 0;
                throw new \Exception();
            }
            if($request->max && $request->max < $request->min){
                $request->max = 0;
                throw new \Exception();
            }
        } catch (\Exception $exc){
            return redirect()->route('search', [
                'q' => $request->q,
                'min' => $request->min,
                'max' => $request->max,
            ]);
        }

        if($request->store) {
            $sellers = Seller::query()
                ->where('store_name', 'like', "%{$request->q}%")
                ->paginate(24);
        }
        else{
            $products = Product::query()
                ->where('name', 'like', "%{$request->q}%")
                ->where(function ($query) use ($request) {
                    if ($request->min) $query->where('price', '>=', $request->min);
                    if ($request->max) $query->where('price', '<=', $request->max);
                })
                ->paginate(24);
        }

        return view('products.search', [
            'products' => !empty($products) ? $products : collect(),
            'sellers' => !empty($sellers) ? $sellers : collect(),
            'q' => $request->q,
            'min' => $request->input('min', ''),
            'max' => $request->input('max', ''),
            'isStore' => boolval($request->store),
        ]);
    }
}
