<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CartController extends Controller{

    public function index(Request $request){
        if (auth()->guest() || $request->user()->buyer == null){
            $carts = collect();
        }
        else{
            $carts = $request->user()
                ->buyer
                ->carts()
                ->with('product.seller')
                ->get()
                ->filter(function (Cart $cart){
                    if($cart->product->stock == 0){
                        $cart->delete();
                    }
                    elseif($cart->qty > $cart->product->stock){
                        $cart->qty = $cart->product->stock;
                        $cart->save();

                        return $cart;
                    }
                    else{
                        return $cart;
                    }
                })
                ->groupBy('product.seller.id');
        }

        return view('carts.cart', [
            'carts' => $carts
        ]);
    }

    public function store(Request $request, Product $product){
        if (auth()->guest()){
            return view('carts.login-request');
        }
        elseif ($request->user()->buyer == null){
            return redirect()->route('profile')->with([
                'error' => 'Kamu harus mengisi info pembeli terlebih dahulu.'
            ]);
        }

        $cart = Cart::firstOrNew([
            'buyer_id' => $request->user()->buyer->id,
            'product_id' => $product->id
        ]);

        $cart->qty++;
        if($cart->qty <= $product->stock){
            $cart->save();
        }

        return redirect()->back()->with([
            'success' => 'Produk telah ditambahkan ke keranjang.'
        ]);
    }

    public function update(Request $request, Cart $cart){
        Gate::authorize('update', $cart);

        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        if($request->qty > $cart->product->stock){
            $cart->qty = $cart->product->stock;
            $cart->save();

            return redirect()->route('carts.index')->with([
                'error' => 'Jumlah produk tidak mencukupi'
            ]);
        }
        else{
            $cart->qty = $request->qty;
            $cart->save();

            return redirect()->route('carts.index')->with([
                'success' => 'Jumlah produk berhasil diperbarui.'
            ]);
        }
    }

    public function destroy(Request $request, Cart $cart){
        Gate::authorize('delete', $cart);

        $cart->delete();

        return redirect()->route('carts.index')->with([
            'success' => 'Produk berhasil dihapus dari keranjang'
        ]);
    }
}
