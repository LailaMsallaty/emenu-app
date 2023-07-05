<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Lang;
use App\Models\TblOption;
use App\Models\Page;
use App\Models\Store;
use DB;
use App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->bind('languages',function($app){
             return Lang::pluck('lang_name','lang_code');
         });


         $this->app->singleton('option', function($app) {
            return new TblOption();
        });

        $this->app->singleton('pages', function($app) {
            return Page::all();
        });

        $this->app->singleton('storage',function($app){
            return (app()->bound('store.active'))?'phenixmenu_'.app()->make('store.active')->domain.'/':'';
          });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
