<?php
$prefix = 'Capmega\Base\Controllers';


Route::namespace('\Capmega\Base\Controllers')->group(function () {
    Route::get('social-auth/{type}', 'SocialAuthController@login')->name('social-auth');
    Route::post('subscription', 'SubscriptionController@addEmail')->name('subscription.new');
    Route::get('subscription/csv', 'SubscriptionController@csv')->name('subscription.csv');
    Route::get('subscription/{id}/{key}', 'SubscriptionController@removeEmail')->name('subscription.remove');
    Route::prefix('admin')
    ->middleware(['web', 'auth', 'role:super-admin'])
    ->group(function () {
        Route::match(['get', 'post'], 'configuration/general', 'ConfigurationController@general')->name('configuration.general');
        Route::match(['get', 'post'], 'generator/model', 'GeneratorController@model')->name('generator.model');
        Route::match(['get', 'post'], 'generator/crud', 'GeneratorController@crud')->name('generator.crud');
        Route::match(['get', 'post'], 'images/create-multiple', 'ImageController@createMultiple')->name('images.create-multiple');
        Route::resource('images', 'ImageController');
        Route::resource('cdn',    'CdnController');
        Route::resource('images-type', 'ImagesTypeController');
        Route::post('images-type/addSize/{id}', 'ImagesTypeController@addSize')->name('images-type.addsize');
        Route::post('images-type/removeSize/{id}', 'ImagesTypeController@removeSize')->name('images-type.removesize');
        Route::post('images/addSize/{id}', 'ImageController@addSize')->name('images.addsize');
        Route::post('images/removeSize/{id}', 'ImageController@removeSize')->name('images.removesize');
        Route::resource('subscription', 'SubscriptionController');
    });
});
