<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller{

    public function index(Request $request, $type = "pending"){
        if($type == "pending"){
            $statusCodes = [1,2];
        }
        elseif($type == "process"){
            $statusCodes = [3,4];
        }
        elseif($type == "complete"){
            $statusCodes = [5];
        }
        elseif($type == "cancel"){
            $statusCodes = [6,7,8];
        }
        else{
            return abort(404);
        }

        return view('orders.index', [
            'orders' => $request->user()->buyer
                ->orders()
                ->with(['seller','details.product'])
                ->whereIn('status_code', $statusCodes)
                ->orderByDesc('created_at')
                ->paginate(10)
        ]);
    }

    public function create(Request $request, Seller $seller){
        if(Gate::denies('isBuyerRegistered')){
            return redirect()->route('profile')->with([
                'error' => 'Kamu harus mengisi informasi pembeli terlebih dahulu.'
            ]);
        }

        $buyer = $request->user()->buyer;
        $carts = $buyer->carts()
            ->with('product.seller')->get()
            ->filter(function (Cart $cart) use ($seller){
                return $cart->product->seller->id == $seller->id;
            });

        if($carts->isEmpty()){
            return abort(404);
        }

        try {
            DB::beginTransaction();
            $order = new Order;
            $order->buyer_id = $buyer->id;
            $order->seller_id = $seller->id;
            $order->address = $buyer->address;
            $order->status_code = Order::PAYMENT_PENDING;
            $order->save();

            foreach ($carts as $cart){
                $detail = new OrderDetail;
                $detail->order_id = $order->id;
                $detail->product_id = $cart->product->id;
                $detail->price = $cart->product->price;
                $detail->discount = $cart->product->discount;
                $detail->qty = $cart->qty;
                $detail->save();

                $cart->delete();
            }

            DB::commit();

            return redirect()->route('orders.show', $order)->with([
                'success' => 'Silahkan kamu melakukan pembayaran ke rekening toko'
            ]);
        } catch (\Exception $e){
            DB::rollBack();

            return redirect()->route('carts.index')->with([
                'error' => 'Terjadi kesalahan pada sistem. Coba lagi nanti.'.$e->getMessage()
            ]);
        }
    }

    public function show(Request $request, Order $order){
        Gate::authorize('view', $order);

        return view('orders.show', [
            'order' => $order
        ]);
    }
}
