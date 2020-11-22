@extends('layouts.console.app')

@section('title', 'Edit Kategori')

@section('breadcrumbs', Breadcrumbs::render('manage.categories.edit', $category))

@push('stylesheets')
@endpush

@section('actions')
@endsection

@section('card-stats')
@endsection

@section('header')
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="h3 mb-0">Formulir</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('manage.categories.update', $category) }}" method="post">
                @method('PATCH')
                @csrf

                <div class="form-group">
                    <label for="input-name">Nama Kategori</label>
                    <input type="text" id="input-name" name="category_name" class="form-control @error('category_name') is-invalid @enderror" value="{{ old('name', $category->name) }}" placeholder="Masukkan nama kategori" autofocus required>
                    @error('category_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Perbarui</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
