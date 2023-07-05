<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;


class SetAppLocale
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
        // $locale=$request->query('lang',Session::get('lang','en'));
        // Session::put('lang',$locale);
        // App::SetLocale($locale);

        $locale=(sizeof(app()->make('languages')->keys())>0)?app()->make('languages')->keys()[0]:App::getLocale();
        $locale= $request->route('locale',$locale);

        App::SetLocale($locale);

       // dd(App::getLocale());

        URL::defaults([
            'locale'=> $locale,
        ]);
        Route::current()->forgetParameter('locale');
        return $next($request);
    }
}
