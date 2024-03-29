<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Product routes
Route::any('add', 'ProductController@add');
Route::any('update', 'ProductController@update');
Route::any('delete', 'ProductController@delete');
Route::any('show', 'ProductController@show');

// User routes
Route::any('register', 'UserController@register');
Route::any('login', 'UserController@login');
