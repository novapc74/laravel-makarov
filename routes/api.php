<?php

use App\Http\Controllers\PartnershipController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;

Route::group([
    'prefix' => 'api',
    'namespace' => '\App\Http\Controllers',
], function () {

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')/*->middleware('auth:api')*/;
        Route::get('/users/{id}', 'show');
        Route::post('/users', 'store');
        Route::patch('/users/{id}', 'update');
        Route::delete('/users/{id}', 'update');
    });

    Route::controller(PartnershipController::class)->group(function () {
        Route::get('/partnerships', 'index');
        Route::get('/partnerships/{id}', 'show');
        Route::post('/partnerships', 'store');
        Route::patch('/partnerships/{id}', 'update');
        Route::delete('/partnerships/{id}', 'update');
    });

    Route::controller(WorkerController::class)->group(function () {
        Route::get('/workers', 'index');
        Route::get('/workers/{id}', 'show');
        Route::post('/workers', 'store');
        Route::patch('/workers/{id}', 'update');
        Route::delete('/workers/{id}', 'update');
    });
});


Route::group([
    'as' => 'passport.',
    'prefix' => config('passport.path', 'api/passport'),
    'namespace' => '\Laravel\Passport\Http\Controllers',
], function () {
    Route::post('/token', [
        'uses' => 'AccessTokenController@issueToken',
        'as' => 'token',
        'middleware' => 'throttle',
    ]);

    Route::get('/authorize', [
        'uses' => 'AuthorizationController@authorize',
        'as' => 'authorizations.authorize',
        'middleware' => 'web',
    ]);

    $guard = config('passport.guard');

    Route::middleware(['web', $guard ? 'auth:' . $guard : 'auth'])->group(function () {
        Route::post('/token/refresh', [
            'uses' => 'TransientTokenController@refresh',
            'as' => 'token.refresh',
        ]);

        Route::post('/authorize', [
            'uses' => 'ApproveAuthorizationController@approve',
            'as' => 'authorizations.approve',
        ]);

        Route::delete('/authorize', [
            'uses' => 'DenyAuthorizationController@deny',
            'as' => 'authorizations.deny',
        ]);

        Route::get('/tokens', [
            'uses' => 'AuthorizedAccessTokenController@forUser',
            'as' => 'tokens.index',
        ]);

        Route::delete('/tokens/{token_id}', [
            'uses' => 'AuthorizedAccessTokenController@destroy',
            'as' => 'tokens.destroy',
        ]);

        Route::get('/clients', [
            'uses' => 'ClientController@forUser',
            'as' => 'clients.index',
        ]);

        Route::post('/clients', [
            'uses' => 'ClientController@store',
            'as' => 'clients.store',
        ]);

        Route::put('/clients/{client_id}', [
            'uses' => 'ClientController@update',
            'as' => 'clients.update',
        ]);

        Route::delete('/clients/{client_id}', [
            'uses' => 'ClientController@destroy',
            'as' => 'clients.destroy',
        ]);

        Route::get('/scopes', [
            'uses' => 'ScopeController@all',
            'as' => 'scopes.index',
        ]);

        Route::get('/personal-access-tokens', [
            'uses' => 'PersonalAccessTokenController@forUser',
            'as' => 'personal.tokens.index',
        ]);

        Route::post('/personal-access-tokens', [
            'uses' => 'PersonalAccessTokenController@store',
            'as' => 'personal.tokens.store',
        ]);

        Route::delete('/personal-access-tokens/{token_id}', [
            'uses' => 'PersonalAccessTokenController@destroy',
            'as' => 'personal.tokens.destroy',
        ]);
    });
});
