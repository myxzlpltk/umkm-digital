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
Breadcrumbs::for('admin.buyers.list', function ($trail){
    $trail->parent('home');
    $trail->push('Pembeli', route('admin.buyers.list'));
});

// Seller
Breadcrumbs::for('admin.sellers.list', function ($trail){
    $trail->parent('home');
    $trail->push('Penjual', route('admin.sellers.list'));
});
