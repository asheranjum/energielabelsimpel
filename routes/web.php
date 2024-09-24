<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\FEHomeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FEHomeController::class, 'index'])->name('index');
Route::get('/projecten', [FEHomeController::class, 'projecten'])->name('projecten');
Route::get('/bestaand', [FEHomeController::class, 'bestaand'])->name('bestaand');
Route::get('/nieuwbouw', [FEHomeController::class, 'nieuwbouw'])->name('nieuwbouw');

// Route::get('/', function () {
//     return Redirect::to(config('app.url') . '/admin/login');
//       // return Redirect::to('url');
// });



Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');

  return 'done';
});



Route::get('admin/duplicate/{product}', 'App\Http\Controllers\ProductDuplicationController@duplicate')->name('voyager.products.duplicate');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('admin/duplicate3d/{product}', 'App\Http\Controllers\ProductDuplicationController@duplicate3d')->name('voyager.products.duplicate3d');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});




