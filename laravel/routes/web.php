<?php

use App\Http\Controllers\Admin\PostCommentController;
use App\Http\Controllers\Admin\PostImageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\WebsController;
use Illuminate\Support\Facades\Route;

// admin route resource group middleware
Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    // posts routes resource
    Route::resource('posts', PostController::class)->except(['destroy']);
    Route::as('posts.')->group(function () {
        Route::group(['prefix' => 'posts', 'controller' => PostController::class], function () {
            Route::get('status/{id}', 'status')->whereNumber('id')->name('status');
            Route::get('destroy/{id}', 'destroy')->whereNumber('id')->name('destroy');
            Route::delete('destroy/bulk', 'destroyBulk')->name('destroy.bulk');
        });
        // post images some route
        Route::group(['prefix' => 'post', 'controller' => PostImageController::class], function () {
            Route::get('{id}/images', 'index')->whereNumber('id')->name('images');
            Route::post('{id}/images', 'store')->whereNumber('id')->name('images.store');
            Route::delete('images/destroy/bulk', 'destroyBulk')->name('images.destroy');
        });
        // PostComments some route
        Route::group(['prefix' => 'post', 'controller' => PostCommentController::class], function () {
            Route::get('comments', 'index')->name('comments');
            Route::get('comments/status/{id}', 'status')->whereNumber('id')->name('comments.status');
            Route::get('comments/destroy/{id}', 'destroy')->whereNumber('id')->name('comments.destroy');
            Route::delete('comments/destroy/bulk', 'destroyBulk')->name('comments.destroy.bulk');
        });
    });
    // tags all route
    Route::group(['as' => 'tags.', 'controller' => TagController::class], function () {
        Route::get('tags', 'index')->name('index');
        Route::post('tags', 'store')->name('store');
        Route::put('tags/{id}', 'update')->whereNumber('id')->name('update');
        Route::get('tags/destroy/{id}', 'destroy')->whereNumber('id')->name('destroy');
        Route::delete('tags/destroy/bulk', 'destroyBulk')->name('destroy.bulk');
    });
    // categories all route
    Route::resource('categories', CategoryController::class)->except(['destroy']);
    Route::group(['as' => 'categories.', 'prefix' => 'categories', 'controller' => CategoryController::class], function () {
        Route::post('sortable', 'sortable')->name('sortable');
        Route::get('destroy/{id}', 'destroy')->whereNumber('id')->name('destroy');
        Route::delete('destroy/bulk', 'destroyBulk')->name('destroy.bulk');
    });
});

// web route resource group
Route::group(['as' => 'web.', 'controller' => WebsController::class], function () {
    Route::get('posts/', 'posts')->name('posts.index');
    Route::as('post.')->group(function () {
        Route::get('category/{slug}', 'category')->name('category');
        Route::get('tag/{slug}', 'tag')->name('tag');
        Route::get('search', 'search')->name('search');
        Route::get('post/{slug}', 'post')->name('show');
        Route::post('post-comment', 'commentStore')->name('comment.store');
        Route::post('post-hit/{id}', 'hit')->whereNumber('id')->name('hit');
        Route::post('post-like/{id}', 'like')->whereNumber('id')->name('like');
    });
});
