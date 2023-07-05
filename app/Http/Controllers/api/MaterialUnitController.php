<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MaterialUnit;
use App;
class MaterialUnitController extends Controller
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
    public function update($request)
    {
        try {
            $validated = $request->validated();
            $unit_name=[];
            $unit = $request->unit;
            $material=Material::where('reference_id',$unit['material_id'])->first();
            $materialUnit= MaterialUnit::where('reference_id',$unit['material_unit_id'])->first();
            $materialUnit->reference_id = $unit['reference_id'];
            $materialUnit->material_id=(isset($unit['material_id']) && $material!==null)?$material->id:null;

            foreach ($unit['unit_lang'] as $lang_obj) {
                foreach (App::make('languages') as $key => $lang) {
                    if ($key==$lang_obj['lang_id']) {
                        $unit_name[$key]=$lang_obj['material_unit_lang_name'];
                    }
                }
            }
            $materialUnit->material_unit_name = $unit_name;
            $materialUnit->save();

            return  response()->json([
                'success'=>__('MaterialUnit Successfully Updated'),
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
    public function destroy($id)
    {
        //
    }
}
