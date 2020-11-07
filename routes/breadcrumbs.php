<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

// Home
Breadcrumbs::for('home', function ($trail){
    $trail->push('Home', url('/'));
});

// Dashboard
Breadcrumbs::for('dashboard', function ($trail){
    $trail->parent('home');
    $trail->push('Dashboard', route('admin.dashboard'));
});

// Buyer
Breadcrumbs::for('buyer', function ($trail){
    $trail->parent('home');
    $trail->push('Pembeli', route('admin.buyer'));
});

// Seller
Breadcrumbs::for('seller', function ($trail){
    $trail->parent('home');
    $trail->push('Penjual', route('admin.seller'));
});
