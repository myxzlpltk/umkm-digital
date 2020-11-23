<div class="card p-3 mb-0">
    <div class="row no-gutters">
        <div class="col-md-4">
            <img src="{{ asset('storage/products/'.$product->image) }}" alt="" class="card-img">
        </div>
        <div class="col-md-8">
            <div class="card-body py-0 pl-3 pr-0">
                <h5 class="card-title mb-3 text-truncate">{{ $product->name }}</h5>
                <p class="card-subtitle mb-1 description"><small class="text-muted">{{ $product->description }}{{ $product->description }}</small></p>
                <p class="card-text font-weight-bold mb-0">{{ UserHelp::idr($product->priceAfterDiscount) }}</p>

                @if($product->stock > 0)
                    <a href="{{ route('products.cart', $product) }}" class="btn btn-primary btn-sm float-right"><i class="fa fa-cart-plus"></i></a>
                @else
                    <span class="text-red float-right"><small>Stok Habis</small></span>
                @endif

                @if($product->discount > 0)
                    <span class="badge badge-default bg-gradient-orange">{{ $product->discount }}% Off</span>
                @else
                    <span class="badge badge-default bg-white text-white">0% Off</span>
                @endif

            </div>
        </div>
    </div>
</div>
