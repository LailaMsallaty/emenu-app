<?php

namespace App\Http\Controllers\frontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TblOption;
use App\Models\Category;
use App\Models\Modifier;
use App\Models\Material;
use App\Models\Order;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;
use Session;
use stdClass;
use App;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $page=Session::get('currentpage');

        if ($request->data=='tablecode') {

           return response()->json($request->session()->get('tablecode')?$request->session()->get('tablecode'):'');
        }

        if ($request->data=='cats') {

            return $this->getCategoriesJson();
        }

        if ($request->data=='menu') {

            return $this->getMaterialsJson();
        }

        if ($request->data=='delivery') {
            $d = new stdClass();
            $d->price = 4;
            return json_encode($d);
        }

        if ($request->data=='currencysymbol') {
            $arr =[App::make('option')->getOptionVal('currencysymbol')];
            return json_encode($arr);
        }

        if ($request->data=='availabletablecode') {

            $table_codes = App::make('option')->where('opvar','tblcodes')->first()->toArray();
            return explode(',',$table_codes['opval']);
        }

        if ($request->data=='options') {

            if (Cache::store('tenant')->has('optionsJson')) {
                $optionsJson = Cache::store('tenant')->get('optionsJson');
            }
            else{
                $options=TblOption::all();
                $plucked = $options->pluck('opval','opvar');
                $plucked->all();
                $optionsJson=response()->json($plucked);
                Cache::store('tenant')->put('optionsJson', $optionsJson);
            }
            return  $optionsJson;

        }

        $categories=null;
        if ($page=='menu_list') {
            $category=($request->category) ? $request->category :'0';
            $categories= $this->getCategories($category);
        }
        $page_obj=null;
        if ($page=='cms') {
           if ($request->id) {
            if (Cache::store('tenant')->has('page_obj')) {
                $page_obj = Cache::store('tenant')->get('page_obj');
            }
            else{
                $page_obj=Page::findorfail($request->id);
                Cache::store('tenant')->put('page_obj', $page_obj);
            }
           }
        }
        return view('frontend.pages.'.$page,['categories'=>$categories,'page_obj'=>$page_obj]);
    }
    public function getCategories($category=0)
    {
        try {
            if (Cache::store('tenant')->has('categories')) {
                $categories = Cache::store('tenant')->get('categories');
            }
            else{
                if ($category=='0') {
                    $categories = Category::with('materials.units')->orderBy('category_index','Asc')->get();
                }else{
                    $categories = Category::with('materials.units')->where('id',$category)->orderBy('category_index','Asc')->get();
                }
                Cache::store('tenant')->put('categories', $categories);
            }
            return $categories;

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function getCategoriesJson()
    {
        try {
            if (Cache::store('tenant')->has('categoriesJson')) {
                $categoriesJson = Cache::store('tenant')->get('categoriesJson');
            }
            else{
                $cats = $this->getCategories();
                $catobj=array();
                foreach ($cats as $row) {
                    $obj=new stdClass();
                    $obj->id=(int)$row->id;
                    $obj->name=$row->getTranslation('category_name',App::getLocale());
                    $obj->additions=array();
                    if ($row->modifiertemplate_id !==null)
                    {
                        $mods = Modifier::where('modifiertemplate_id',$row->modifiertemplate_id)->get();
                        foreach ($mods as $mod) {
                            $m=new stdClass();
                            $m->id = (int)$mod->id;
                            $m->name = $mod->getTranslation('modifier_name',App::getLocale());
                            $m->price = floatval($mod->modifier_price);
                            $obj->additions[] = $m;
                        }
                    }
                    $catobj[]=$obj;
                }
                $categoriesJson = json_encode($catobj);
                Cache::store('tenant')->put('categoriesJson', $categoriesJson);
           }
           return $categoriesJson;

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function getMaterialsJson()
    {
        try {
            if (Cache::store('tenant')->has('materialsJson')) {
                $materialsJson = Cache::store('tenant')->get('materialsJson');
            }
            else{
                $mats = Material::all();
                $matobj=array();
                foreach ($mats as $row) {
                    $obj=new stdClass();
                    $obj->id=(int)$row->id;
                    $obj->categoryId=$row->category_id;
                    $obj->referenceId=(int)$row->referance_id;
                    $obj->name=$row->getTranslation('material_name',App::getLocale());

                    $obj->price=floatval($row->first_unit->price);
                    $obj->ingredients=array();
                    $obj->ingredients[]=$row->getTranslation('material_description',App::getLocale());

                    $obj->additions=array();
                    $obj->itemadditions=array();
                    $obj->sizes=array();
                    $sizes = $row->units;

                    $x=0;
                    foreach ($sizes as $size) {
                        $s=new stdClass();
                        $s->id = (int)$size->id;
                        $s->name = $size->getTranslation('material_unit_name',App::getLocale());

                        $s->price = floatval($size->price);
                        $s->active = $x==0;
                        $obj->sizes[] = $s;
                        $x++;
                    }
                    $mods = Modifier::where('modifiertemplate_id',$row->modifiertemplate_id)->get();
                    foreach ($mods as $mod) {
                        $m=new stdClass();
                        $m->id = (int)$mod->id;
                        $m->name = $mod->getTranslation('modifier_name',App::getLocale());
                        $m->price = floatval($mod->modifier_price);
                        $obj->itemadditions[] = $m;
                    }
                    $matobj[]=$obj;
                }
                $materialsJson = json_encode($matobj);
                Cache::store('tenant')->put('materialsJson', $materialsJson);
            }

            return $materialsJson;

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        if($request->op =='placeorder')
        {
            $res = new stdClass();
            Session::put('confirmationtoken',uniqid());
            $name  =  str_replace(array(':', '-', '/', '*'), '', $request->name);
            $token =  str_replace(array(':', '-', '/', '*'), '', $request->token);
            $total =  str_replace(array(':', '-', '/', '*'), '', $request->total);
            $email =  str_replace(array(':', '-', '/', '*'), '', $request->email);
            $order =  str_replace(array('-', '/', '*'), '', json_encode($request->order));


            $table = (App::make('option')->getOPtionVal('activatetables')=='1')? str_replace(array(':', '-', '/', '*'), '', $request->table) :'.';

            if ($token != Session::get('token'))
            {
              $res->result = 'error';
              Session::put('lastmsg1',__('Error saving order'));
              Session::put('lastmsg2',__('Token error'));
              $res->redirect = route('app.index',['page'=>'error','token'=>Session::get('confirmationtoken')]);

            }else if ($name!='' && $table!='' && $order!='')
            {
                Cookie::queue('username', $name, time() + (86400 * 120));
                $order_obj = new Order;
                $order_obj->order_date=Carbon::now();
                $order_obj->client_name=$name;
                $order_obj->client_email=$email;
                $order_obj->tablecode=$table;
                $order_obj->orderdetail=$order;
                $order_obj->ordertotal=$total;
                if ($order_obj->save())
                {
                    $res->result = 'success';
                    Session::put('tablecode','');
                    Session::put('confirmationtoken',uniqid());
                    $res->redirect =  route('app.index',['page'=>'confirmation','token'=>Session::get('confirmationtoken')]);
                    Session::put('lastmsg1',__('Thank you for ordering!'));
                    Session::put('lastmsg2',__('We have already started processing your order!'));

                    if ((App::make('option')->getOptionVal('activatenotification')=="1"))
                    {
                      $res->result = 'error';
                      Session::put('lastmsg1',__('Error sending notification, please tell the waiter about this error!'));
                      Session::put('lastmsg2','');
                      $res->redirect = route('app.index',['page'=>'error','token'=>Session::get('confirmationtoken')]);
                    }
                }
                else {
                    $res->result = 'error';
                    $res->msg = __('Technical error occurred!');
                  }
            }
            else {
                $res->result = 'error';
                $res->msg = __('Please correct the inputs');
                 }
          return json_encode($res);

        }else if( $request->op =='postorder')
        {
            $order= Order::findorfail($request->id);
            $res = new stdClass();
            $order->isposted=1;
            $order_obj->posteddate=Carbon::now();
            if ($order->save()) {
                $res->result = 'success';
            }else {
                $res->result = 'error';
            }
            return json_encode($res);
        }

     }
}
