<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Services\TenantService;
use App;
use Config;
use Crypt;
use DB;
class SetActiveStore
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $subdomain = explode('.', request()->getHttpHost());

        $store = Store::where('domain',$subdomain[0])->first();

        App::instance('store.active',($store)?$store:null);

        if($store){
            TenantService::switchToStore($store);
            App::instance('store.active',$store);
        }
        return $next($request);
    }
}
