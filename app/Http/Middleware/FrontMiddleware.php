<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App;
use Session;
class FrontMiddleware
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
        if ($request->tbcode)
        {
            $tb = base64_decode($request->tbcode);
            $table_codes = App::make('option')->where('opvar','tblcodes')->first()->toArray();
            $tbarr = explode(',',$table_codes['opval']);
            if (in_array($tb,$tbarr))
            {
                $request->session()->put('tablecode',$tb);

            }else{
                $request->session()->put('tablecode','');
            }
        }
        if ($request->page=='placeorder') {

            $request->session()->put('currentpage','placeorder');
        }
        else if($request->page=='cms'){

            $request->session()->put('currentpage','cms');

        }
        else if(($request->page=='confirmation') && (Session::get('confirmationtoken') == $request->token )){

            $request->session()->put('currentpage','confirmation');


        }else if(($request->page=='error') && (Session::get('confirmationtoken') == $request->token )){

            $request->session()->put('currentpage','error');
        }
        else{
            $request->session()->put('currentpage','menu_list');

        }
        return $next($request);
    }
}
