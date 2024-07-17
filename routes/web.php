<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Livewire\PenerimaanBarang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Route::middleware(['auth'])->group(function () {
//     Route::get('/penerimaan-barang', PenerimaanBarang::class);
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/penerimaan-barang', [App\Http\Controllers\HomeController::class, 'welcome']);
});

Route::post('/file-upload', function (Request $request) {
    $request->validate([
        'photo' => 'required|image|max:2048',
    ]);

    $path = $request->file('photo')->store('photos', 'public');

    return response()->json(['fileName' => $path]);
})->name('file.upload');


// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
