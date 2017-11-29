<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/msg/{data}', function ($data) {
    $data= base64_decode($data);
    $send= new \XB\telegramMethods\sendMessage(['chat_id'=>-1001128665890,'text'=>$data]);
    $send();
    return 'ok';
});
