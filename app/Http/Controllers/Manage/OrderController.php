<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        if(Gate::allows('isAdmin')){
            return view('orders.manage.index', [
                'orders' => Order::all()
            ]);
        }
        elseif(Gate::allows('isSellerHasStore')){
            return view('orders.manage.index', [
                'orders' => $request->user()->seller->orders()->with(['details','buyer.user'])->get()
            ]);
        }
        else{
            return abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order){
        Gate::authorize('view', $order);

        return view('orders.manage.show', [
            'order' => $order
        ]);
    }

    public function acceptPayment(Request $request, Order $order){
        Gate::authorize('accept-payment', $order);

        $order->status_code = Order::ORDER_BEING_PROCESSED;
        $order->save();

        return redirect()->route('manage.orders.show', $order)->with([
            'success' => 'Status pesanan berhasil diperbarui.'
        ]);
    }

    public function denyPayment(Request $request, Order $order){
        Gate::authorize('deny-payment', $order);

        $order->status_code = Order::PAYMENT_PENDING;
        $order->save();

        return redirect()->route('manage.orders.show', $order)->with([
            'success' => 'Status pesanan berhasil diperbarui.'
        ]);
    }

    public function deliver(Request $request, Order $order){
        Gate::authorize('deliver', $order);

        $order->status_code = Order::IN_DELIVERY;
        $order->save();

        return redirect()->route('manage.orders.show', $order)->with([
            'success' => 'Status pesanan berhasil diperbarui.'
        ]);
    }

    public function deliveryComplete(Request $request, Order $order){
        Gate::authorize('delivery-complete', $order);

        $order->status_code = Order::ORDER_COMPLETED;
        $order->save();

        return redirect()->back()->with([
            'success' => 'Status pesanan berhasil diperbarui.'
        ]);
    }

    public function cancel(Request $request, Order $order){
        Gate::authorize('cancel', $order);

        $order->status_code = Order::CANCELED;
        $order->save();

        return redirect()->back()->with([
            'success' => 'Status pesanan berhasil diperbarui.'
        ]);
    }

    public function requestRefund(Request $request, Order $order){
        Gate::authorize('request-refund', $order);

        $order->status_code = Order::REQUEST_REFUND;
        $order->save();

        if($request->user()->isSeller){
            $order->status_code = Order::REFUND_BEING_PROCESSED;
            $order->save();
        }

        return redirect()->back()->with([
            'success' => 'Status pesanan berhasil diperbarui.'
        ]);
    }

    public function refund(Request $request, Order $order){
        Gate::authorize('refund', $order);

        $order->status_code = Order::REFUND_BEING_PROCESSED;
        $order->save();

        return redirect()->back()->with([
            'success' => 'Status pesanan berhasil diperbarui.'
        ]);
    }

    public function refundComplete(Request $request, Order $order){
        Gate::authorize('refund-complete', $order);

        $order->status_code = Order::REFUND_COMPLETED;
        $order->save();

        return redirect()->back()->with([
            'success' => 'Status pesanan berhasil diperbarui.'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
