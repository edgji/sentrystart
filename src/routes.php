<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

// Session Routes
Route::get('login',  array('as' => 'login', 'uses' => 'Edgji\Sentrystart\SessionController@create'));
Route::get('logout', array('as' => 'logout', 'uses' => 'Edgji\Sentrystart\SessionController@destroy'));
Route::resource('sessions', 'Edgji\Sentrystart\SessionController', array('only' => array('create', 'store', 'destroy')));

// User Routes
Route::get('register', 'Edgji\Sentrystart\UserController@create');
Route::get('users/{id}/activate/{code}', 'Edgji\Sentrystart\UserController@activate')->where('id', '[0-9]+');
Route::get('resend', array('as' => 'resendActivationForm', function()
{
    return View::make('sentrystart:users.resend');
}));
Route::post('resend', 'Edgji\Sentrystart\UserController@resend');
Route::get('forgot', array('as' => 'forgotPasswordForm', function()
{
    return View::make('sentrystart::users.forgot');
}));
Route::post('forgot', 'Edgji\Sentrystart\UserController@forgot');
Route::post('users/{id}/change', 'Edgji\Sentrystart\UserController@change');
Route::get('users/{id}/reset/{code}', 'Edgji\Sentrystart\UserController@reset')->where('id', '[0-9]+');
Route::get('users/{id}/suspend', array('as' => 'suspendUserForm', function($id)
{
    return View::make('sentrystart::users.suspend')->with('id', $id);
}));
Route::post('users/{id}/suspend', 'Edgji\Sentrystart\UserController@suspend')->where('id', '[0-9]+');
Route::get('users/{id}/unsuspend', 'Edgji\Sentrystart\UserController@unsuspend')->where('id', '[0-9]+');
Route::get('users/{id}/ban', 'Edgji\Sentrystart\UserController@ban')->where('id', '[0-9]+');
Route::get('users/{id}/unban', 'Edgji\Sentrystart\UserController@unban')->where('id', '[0-9]+');
Route::resource('users', 'Edgji\Sentrystart\UserController');

// Group Routes
Route::resource('groups', 'Edgji\Sentrystart\GroupController');