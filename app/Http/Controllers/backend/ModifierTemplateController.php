<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ModifierTemplate;
use Illuminate\Http\Request;
use App\Http\Requests\ModifierTemplateRequest;
use App\Models\Modifier;
use DB;

class ModifierTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = ModifierTemplate::all();
        return view('backend.modifierTemplates.index',['templates'=>$templates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.modifierTemplates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModifierTemplateRequest $request)
    {
        try
        {
            $validated = $request->validated();

            DB::beginTransaction();

            $modifierTemplate = new ModifierTemplate();

            $modifierTemplate->modifiertemplate_name = $request->templateName;

            $modifierTemplate->save();

            $List_modifiers = $request->List_modifiers;

            foreach ($List_modifiers as $key) {

                $modifier = new Modifier();

                $modifier->modifier_name = array_slice($key, 0, -1);

                $modifier->modifier_price=$key['price'];

                $modifier->modifiertemplate_id = $modifierTemplate->id;

                $modifier->save();

            }
            DB::commit();

           return redirect()->route('modifiertemplates.index')->with('success', __('Modifier Template Successfully Inserted'));

        } catch (\Exception $e) {
           DB::rollBack();
           return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModifierTemplate  $modifiertemplate
     * @return \Illuminate\Http\Response
     */
    public function show(ModifierTemplate $modifiertemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModifierTemplate  $modifiertemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(ModifierTemplate $modifiertemplate)
    {
        return view('backend.modifierTemplates.edit',['template'=>$modifiertemplate]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ModifierTemplate  $modifiertemplate
     * @return \Illuminate\Http\Response
     */
    public function update(ModifierTemplateRequest $request, ModifierTemplate $modifiertemplate)
    {
        try {

            $validated = $request->validated();
            $modifiertemplate->modifiertemplate_name = $request->templateName;
            $modifiertemplate->save();

            return redirect()->route('modifiertemplates.index')->with('success', __('Modifier Template Successfully Updated'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModifierTemplate  $modifiertemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $Request,ModifierTemplate $modifiertemplate)
    {
        try
        {
            $modifiertemplate->delete();

            return  response()->json([
                'success' => __('Modifier Template Successfully Deleted'),
                'url' =>route('modifiertemplates.index')
            ]);

         } catch (\Exception $e) {
            return  response()->json([
                'error' => __('This Modifier Template Cannot Be Deleted'),
                'message'=>$e->getMessage()
            ]);
        }
    }
    public function delete_all(Request $request){
        try
        {
            DB::beginTransaction();
            foreach ($request->delete as $value) {
                $modifiertemplate = ModifierTemplate::findorfail($value);
                $modifiertemplate->delete();
            }
            DB::commit();

             return response()->json(
                [
                    'success'=>__('Modifier Templates Successfully Deleted'),
                    'url' =>route('modifiertemplates.index')
                ]);

        } catch (\Exception $e) {
            DB::rollback();
            return  response()->json([
                'error' => __('Some Of Modifier Templates Cannot Be Deleted'),
                'message'=>$e->getMessage()

            ]);
        }
    }
}
