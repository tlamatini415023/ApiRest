<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//importamos los controladores ProductController y el AuthController
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function(Request $request){
    return $request->user();
});
Route::get('products',[ProductController::class,'index']);
//ruta de tipo get con url products, llama al controller ProductController y al método index devuelve todo productos BD
Route::post('register',[AuthController::class,'register']);
//tomamos el anterior y combiamos el método 'login' y cambiamos la url 'login' 
Route::post('login',[AuthController::class,'login']);
Route::get('login',[AuthController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('logout',[AuthController::class,'logout']);    
    
});
