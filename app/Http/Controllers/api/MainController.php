<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lang;
use App\Http\Requests\api\ApiValidationRequest;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Class constructor.
     */
    /**
     * Class constructor.
     */

    public function index(ApiValidationRequest $request)
    {
        if($request->request_type=='addCategory'){
           return (new CategoryController)->store($request);
        }
        if($request->request_type=='updateCategory'){
           return (new CategoryController)->update($request);
        }
        if($request->request_type=='deleteCategory'){
            return (new CategoryController)->destroy($request);
        }
        if($request->request_type=='addMaterial'){
            return (new MaterialController)->store($request);
        }
        if($request->request_type=='updateMaterial'){
            return (new MaterialController)->update($request);
        }
         if($request->request_type=='deleteMaterial'){
            return (new MaterialController)->destroy($request);
        }
        if($request->request_type=='updateUnit'){
            return (new MaterialUnitController)->update($request);
        }
        if($request->request_type=='addModifierTemplate'){
            return (new ModifierTemplateController)->store($request);
        }
        if($request->request_type=='deleteModifierTemplates'){
            return (new ModifierTemplateController)->destroyTemplates();
        }
        if($request->request_type=='deleteModifiers'){
            return (new ModifierTemplateController)->destroyModifiers();
        }
        if($request->request_type=='GetOrders'){
            return (new OrderController)->index($request);
        }
        if($request->request_type=='GetMaterial'){
            return (new MaterialController)->index($request);
        }
        if($request->request_type=='getAllLangs'){
            return Lang::get('lang_code');
        }
        if($request->request_type=='clearCache'){
             return $this->clear_cache();
        }
    }
    public function clear_cache()
    {
       try{
         Cache::store('tenant')->flush();
         return 'Cache Successfully Cleared';

       }catch(\Exception $e){
        return  response()->json([
            'message'=>'Something Went Wrong',
            'errors'=>$e->getMessage()
        ]);
       }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
