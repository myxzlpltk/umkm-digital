<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller{

    public function index(){
        if(Gate::allows('isAdmin')){
            return view('manage.admin', [
                'stat_product' => Product::count(),
                'stat_category' => Category::count(),
                'stat_transaction' => Order::count(),
                'stat_canceled' => Order::whereIn('status_code', [
                    Order::CANCELED,
                    Order::REFUND_BEING_PROCESSED,
                    Order::REFUND_COMPLETED,
                ])->count()
            ]);
        }
        elseif(Gate::allows('isSeller')){
            return view('manage.seller', [
                'seller' => auth()->user()->seller,
                'stat_product' => auth()->user()->seller->products()->count(),
                'stat_category' => auth()->user()->seller->categories()->count(),
                'stat_transaction' => auth()->user()->seller->orders()->count(),
                'stat_canceled' => auth()->user()->seller->orders()->whereIn('status_code', [
                    Order::CANCELED,
                    Order::REFUND_BEING_PROCESSED,
                    Order::REFUND_COMPLETED,
                ])->count()
            ]);
        }

        return abort(404);
    }
}
