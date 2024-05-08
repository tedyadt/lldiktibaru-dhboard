<?php

use App\Http\Controllers\AktaController;
use Illuminate\Support\Facades\Route;

$main_url = 'akta';

Route::get('/'.$main_url.'/aktabyidpertijson/{id_perti}', [AktaController::class, 'aktabyidpertijson'])->name($main_url.'.getByIdperti');
Route::resource($main_url, AktaController::class)->names([
    'index' => $main_url,
    'store' =>  $main_url.".store",
]);

