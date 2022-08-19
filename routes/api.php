<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

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

Route::resource('users', 'API\UserController');

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('user-profile', [AuthController::class, 'userProfile']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('/auth/user', 'API\UserController');

    Route::resource('/teachers', 'API\TeacherController');
    Route::post('upload-teacher-profile', 'API\TeacherController@uploadTeacherProfile');
    Route::get('get-teacher-profile/{id}', 'API\TeacherController@getTeacherProfile');
    Route::resource('/students', 'API\StudentController');
    Route::resource('/classes', 'API\ClassesController');
});