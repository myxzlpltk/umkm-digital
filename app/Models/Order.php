<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const PAYMENT_PENDING = 1;
    const PAYMENT_IN_PROCESS = 2;
    const ORDER_BEING_PROCESSED = 3;
    const IN_DELIVERY = 4;
    const ORDER_COMPLETED = 5;
    const CANCELED = 6;
    const REFUND_BEING_PROCESSED = 7;
    const REFUND_COMPLETED = 8;

    const status = [
        self::PAYMENT_PENDING => 'Menunggu Pembayaran',
        self::PAYMENT_IN_PROCESS => 'Pembayaran Diproses',
        self::ORDER_BEING_PROCESSED => 'Pesanan Diproses',
        self::IN_DELIVERY => 'Sedang Pengantaran',
        self::ORDER_COMPLETED => 'Pesanan Selesai',
        self::CANCELED => 'Dibatalkan',
        self::REFUND_BEING_PROCESSED => 'Uang Sedang Dikembalikan',
        self::REFUND_COMPLETED => 'Uang Telah Dikembalikan',
    ];

    protected $attributes = [
        'payment_proof' => null
    ];

    public function buyer(){
        return $this->belongsTo('App\Models\Buyer');
    }

    public function seller(){
        return $this->belongsTo('App\Models\Seller');
    }

    public function details(){
        return $this->hasMany('App\Models\OrderDetail');
    }

    public function tracks(){
        return $this->hasMany('App\Models\Track');
    }

    public function getTotalAttribute(){
        return $this->details->sum('subtotal');
    }

    public function getNoInvoiceAttribute(){
        $romawi = [null,"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII"];
        return "INV/{$this->created_at->year}/{$romawi[$this->created_at->month]}/{$this->id}";
    }

    public function getStatusAttribute(){
        return key_exists($this->status_code, self::status)
            ? __(self::status[$this->status_code])
            : __('Tidak Diketahui');
    }
}
