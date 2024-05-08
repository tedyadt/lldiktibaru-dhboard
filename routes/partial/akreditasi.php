<?php

use App\Http\Controllers\AkreditasiController;
use Illuminate\Support\Facades\Route;

$main_url = 'akreditasi';

Route::get('/'.$main_url.'/akreditasibyidpertiprodijson/{id_perti_prodi}/{byperti_prodi}', [AkreditasiController::class, 'akreditasibyidpertiprodijson'])->name($main_url.'.getByIdperti_prodi');
Route::resource($main_url, AkreditasiController::class)->names([
    'index' => $main_url,
    'store' =>  $main_url.".store",
]);

