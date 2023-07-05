<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Events\StoreCreated;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use DB;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'domain' => ['max:255','unique:stores,domain'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'dbusername' => ['required_with:domain'],
            'dbpassword' => ['confirmed'],
        ]);

        DB::beginTransaction();

        try{
            if(isset($request->domain)){
                $store= Store::create([
                    'name' => $request->name,
                    'domain' => strtolower($request->domain),
                    'db_username'=>$request->dbusername,
                    'db_password'=>($request->dbpassword)?Hash::make($request->dbpassword):''
                ]);
                event(new StoreCreated($store));
                
            }
            $active_store=(app()->bound('store.active'))?app()->make('store.active')->id:null;
            $isOwner=(app()->bound('store.active'))?0:1;



            $user = User::create([
                'name' => $request->name,
                'store_id'=>(isset($store))?$store->id:$active_store,
                'IsOwner'=>$isOwner,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            DB::commit();


        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }

        event(new Registered($user));

        if(!isset($request->domain)){
           Auth::login($user);
        }
        $host = ((isset($store))?$store->domain.'.':'').$request->getHttpHost().'/admin';

        $protocol =explode('//',$request->getSchemeAndHttpHost());

        return redirect()->away($protocol[0].'//'.$host);

    }


}
