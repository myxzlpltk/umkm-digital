@extends('layouts.default.app')

@section('title', 'Keranjang')
@section('body.className', 'bg-white')

@push('stylesheets')
@endpush

@section('header')
    <div class="header bg-gradient-indigo py-5">
        <div class="container">
            <div class="header-body text-center">
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid bg-gradient-indigo">
        <div class="container py-5">
            <h1 class="text-center text-white">Keranjang Saya</h1>

            <div class="card mt-4">
                @foreach($carts as $list)
                @php $seller = $list->first()->product->seller @endphp
                <div class="p-3">
                    <div class="d-flex w-100 align-items-center mb-3">
                        <img src="{{ asset('storage/logos/'.$seller->logo) }}" alt="Image placeholder" class="avatar avatar-sm mr-2" />
                        <h5 class="mb-1">{{ $seller->store_name }}</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $cart)
                                <tr>
                                    <td>{{ $cart->product->name }}</td>
                                    <td>{{ UserHelp::idr($cart->product->price) }}</td>
                                    <td style="width: 10%">
                                        <form action="{{ route('carts.update', $cart) }}" method="post">
                                            @csrf
                                            @method('PATCH')

                                            <div class="form-group mb-0">
                                                <input type="number" value="{{ old('qty', $cart->qty) }}" class="form-control form-control-sm text-center @error('qty') is-invalid @enderror" name="qty" min="1" max="{{ $cart->product->stock }}" required>
                                                @error('qty')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </form>
                                    </td>
                                    <td>{{ UserHelp::idr($cart->subtotal) }}</td>
                                    <td>
                                        <form class="d-inline" action="{{ route('carts.destroy', $cart) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:void(0)" class="table-action btn-delete" data-toggle="tooltip" data-original-title="Hapus">
                                                <i class="fas fa-trash text-red"></i>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Total</th>
                                    <td>{{ UserHelp::idr($list->sum('subtotal')) }}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm">Bayar</a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @if(!$loop->last) <hr class="mx-3 my-0"/> @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('[name="qty"]').each(function (){
                var qty = $(this).val();
                $(this).blur(function (){
                    if(qty != $(this).val()){
                        $(this).closest('form').submit();
                    }
                });
            });
        });
    </script>
@endpush
