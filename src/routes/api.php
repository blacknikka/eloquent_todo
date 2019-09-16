<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// todo
Route::group(
    [
        'prefix' => 'v1/todo',
    ],
    function () {
        Route::get('/{id}', 'Todo\TodoController@getTodosByUserId')
        ->name('getTodo');

        Route::post('/{id}', 'Todo\TodoController@createTodoByUserId')
        ->name('createTodo');
    }
);
