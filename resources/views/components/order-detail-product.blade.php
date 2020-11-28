<div class="row align-items-center mb-1">
    <div class="col-auto">
        <img src="{{ asset('storage/products/'.$detail->product->image) }}" alt="" class="img-fluid rounded" style="height: 50px;">
    </div>
    <div class="col">
        <h4 class="mb-0">{{ $detail->product->name }}</h4>
        <small>{{ $detail->qty }} Produk x {{ UserHelp::idr($detail->price_after_discount) }}</small>
    </div>
    <div class="col border-left">
        <h5 class="mb-0">Total Harga Produk</h5>
        <h4 class="mb-0 text-orange"><strong>{{ UserHelp::idr($detail->subtotal) }}</strong></h4>
    </div>
    @if($withAction)
    <div class="col">
        <a href="{{ route('carts.add', $detail->product) }}" class="btn btn-primary btn-sm"><i class="fa fa-cart-plus fa-fw"></i> Beli Lagi</a>
    </div>
    @endif
</div>
