<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\StoreCreated;
use App\Services\TenantService;
use DB;
use Artisan;
use Config;
use DirectoryIterator;
use Storage;
class CreateStoreDatabase
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(StoreCreated $event)
    {
        $store = $event->store;

        $db ="phenixmenu_{$store->domain}";
        $storage_folder="phenixmenu_{$store->domain}";

        $store->database_options=[
            'DBName'=>$db
        ];

        $store->save();


        DB::statement("CREATE DATABASE `{$db}`");

        TenantService::switchToStore($store);

        Config::set('database.connections.tenant.database',$db);

        Storage::disk('tenant')->makeDirectory($storage_folder);
        Storage::disk('tenant')->makeDirectory('framework/cache/'.$storage_folder);

       // dd(DB::getConnections());

        $dir = new DirectoryIterator(database_path('migrations/tenants'));
        foreach($dir as $file){
            if($file->isFile()){
                Artisan::call('migrate',[
                    '--database'=>'tenant',
                    '--path'=>'database/migrations/tenants/'.$file->getFileName(),
                    '--force'=>true
                ]); 
            }
        }


    }
  
}
