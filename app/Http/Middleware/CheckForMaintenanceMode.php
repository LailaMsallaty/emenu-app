<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use App\Models\TblOption;

class CheckForMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected $app;

    protected $request;

    public function __construct(Application $app, Request $request)
    {

        $this->app = $app;

        $this->request = $request;

    }

    public function handle($request, Closure $next)
    {
        // $obj = TblOption::where('opvar','ip_address')->get()->first();
        // $ip= ($obj) ? $obj->opval:"127.0.0.1";

        // if ($this->app->isDownForMaintenance() &&
        //     !in_array($request->getClientIp(), [$ip]))
        // {

        //     throw new HttpException(503);

        // }
        return $next($request);
    }
}
