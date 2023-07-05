<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Material;
use App\Models\MaterialUnit;
use App\Models\ModifierTemplate;
use Illuminate\Support\Facades\File;
use  DB;
use Storage;
use App;
class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($request)
    {
        try{
            $material_id = "";
            $material_obj=Material::where('reference_id',$request->Material_reference_id)->first();
            if ($material_obj) {
                $material_id = (string)$material_obj->id;
            }
            return $material_id;

        }catch (\Exception $e) {
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
    public function store($request)
    {
        try{
            $validated = $request->validated();
            DB::beginTransaction();
            foreach ($request->material as $mat) {
                $material_name=[];
                $material_description=[];
                $material = new Material();
                $categry_father=Category::where('reference_id',$mat['category_id'])->first();
                $modifier_template= ModifierTemplate::where('reference_id',$mat['modifiertemplate_id'])->first();

                $material->category_id =(isset($mat['category_id']) && $categry_father!==null)?$categry_father->id:null;
                $material->modifiertemplate_id  =(isset($mat['modifiertemplate_id']) && $modifier_template!==null)?$modifier_template->id:null;
                $material->reference_id = (isset($mat['reference_id']))?$mat['reference_id'] : null;
                if (isset($mat['materialimg'])) {
                    $base64_str = preg_replace('#^data:image/[^;]+;base64,#','', $mat['materialimg']);
                    $image = base64_decode($base64_str);
                    $fileName = uniqid().'.jpg';
                    Storage::disk('tenant')->put('mats/'.$fileName, $image);
                    $material->materialimg = $fileName;
               }
               foreach ($mat['material_lang'] as $lang_obj) {
                foreach (App::make('languages') as $key => $lang) {
                    if ($key==$lang_obj['lang_id']) {
                        $material_name[$key]=$lang_obj['material_lang_name'];
                        $material_description[$key]=$lang_obj['material_lang_description'];
                    }
                }
                $material->material_name = $material_name;
                $material->material_description = $material_description;
                $material->save();
               }
               foreach ($mat['material_unit'] as $unit_obj) {
                 $material_unit_name=[];
                 $materialUnit = new MaterialUnit();
                 $materialUnit->material_id = $material->id;
                 $materialUnit->price = $unit_obj['price'];
                 $materialUnit->reference_id=$unit_obj['reference_id'];
                 foreach ($unit_obj['material_unit_lang'] as $lang_obj) {
                    foreach (App::make('languages') as $key => $lang) {
                        if ($key==$lang_obj['lang_id']) {
                            $material_unit_name[$key]=$lang_obj['material_unit_lang_name'];
                        }
                    }
                }
                $materialUnit->material_unit_name= $material_unit_name;
                $materialUnit->save();
               }
            }
            DB::commit();
            return  response()->json([
                'success'=>__('Materials Successfully Inserted'),
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
    public function update($request)
    {
        try {
            $validated = $request->validated();
            $material_name=[];
            $material_description=[];
            $mat = $request->material;

            $categry_father=Category::where('reference_id',$mat['category_id'])->first();
            $modifier_template= ModifierTemplate::where('reference_id',$mat['modifiertemplate_id'])->first();

            $material= Material::where('reference_id',$mat['material_id'])->first();
            $material->modifiertemplate_id = (isset($mat['modifiertemplate_id']) && $modifier_template!==null)?$modifier_template->id:null;
            $material->reference_id = (isset($mat['reference_id']))?$mat['reference_id'] : null;
            $material->category_id=(isset($mat['category_id']) && $categry_father!==null)?$categry_father->id:null;

            $pre_file  = Storage::disk('tenant')->path('mats/'.$material->materialimg);
            if(File::exists($pre_file)){
                File::delete($pre_file);
            }
            $fileName ="";
            if (isset($mat['materialimg'])) {
                    $base64_str = preg_replace('#^data:image/[^;]+;base64,#','', $mat['materialimg']);
                    $image = base64_decode($base64_str);
                    $fileName = uniqid().'.jpg';
                    Storage::disk('tenant')->put('mats/'.$fileName, $image);
            }
            $material->materialimg = $fileName;
            foreach ($mat['material_lang'] as $lang_obj) {
                foreach (App::make('languages') as $key => $lang) {
                    if ($key==$lang_obj['lang_id']) {
                        $material_name[$key]=$lang_obj['material_lang_name'];
                        $material_description[$key]=$lang_obj['material_lang_description'];
                    }
                }
            }
            $material->material_name = $material_name;
            $material->material_description = $material_description;
            $material->save();

            return  response()->json([
                'success'=>__('Material Successfully Updated'),
            ]);

        }catch (\Exception $e) {
               return  response()->json([
                'message'=>'Something Went Wrong',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($request)
    {
        try {
            $validated = $request->validated();
            $material= Material::where('reference_id',$request->reference_id)->first();
            $img=$material->materialimg;
            $material->delete();
            $pre_file  = Storage::disk('tenant')->path('mats/'.$img);
            if(File::exists($pre_file)){
                File::delete($pre_file);
            }
            return  response()->json([
                'success'=>__('Material Successfully Deleted'),
            ]);
        }catch (\Exception $e) {
            return  response()->json([
                'message'=>'Something Went Wrong',
                'errors'=>$e->getMessage()
            ]);
        }
    }
}
