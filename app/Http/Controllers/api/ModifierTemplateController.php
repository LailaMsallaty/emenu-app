<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModifierTemplate;
use App\Models\Modifier;
use DB;
use App;
class ModifierTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store($request)
    {
        try{
            $validated = $request->validated();
            DB::beginTransaction();
            foreach ($request->ModifierTemplate as $template) {
                $templateModifier = new ModifierTemplate();
                $templateModifier->modifiertemplate_name = $template['modifiertemplate_name'];
                $templateModifier->reference_id = $template['reference_id'];
                $templateModifier->save();

                foreach ($template['modifier'] as $modifier_obj) {
                    $modifier_name=[];
                    $modifier = new Modifier();
                    $modifier->modifier_price = $modifier_obj['modifier_price'];
                    $modifier->reference_id= $modifier_obj['reference_id'];
                    $modifier->modifiertemplate_id = $templateModifier->id;
                    foreach ($modifier_obj['modifier_lang'] as $lang_obj) {
                        foreach (App::make('languages') as $key => $lang) {
                            if ($key==$lang_obj['lang_id']) {
                                $modifier_name[$key]=$lang_obj['modifier_lang_name'];
                            }
                        }
                }
                $modifier->modifier_name= $modifier_name;
                $modifier->save();
               }
            }
            DB::commit();
            return  response()->json([
                'success'=>__('Modifiers Successfully Inserted'),
            ]);

        }catch(\Exception $e){
            DB::rollBack();
            return  response()->json([
                'message'=>'Something Went Wrong',
                'errors'=>$e->getMessage()
            ]);
        }
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
    public function destroyTemplates()
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            ModifierTemplate::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return  response()->json([
                'success'=>__('ModifierTemplates Successfully Deleted'),
            ]);
        }catch (\Exception $e) {
            return  response()->json([
                'message'=>'Something Went Wrong',
                'errors'=>$e->getMessage()
            ]);
        }
    }
    public function destroyModifiers()
    {
        try {
            Modifier::truncate();
            return  response()->json([
                'success'=>__('Modifiers Successfully Deleted'),
            ]);
        }catch (\Exception $e) {
            return  response()->json([
                'message'=>'Something Went Wrong',
                'errors'=>$e->getMessage()
            ]);
        }
    }
}
