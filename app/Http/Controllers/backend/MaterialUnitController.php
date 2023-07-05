<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\MaterialUnit;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Http\Requests\MaterialUnitRequest;
use App\Http\Requests\StoreMaterialUnitRequest;
use DB;
class MaterialUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Material $material)
    {
        $materialUnits = $material->units;
        return view('backend.materialunits.index',[
            'units'=> $materialUnits
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Material $material)
    {
        return view('backend.materialunits.create',[
            'material' => $material
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMaterialUnitRequest $request)
    {
        try
        {
            $validated = $request->validated();

            $List_units = $request->List_units;

            DB::beginTransaction();

            foreach ($List_units as $key) {

                $unit = new MaterialUnit();

                $unit->material_unit_name = array_slice($key, 0, -1);

                $unit->price =$key['price'];

                $unit->material_id = $request->material_id;

                $unit->save();

            }
            DB::commit();

           return redirect()->route('material.units',['material'=>$request->material_id])->with('success', __('Material Units Successfully Inserted'));

        } catch (\Exception $e) {
           DB::rollBack();
           return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaterialUnit  $materialUnit
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialUnit $materialUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaterialUnit  $materialUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialUnit $materialunit)
    {
        $materials = Material::all();
        return view('backend.materialunits.edit',[
            'unit'=>  $materialunit,
            'materials'=> $materials
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaterialUnit  $materialUnit
     * @return \Illuminate\Http\Response
     */
    public function update(MaterialUnitRequest $request, MaterialUnit $materialunit)
    {
        try{
            $validated = $request->validated();
            $materialunit->material_unit_name = $request->material_unit_name;
            $materialunit->price = $request->price;
            $materialunit->material_id = $request->material_id;
            $materialunit->save();

            return redirect()->route('material.units',['material'=>$request->material_id])->with('success', __('Material Unit Successfully Updated'));

        } catch (\Exception $e) {
           return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaterialUnit  $materialUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,MaterialUnit $materialunit)
    {
        try
        {
            $materialunit->delete();

            return  response()->json([
                'success' => __('Material Unit Successfully Deleted'),
                'url' =>route('material.units',['material'=>$request->parent_id])
            ]);

         } catch (\Exception $e) {
            return  response()->json([
                'error' => __('This MaterialUnit Cannot Be Deleted'),
                'message'=>$e->getMessage()
            ]);
        }
    }
    public function delete_all(Request $request){
        try
        {
            DB::beginTransaction();
            foreach ($request->delete as $value) {
                $materialunit = MaterialUnit::findorfail($value);
                $materialunit->delete();
            }
            DB::commit();

             return response()->json(
                [
                    'success'=>__('Material Units Successfully Deleted'),
                    'url' =>route('material.units',['material'=>$request->parent_id])
                ]);

        } catch (\Exception $e) {
            DB::rollback();
            return  response()->json([
                'error' => __('Some Of Material Units Cannot Be Deleted'),
                'message'=>$e->getMessage()

            ]);
        }
    }
}
