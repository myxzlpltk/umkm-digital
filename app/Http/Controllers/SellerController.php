<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SellerController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //
    }

    /**
     * Display my store
     *
     * @return \Illuminate\Http\Response
     */
    public function myStore(Request $request){
        $seller = $request->user()->seller;

        return view('sellers.manage', [
            'seller' => $seller
        ]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller){
        $now = Carbon::now();
        $today = $seller->days()->where('index', $now->dayOfWeek)->first();

        $i = 1;
        if(!is_null($today) && Carbon::parse($today->pivot->start)->gte($now)){
            $tomorrow = $today;
        }
        else {
            do {
                $tomorrow = $seller->days->where('index', ($now->dayOfWeek + $i) % 7)->first();
                $i++;
            } while ($tomorrow == null);
        }

        $isOpen = $today
            && Carbon::parse($today->pivot->start)->lte($now)
            && Carbon::parse($today->pivot->end)->gte($now);

        return view('sellers.show', [
            'seller' => $seller,
            'isOpen' => $isOpen,
            'today' => $today,
            'tomorrow' => $tomorrow,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
