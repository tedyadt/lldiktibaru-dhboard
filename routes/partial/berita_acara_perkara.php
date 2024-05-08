<?php

use App\Http\Controllers\BeritaAcaraPerkaraController;
use Illuminate\Support\Facades\Route;

$main_url = 'berita-acara-perkara';

Route::get('/'.$main_url.'/beritaacaraperkarabyidorganization/{id_organization}', [BeritaAcaraPerkaraController::class, 'beritaacaraperkarabyidorganization'])->name($main_url.'.getByIdOrganization');
Route::get('/'.$main_url.'/statusdetail/{id_bap}', [BeritaAcaraPerkaraController::class, 'statusdetail'])->name($main_url.'.getStatusDetail');
Route::post('/'.$main_url.'/create-status', [BeritaAcaraPerkaraController::class, 'createstatus'])->name($main_url.'.createStatus');
Route::resource($main_url, BeritaAcaraPerkaraController::class)->names([
    'index' => $main_url,
    'store' =>  $main_url.".store",
]);

