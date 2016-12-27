<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middlewareGroups' => ['web']], function () {

    // Authentication Routes
    Route::get('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

    // Registration Routes
    Route::get('auth/register', 'Auth\AuthController@getRegister');
    Route::post('auth/register', 'Auth\AuthController@postRegister');

    // Password Reset Routes
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');

    //Applications Routes
    Route::get('blog/{slug}', ['as' => 'blog.single', 'uses' => 'BlogController@getSingle'])
    ->where('slug', '[\w\d\-\_]+');

    Route::get('blog', ['uses' => 'BlogController@getIndex', 'as' => 'blog.index']);

    Route::get('contact', 'PagesController@getContact');
    Route::post('contact', 'PagesController@postContact');

    Route::get('about', 'PagesController@getAbout');

    Route::get('/', 'PagesController@getIndex');

    Route::resource('posts', 'PostController');

    Route::resource('categories', 'CategoryController', ['except' => ['create']]);

    Route::resource('tags', 'TagController', ['except' => ['create']]);

    // Comments Route
    Route::post('comments/{post_id}', ['as' => 'comments.store', 'uses' => 'CommentsController@store']);

    Route::get('comments/{id}/edit', ['as' => 'comments.edit', 'uses' => 'CommentsController@edit']);

    Route::put('comments/{id}', ['as' => 'comments.update', 'uses' => 'CommentsController@update']);

    Route::get('comments/{id}/delete', ['as' => 'comments.delete', 'uses' => 'CommentsController@delete']);

    Route::delete('comments/{id}', ['as' => 'comments.destroy', 'uses' => 'CommentsController@destroy']);

});

