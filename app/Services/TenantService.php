<?php

namespace App\Services;
use App\Models\Store;
use DB;
use App;
use Config;
use Crypt;
class TenantService
{

    public static function switchToStore(Store $store){

        DB::purge('mysql');
        DB::purge('tenant');
        $db = $store->database_options['DBName'];
        Config::set('database.connections.tenant',[
            'driver'=>'mysql',
            'host'=>'127.0.0.1',
            'database'=>$db,
            'username'=>$store->db_username,
            'password'=>($store->db_password!=='')? Crypt::decrypt($store->db_password):''
        ]);
        $storage_folder="phenixmenu_{$store->domain}";

        Config::set("filesystems.disks.tenant.root",storage_path("app/public/{$storage_folder}"));
        Config::set("cache.stores.tenant.path",storage_path("framework/cache/{$storage_folder}/data"));

        // print(storage_path("framework/cache/{$storage_folder}/data"));
        // exit;
        DB::connection('tenant');
    }
    public static function switchToDefault(){
        DB::purge('mysql');
        DB::purge('tenant');

        DB::connection('mysql')->reconnect();
        DB::setDefaultConnection('mysql');
   }

}
