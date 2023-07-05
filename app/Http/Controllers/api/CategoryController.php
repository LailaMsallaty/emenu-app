<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ModifierTemplate;
use Illuminate\Support\Facades\File;
use App;
use Storage;
use DB;
class CategoryController extends Controller
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

            foreach ($request->category as $cat) {
                $category_name=[];
                $category_description=[];
                $category = new Category();
                $categry_father=Category::where('reference_id',$cat['category_father_id'])->first();
                $modifier_template= ModifierTemplate::where('reference_id',$cat['modifiertemplate_id'])->first();
                $category->modifiertemplate_id = (isset($cat['modifiertemplate_id']) && $modifier_template!==null)?$modifier_template->id:null;
                $category->reference_id = (isset($cat['reference_id']))?$cat['reference_id'] : null;
                $category->category_father_id=(isset($cat['category_father_id']) && $categry_father!==null)?$categry_father->id:null;
                if (isset($cat['categoryimg'])) {
                        $base64_str = preg_replace('#^data:image/[^;]+;base64,#','', $cat['categoryimg']);
                        $image = base64_decode($base64_str);
                        $fileName = uniqid().'.jpg';
                        Storage::disk('tenant')->put('cats/'.$fileName, $image);
                        $category->categoryimg = $fileName;
                }
                foreach ($cat['category_lang'] as $lang_obj) {
                    foreach (App::make('languages') as $key => $lang) {
                        if ($key==$lang_obj['lang_id']) {
                            $category_name[$key]=$lang_obj['category_lang_name'];
                            $category_description[$key]=$lang_obj['category_lang_description'];
                        }
                    }
                }
                $category->category_name = $category_name;
                $category->category_description = $category_description;
                $category->save();
            }
            DB::commit();
            return  response()->json([
                'success'=>'Categories Successfully Inserted',
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
            $category_name=[];
            $category_description=[];
            $cat = $request->category;
            $category= Category::where('reference_id',$cat['category_id'])->first();
            $categry_father=Category::where('reference_id',$cat['category_father_id'])->first();
            $modifier_template= ModifierTemplate::where('reference_id',$cat['modifiertemplate_id'])->first();

            $category->modifiertemplate_id = (isset($cat['modifiertemplate_id']) && $modifier_template!==null)?$modifier_template->id:null;
            $category->reference_id = (isset($cat['reference_id']))?$cat['reference_id'] : null;
            $category->category_father_id=(isset($cat['category_father_id']) &&  $categry_father!==null)? $categry_father->id:null;

            $pre_file  = Storage::disk('tenant')->path('cats/'.$category->categoryimg);
            if(File::exists($pre_file)){
                File::delete($pre_file);
            }
            $fileName ="";
            if (isset($cat['categoryimg'])) {
                    $base64_str = preg_replace('#^data:image/[^;]+;base64,#','', $cat['categoryimg']);
                    $image = base64_decode($base64_str);
                    $fileName = uniqid().'.jpg';
                    Storage::disk('tenant')->put('cats/'.$fileName, $image);
            }
            $category->categoryimg = $fileName;
            foreach ($cat['category_lang'] as $lang_obj) {
                foreach (App::make('languages') as $key => $lang) {
                    if ($key==$lang_obj['lang_id']) {
                        $category_name[$key]=$lang_obj['category_lang_name'];
                        $category_description[$key]=$lang_obj['category_lang_description'];
                    }
                }
            }
            $category->category_name = $category_name;
            $category->category_description = $category_description;
            $category->save();

            return  response()->json([
                'success'=>__('Category Successfully Updated'),
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
            $category= Category::where('reference_id',$request->reference_id)->first();
            $img=$category->categoryimg;
            $category->delete();
            $pre_file  = Storage::disk('tenant')->path('cats/'.$img);
            if(File::exists($pre_file)){
                File::delete($pre_file);
            }
            return  response()->json([
                'success'=>__('Category Successfully Deleted'),
            ]);
        }catch (\Exception $e) {
            return  response()->json([
                'message'=>'Something Went Wrong',
                'errors'=>$e->getMessage()
            ]);        }
    }
}
