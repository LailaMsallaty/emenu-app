<?php
use Illuminate\Support\Facades\Route;
use App\http\Controllers\backend\CategoryController;
use App\http\Controllers\backend\MaterialController;
use App\http\Controllers\backend\MaterialUnitController;
use App\http\Controllers\backend\ModifierController;
use App\http\Controllers\backend\ModifierTemplateController;
use App\http\Controllers\backend\PageController;
use App\http\Controllers\backend\SettingsController;
use App\http\Controllers\backend\OrderController;



    Route::get('/admin', function () {
        return view('backend.layouts.main');
    })->middleware(['auth']);

    Route::group([
        'prefix'=>'admin/{locale}',
        'middleware'=>['auth']
    ],function(){
        Route::get('/', function () {
            return view('backend.layouts.main');
        })->name('dashboard');

        // Categories
        Route::resource('category' ,CategoryController::class);
        Route::post('/category/delete_all', [CategoryController::class,'delete_all'])->name('delete_cats_group');
        Route::get('/category', [CategoryController::class,'index'])->name('categories');
        Route::get('/category/create/', [CategoryController::class,'create'])->name('createCategory');
        Route::get('/category/{category}/edit/', [CategoryController::class,'edit'])->name('editCategory');
        Route::get('/category/materials/{category}/', [CategoryController::class,'getMaterials'])->name('CategoryMaterials');
        Route::post('/category/sort', [CategoryController::class,'updateCategorySort'])->name('updateCategorySort');

        // Materials
        Route::resource('material' ,MaterialController::class);
        Route::post('/material/delete_all', [MaterialController::class,'delete_all'])->name('delete_mats_group');

        // Units
        Route::resource('materialunit' ,MaterialUnitController::class);
        Route::get('/material/{material}/units', [MaterialUnitController::class,'index'])->name('material.units');
        Route::post('/materialunit/delete_all', [MaterialUnitController::class,'delete_all'])->name('delete_units_group');
        Route::get('/materialunit/{material}/create', [MaterialUnitController::class,'create'])->name('createMaterialunit');

        //Modifiers
        Route::resource('modifiers' ,ModifierController::class);
        Route::resource('modifiertemplates' ,ModifierTemplateController::class);
        Route::get('/modifiers/{modifiertemplate}/create', [ModifierController::class,'create'])->name('createModifiers');
        Route::get('/modifiertemplates/{modifiertemplate}/modifiers', [ModifierController::class,'index'])->name('modifiertemplate.modifiers');
        Route::post('/modifiertemplates/delete_all', [ModifierTemplateController::class,'delete_all'])->name('delete_templates_group');
        Route::post('/modifiers/delete_all', [ModifierController::class,'delete_all'])->name('delete_modifiers_group');

        //Pages
        Route::resource('pages' ,PageController::class);
        Route::post('/pages/delete_all', [PageController::class,'delete_all'])->name('delete_pages_group');

        //Settings
        Route::post('settings' ,[SettingsController::class,'store'])->name('settings.store');
        Route::get('settings' ,[SettingsController::class,'index'])->name('settings.index');
        Route::post('/settings/performance' ,[SettingsController::class,'storePerformance'])->name('performance.store');
        Route::get('/settings/performance' ,[SettingsController::class,'performance'])->name('performance.index');
        Route::get('/settings/themeLogo' ,[SettingsController::class,'themeLogo'])->name('themeLogo.index');
        Route::post('/settings/themeLogo' ,[SettingsController::class,'upload_files'])->name('themeLogo.store');
        Route::get('/settings/generateTables' ,[SettingsController::class,'generateTables'])->name('generateTables.index');
        Route::post('/settings/generateTables' ,[SettingsController::class,'storeGenerateTables'])->name('generateTables.store');
        Route::get('/settings/generateTables/{codes}' ,[SettingsController::class,'GenerateTablesCodes'])->name('generateTables.codes');
        Route::post('/settings/performance/clear_cache' ,[SettingsController::class,'clear_cache'])->name('performance.clearCache');
        Route::post('/settings/languages' ,[SettingsController::class,'storeLanguages'])->name('languages.store');
        Route::get('/settings/languages' ,[SettingsController::class,'languages'])->name('languages.index');
        Route::post('/settings/languages/delete_all', [SettingsController::class,'delete_all_langs'])->name('delete_langs_group');
        Route::get('/settings/languages/{lang}/edit', [SettingsController::class,'editLang'])->name('language.edit');
        Route::put('/settings/languages/{lang}', [SettingsController::class,'updateLang'])->name('language.update');

        //Orders
        Route::resource('orders' ,OrderController::class);
        Route::post('/orders/delete_all', [OrderController::class,'delete_all'])->name('delete_orders_group');



    });

?>
