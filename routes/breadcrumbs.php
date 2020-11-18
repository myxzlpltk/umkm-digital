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
    $trail->push('Produk', route('manage.product.index'));
});

// Categories
Breadcrumbs::for('manage.categories.index', function ($trail){
    $trail->parent('home');
    $trail->push('Kategori', route('manage.categories.index'));
});
