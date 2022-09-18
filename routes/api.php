<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);

Route::group(['middleware'=>'auth:sanctum'],function(){

    Route::get('user',[AuthController::class,'userInfo']);
    Route::patch('user-update',[AuthController::class,'userUpdate']);
    Route::patch('user-update-pass',[AuthController::class,'userPass']);
    
    Route::group(['prefix'=>'patient'],function(){
        Route::get('/',[PatientController::class,'getAll']);
        Route::post('/',[PatientController::class,'add']);
        Route::get('/{id}',[PatientController::class,'detail']);
        Route::patch('/{id}',[PatientController::class,'edit']);
        Route::delete('/{id}',[PatientController::class,'remove']);
    });

    Route::group(['prefix'=>'service'],function(){
        Route::get('/today',[ServiceController::class,'today']);
        Route::get('/after',[ServiceController::class,'after']);
        Route::get('/before',[ServiceController::class,'before']);
        Route::get('/{id}',[ServiceController::class,'detail']);
        Route::post('/add-prescription/{id}',[ServiceController::class,'addPrescription']);
        Route::delete('/remove-prescription/{id}',[ServiceController::class,'removePrescription']);
        Route::post('/add-analysis/{id}',[ServiceController::class,'addAnalysis']);
        Route::delete('/remove-analysis/{id}',[ServiceController::class,'removeAnalysis']);
        Route::patch('/change-status/{id}',[ServiceController::class,'changeStatus']);
        Route::post('/add',[ServiceController::class,'add']);
        Route::get('/my-services/today',[ServiceController::class,'myServicesToday']);
        Route::get('/my-services/before',[ServiceController::class,'myServicesBefore']);
        Route::get('/my-services/after',[ServiceController::class,'myServicesAfter']);
    });

    Route::group(['prefix'=>'payment'],function(){
        Route::get('/',[PaymentController::class,'getAll']);
        Route::post('/',[PaymentController::class,'add']);
        Route::get('/{id}',[PaymentController::class,'detail']);
        Route::patch('/{id}',[PaymentController::class,'edit']);
        Route::delete('/{id}',[PaymentController::class,'remove']);
    });

});