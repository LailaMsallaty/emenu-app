<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Modifier;
use Illuminate\Http\Request;
use App\Models\ModifierTemplate;
use App\Http\Requests\ModifierRequest;
use DB;
class ModifierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ModifierTemplate $modifiertemplate)
    {
        $modifiers = $modifiertemplate->modifiers;
        return view('backend.modifiers.index',[
            'modifiers'=> $modifiers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ModifierTemplate $modifiertemplate)
    {
        return view('backend.modifiers.create',['template'=>$modifiertemplate]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModifierRequest $request)
    {
        try
        {
            DB::beginTransaction();

            $validated = $request->validated();

            $List_modifiers = $request->List_modifiers;

            foreach ($List_modifiers as $key) {

                $modifier = new Modifier();

                $modifier->modifier_name = array_slice($key, 0, -1);

                $modifier->modifier_price=$key['price'];

                $modifier->modifiertemplate_id = $request->template_id;

                $modifier->save();

            }
            DB::commit();

           return redirect()->route('modifiertemplate.modifiers',['modifiertemplate'=>$request->template_id])->with('success', __('Modifier Successfully Inserted'));

        } catch (\Exception $e) {
           DB::rollBack();
           return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modifier  $modifier
     * @return \Illuminate\Http\Response
     */
    public function show(Modifier $modifier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modifier  $modifier
     * @return \Illuminate\Http\Response
     */
    public function edit(Modifier $modifier)
    {
        $templates = ModifierTemplate::all();
        return view('backend.modifiers.edit',[
            'modifier'=>  $modifier,
            'templates'=> $templates
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modifier  $modifier
     * @return \Illuminate\Http\Response
     */
    public function update(ModifierRequest $request, Modifier $modifier)
    {
            try{
                $validated = $request->validated();
                $modifier->modifier_name = $request->modifier_name;
                $modifier->modifier_price = $request->price;
                $modifier->save();

                return redirect()->route('modifiertemplate.modifiers',['modifiertemplate'=>$request->template_id])->with('success', __('Material Unit Successfully Updated'));

            } catch (\Exception $e) {
               return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modifier  $modifier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Modifier $modifier)
    {
        try
        {
            $modifier->delete();

            return  response()->json([
                'success' => __('Modifier Successfully Deleted'),
                'url' => route('modifiertemplate.modifiers',['modifiertemplate'=>$request->parent_id])
            ]);

         } catch (\Exception $e) {
            return  response()->json([
                'error' => __('This Modifier Cannot Be Deleted'),
                'message'=>$e->getMessage()
            ]);
        }
    }
    public function delete_all(Request $request){
        try
        {
            DB::beginTransaction();
            foreach ($request->delete as $value) {
                $modifier = Modifier::findorfail($value);
                $modifier->delete();
            }
            DB::commit();

             return response()->json(
                [
                    'success'=>__('Modifier Successfully Deleted'),
                    'url' => route('modifiertemplate.modifiers',['modifiertemplate'=>$request->parent_id])
                ]);

        } catch (\Exception $e) {
            DB::rollback();
            return  response()->json([
                'error' => __('Some Of Modifiers Cannot Be Deleted'),
                'message'=>$e->getMessage()

            ]);
        }
    }
}
