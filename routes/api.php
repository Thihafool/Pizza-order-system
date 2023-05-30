<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RouteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Get
Route::get('product/list',[RouteController::class,'productList']);
Route::get('category/list',[RouteController::class,'categoryList']); //Read

Route::get('category/details/{id}',[RouteController::class,'categoryDetails']); //Read


//Post
Route::post('create/category',[RouteController::class,'categoryCreate']);
Route::post('create/contact',[RouteController::class,'createContact']); //create

Route::post('category/delete',[RouteController::class,'deleteCategory']);
Route::get('category/delete/{id}',[RouteController::class,'deleteCategory']); //delete

Route::post ('category/details',[RouteController::class,'categoryDetails']);
// Route::get ('category/details/{id}',[RouteController::class,'categoryDetails']);
Route::post ('category/update',[RouteController::class,'categoryUpdate']); //update
