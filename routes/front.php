<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontEnd\MainController;

Route::get('/', [MainController::class,'index']);

Route::group([
    'prefix'=>'/{locale}',
    'midleware'=>['FrontMiddleware']
],function(){

    Route::get('/', [MainController::class,'index'])->name('app.index');
    Route::post('/orderStore', [MainController::class,'store'])->name('orderStore');

});
?>
