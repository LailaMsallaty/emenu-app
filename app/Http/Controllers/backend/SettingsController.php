<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\TblOption;
use App\Models\Lang;
use Illuminate\Http\Request;
use App\Http\Requests\LangRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Artisan;
use DB;
class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $option= new TblOption();
        return view('backend.settings.general.index',['option'=>$option]);
    }

    public function performance()
    {
        $option= new TblOption();
        return view('backend.settings.performance',['option'=>$option]);
    }

    public function themeLogo(){

        $option= new TblOption();
        return view('backend.settings.themeLogo',['option'=>$option]);
    }


    public function generateTables(){

        $option= new TblOption();
        return view('backend.settings.generateTables',['option'=>$option]);
    }


    public function GenerateTablesCodes($codes){

        try{

                $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https:/':'http:/';
                $url=explode('admin', parse_url($_SERVER['REQUEST_URI'])["path"])[0];
                $newarr=array();
                $tbarr = explode(',',$codes);
                $port =($_SERVER['SERVER_PORT']) ? ':'.$_SERVER['SERVER_PORT'] :'';
                foreach ($tbarr as $key => $tb)
                {
                    $newarr[]=$protocol.$_SERVER['SERVER_NAME'].$port.$url.'?tbcode='.base64_encode($tb);
                }
                $tables='';
                foreach ($newarr as $key => $tb)
                {
                    $tables.= $tb."\n";
                }
                return $tables;

        }catch(\Exception $e){
        return  response()->json([
                    'error' => __('Something Went Wrong'),
                    'message'=>$e->getMessage()
                ]);
        }
}
    public function storeGenerateTables(Request $request)
    {
        try{

            $codes =array_map('trim',explode("\n", $request->tblcodes));
            $tables = implode(",",$codes);
            $this->update_option('tblcodes',$tables);

            return redirect()->back()->with('success', __('Table Codes Successfully Updated'));

        }catch(\Exception $e)
        {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function upload_files(Request $request){

        try{

            if($request->hasfile('logo_img'))
            {
                $file= $request->file('logo_img');
                if ($file->isValid()) {
                    $path= $file->storeas('/headers',$file->getClientOriginalName(),[
                        'disk'=>'public'
                    ]);
                    $name = $file->getClientOriginalName();
                    $this->update_option('logo_img',$name,true);

                }
                return redirect()->back()->with('success', __('Logo Image Successfully Uploaded'));

           }
           else if($request->hasfile('banner_img'))
           {
                $file= $request->file('banner_img');
                if ($file->isValid()) {
                    $path= $file->storeas('/headers',$file->getClientOriginalName(),[
                        'disk'=>'public'
                    ]);
                    $name = $file->getClientOriginalName();
                    $this->update_option('banner_img',$name,true);
                }
                return redirect()->back()->with('success', __('Banner Image Successfully Uploaded'));
            }
            else if (isset($request->delete_banner)){
                $this->empty_option_value('banner_img',true);
                return redirect()->back()->with('success', __('Banner Image Successfully Deleted'));
            }
            else if (isset($request->delete_logo)){
                $this->empty_option_value('logo_img',true);
                return redirect()->back()->with('success', __('Logo Image Successfully Deleted'));
            }
            else{
                return redirect()->back();
            }

        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function Languages(Lang $Lang)
    {
        $langs =Lang::All();
        return view('backend.settings.languages.index',[
            'lang' => $Lang,
            'langs'=>$langs
        ]);
    }
    public function editLang(Lang $Lang)
    {
        return view('backend.settings.languages.edit',[
            'lang' => $Lang,
        ]);
    }
    public function updateLang(LangRequest $request,Lang $Lang)
    {
        try{
            $validated = $request->validated();
            $Lang->lang_code = $request->lang_code;
            $Lang->lang_name = $request->lang_name;
            $Lang->isrtl = isset($request->is_rtl)? 1:0;
            $Lang->save();

            return redirect()->route('languages.index')->with('success', __('Language Successfully Updated'));

        } catch (\Exception $e) {
           return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function storeLanguages(LangRequest $request){
        try{
            $validated = $request->validated();
            $List_langs = $request->List_langs;

           // dd($List_langs);
            DB::beginTransaction();

            foreach ($List_langs as $key) {
                $lang= new Lang();
                $lang->lang_code=$key['lang_code'];
                $lang->lang_name=$key['lang_name'];
                $lang->isrtl=isset($key['is_rtl']) ? 1: 0;
                $lang->save();
            }
            DB::commit();
            return redirect()->back()->with('success', __('Language Successfully Inserted'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
         }

    }

    public function delete_all_langs(Request $request){
        try
        {
            DB::beginTransaction();
            foreach ($request->delete as $value) {
                $lang = Lang::findorfail($value);
                $lang->delete();
            }
            DB::commit();

             return response()->json(
                [
                    'success'=>__('Languages Successfully Deleted'),
                    'url' =>route('languages.index')
                ]);

        } catch (\Exception $e) {
            DB::rollback();
            return  response()->json([
                'error' => __('Some Of Languages Cannot Be Deleted'),
                'message'=>$e->getMessage()

            ]);
        }
    }
    public function update_option($opvar,$opval,$img_file=null){
        try{
            $obj = TblOption::where('opvar' , '=', $opvar)->first();
            if ($obj) {
                if ($img_file) {
                    $pre_file = public_path("storage/headers/{$obj->opval}");
                    if(File::exists($pre_file)){
                        File::delete($pre_file);
                    }
                }
                $obj->opval = $opval;
                $obj->save();
            }else{
                $option= new TblOption();
                $option->opvar = $opvar;
                $option->opval = $opval;
                $option->save();
            }

        }catch(\Exception $e){

           return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }
    }

    public function empty_option_value($opvar,$img_file=null){
        try{
            $obj = TblOption::where('opvar' , '=', $opvar)->first();
            if ($obj) {
                if ($img_file) {
                    $pre_file = public_path("storage/headers/{$obj->opval}");
                    if(File::exists($pre_file)){
                        File::delete($pre_file);
                    }
                }
                $obj->opval='';
                $obj->save();
            }

        }catch(\Exception $e){

           return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }
    }
    public function storePerformance(Request $request)
    {
        try{

        // performance
        if(isset($request->performance_btn)){
            // maintenancemode
            $maintenancemodeval = isset($request->maintenancemode) ? true : false;
            if($maintenancemodeval){
                $token =config()->get('app.maintanance_token');
                Artisan::call('down',
                [
                    "--secret" => $token,
                    "--render"=>"maintanance"
                ]);
            }
            else{
                Artisan::call('up');
            }
            $this->update_option('maintenancemode',$maintenancemodeval);

        }

        return redirect()->back()->with('success', __('Option Successfully Updated'));

     }  catch (\Exception $e) {

        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
     }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            // site settings
            if (isset($request->sitename)) {
                $this->update_option('sitename',$request->sitename);
            }
            if (isset($request->currencysymbol)) {
                $this->update_option('currencysymbol',$request->currencysymbol);

            }
            // order settings
            if (isset($request->ordersttingbtn)) {

                // activateorder
                $activateorderval = isset($request->activateorder) ? 1 : 0;
                $this->update_option('activateorder',$activateorderval);

                // activatetables
                $activatetablesval = isset($request->activatetables) ? 1 : 0;
                $this->update_option('activatetables',$activatetablesval);

                // enforcetablespreselection
                $enforcetablespreselectionval = isset($request->enforcetablespreselection) ? 1 : 0;
                $this->update_option('enforcetablespreselection',$enforcetablespreselectionval);

            }
            // delivery settings
            if (isset($request->deliverysettingbtn)) {

                 // activatedelivery
                 $activatedeliveryval = isset($request->activatedelivery) ? 1 : 0;
                 $this->update_option('activatedelivery',$activatedeliveryval);

                 // deliveryPrice
                 $this->update_option('deliveryPrice',$request->deliveryPrice);

            }
            // location settings
            if (isset($request->locationsettingsbtn)) {

                // activate location
                $activatelocationval = isset($request->activatelocation) ? 1 : 0;
                $this->update_option('activatelocation',$activatelocationval);

                // activate notification
                $activatenotificationval = isset($request->activatenotification) ? 1 : 0;
                $this->update_option('activatenotification',$activatenotificationval);

                // Latitude
                $this->update_option('latitude',$request->latitude);

                // Longitude
                $this->update_option('longitude',$request->longitude);

            }
            // menu settings
            if (isset($request->menusettingbtn)) {

                // activate all menu
                $activatemenuval = isset($request->activatemenu) ? 1 : 0;
                $this->update_option('activatemenu',$activatemenuval);

                // activate images
                $activateimagesval = isset($request->activateimages) ? 1 : 0;
                $this->update_option('activateimages',$activateimagesval);

            }

         return redirect()->back()->with('success', __('Options Successfully Updated'));

        }  catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
         }

    }

    public function clear_cache()
    {
       try{
        Cache::store('tenant')->flush();
        return redirect()->back()->with('success', __('Cache Successfully Cleared'));

       }catch(\Exception $e){
          return redirect()->back()->withErrors(['error' => $e->getMessage()]);
       }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TblOption  $tblOption
     * @return \Illuminate\Http\Response
     */
    public function show(TblOption $tblOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TblOption  $tblOption
     * @return \Illuminate\Http\Response
     */
    public function edit(TblOption $tblOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TblOption  $tblOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TblOption $tblOption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TblOption  $tblOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(TblOption $tblOption)
    {
        //
    }
}
