<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialUnit;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ModifierTemplate;
use Illuminate\Support\Facades\File;
use App\Http\Requests\MaterialRequest;
use Storage;
use DB;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $materials = Material::with('modifierTemplate')->get();
       return view('backend.materials.index',['materials'=>$materials]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $templates  = ModifierTemplate::all();
        return view('backend.materials.create',
         [
          'categories'=>$categories,
          'templates'=> $templates
         ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialRequest $request)
    {
        try
        {
            $validated = $request->validated();

            DB::beginTransaction();

            $material = new Material;

            $material->material_name = $request->material_name;
            $material->material_description = $request->description;
            $material->modifiertemplate_id  = $request->modifiertemplate_id;
            $material->category_id = $request->categoryparent;
            $List_units = $request->List_units;

            if($request->hasfile('materialimg'))
            {
                $file= $request->file('materialimg');
                if ($file->isValid()) {
                   $file_name = uniqid().$file->getClientOriginalName();
                   $path= $file->storeas('/mats',$file_name,[
                     'disk'=>'tenant'
                   ]);
                   $material->materialimg = $file_name;
                }
            }
            $material->save();

            foreach ($List_units as $key) {

                $unit = new MaterialUnit();

                $unit->material_unit_name = array_slice($key, 0, -1);

                $unit->price =$key['price'];

                $unit->material_id = $material->id;

                $unit->save();

            }
            DB::commit();

           return redirect()->route('material.index')->with('success', __('Material Successfully Inserted'));

        } catch (\Exception $e) {
           DB::rollBack();
           return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
       $categories=Category::all();
       $templates = ModifierTemplate::all();
       return view('backend.materials.edit',[
        'material'=> $material,
        'categories'=> $categories,
        'templates'=> $templates
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(MaterialRequest $request, Material $material)
    {
        try
        {
            $validated = $request->validated();

            $material->material_name = $request->material_name;
            $material->material_description = $request->description;
            $material->modifiertemplate_id  = $request->modifiertemplate_id;
            $material->category_id = $request->categoryparent;

            if($request->hasfile('materialimg'))
            {
                $pre_file  = Storage::disk('tenant')->path('mats/'.$material->materialimg);
                if(File::exists($pre_file)){
                    File::delete($pre_file);
                }
                $file= $request->file('materialimg');
                if ($file->isValid()) {
                   $file_name=uniqid().$file->getClientOriginalName();
                   $path= $file->storeas('/mats',$file_name,[
                     'disk'=>'tenant'
                   ]);
                   $material->materialimg = $file_name;
                }
            }
            $material->save();

           return redirect()->route('material.index')->with('success', __('Material Successfully Updated'));

        } catch (\Exception $e) {
           return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        try
        {
            $material->delete();
            $file  = Storage::disk('tenant')->path('mats/'.$material->materialimg);

            if (File::exists($file)) {
                File::delete($file);
            }
            return  response()->json([
                'success' => __('Material Successfully Deleted'),
                'url'=>route('material.index')
            ]);

         } catch (\Exception $e) {
            return  response()->json([
                'error' => __('This Material Cannot Be Deleted'),
                'message'=>$e->getMessage()
            ]);
        }
    }
    public function delete_all(Request $request){
        try
        {
            DB::beginTransaction();
            foreach ($request->delete as $value) {
                $material = Material::findorfail($value);
                $material->delete();
                $file  = Storage::disk('tenant')->path('mats/'.$material->materialimg);
                if (File::exists($file)) {
                    File::delete($file);
                }
            }
            DB::commit();

             return response()->json(
                [
                    'success'=>__('Materials Successfully Deleted'),
                    'url'=> route('material.index')

                ]);

        } catch (\Exception $e) {
            DB::rollback();
            return  response()->json([
                'error' => __('Some Of Materials Cannot Be Deleted'),
                'message'=>$e->getMessage()

            ]);
        }
    }
}
