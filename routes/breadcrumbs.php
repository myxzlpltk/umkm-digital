<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

// Home
Breadcrumbs::for('home', function ($trail){
    $trail->push('Home', url('/'));
});

// Dashboard
Breadcrumbs::for('manage', function ($trail){
    $trail->parent('home');
    $trail->push('Dashboard', route('manage'));
});

// Buyer
Breadcrumbs::for('manage.buyers.index', function ($trail){
    $trail->parent('home');
    $trail->push('Pembeli', route('manage.buyers.index'));
});

// Seller
Breadcrumbs::for('manage.sellers.index', function ($trail){
    $trail->parent('home');
    $trail->push('Penjual', route('manage.sellers.index'));
});

// Products
Breadcrumbs::for('manage.products.index', function ($trail){
    $trail->parent('home');
    $trail->push('Produk', route('manage.products.index'));
});

// Products > Lihat Produk
Breadcrumbs::for('manage.products.show', function ($trail, $product){
    $trail->parent('manage.products.index');
    $trail->push('Lihat Produk', route('manage.products.show', $product));
});

// Kategori
Breadcrumbs::for('manage.categories.index', function ($trail){
    $trail->parent('home');
    $trail->push('Kategori', route('manage.categories.index'));
});

// Kategori > Tambah Kategori
Breadcrumbs::for('manage.categories.create', function ($trail){
    $trail->parent('manage.categories.index');
    $trail->push('Tambah Kategori', route('manage.categories.create'));
});

// Kategori > Edit Kategori
Breadcrumbs::for('manage.categories.edit', function ($trail, $category){
    $trail->parent('manage.categories.index');
    $trail->push('Edit Kategori', route('manage.categories.edit', $category));
});
