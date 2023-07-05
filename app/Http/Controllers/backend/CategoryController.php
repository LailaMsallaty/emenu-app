<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ModifierTemplate;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\File;
use db;
use Storage;
use App;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->type == 'main'){
            $categories = Category::where('category_father_id',null)->orderBy('category_index','Asc')->get();
        }
        else{
            $categories = Category::with('parent')->where('category_father_id','!=',null)->orderBy('category_index','Asc')->get();
        }
        return view('backend.categories.index',['categories'=>$categories,'type'=>$request->type]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = Category::where('category_father_id',null)->get();
        $templates  = ModifierTemplate::all();
        return view('backend.categories.create',
         [
          'categories'=>$categories,
          'templates'=> $templates,
          'type'=> $request->type
         ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try
        {
            $validated = $request->validated();
            $category = new Category;
            $category->category_name = $request->category_name;
            $category->category_description = $request->description;
            $category->modifiertemplate_id  = $request->modifiertemplate_id;
            if($request->categoryparent){
                $category->category_father_id   = $request->categoryparent;
            }
            if($request->hasfile('categoryimg'))
            {
                $file= $request->file('categoryimg');
                if ($file->isValid()) {
                   $file_name=uniqid().$file->getClientOriginalName();
                   $path= $file->storeas('/cats',$file_name,[
                     'disk'=>'tenant'
                   ]);
                   $category->categoryimg = $file_name;
                }
            }
           $category->category_index = Category::max('category_index')+1;
           $category->save();

           return redirect()->route('categories',['type'=>$request->type])->with('success', __('Category Successfully Inserted'));


        } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    public function getMaterials(Category $category,Request $request){
        $materials = $category->materials;
        return view('backend.materials.index',[
            'materials'=> $materials
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category,Request $request)
    {
        //dd(DB::getConnections());

        $categories = Category::where('category_father_id',null)->get();
        $templates = ModifierTemplate::all();
        return view('backend.categories.edit',
         [
          'category'=>$category,
          'categories'=>$categories,
          'templates'=> $templates,
          'type'=>$request->type
         ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try
        {
            $validated = $request->validated();
            $category->category_name = $request->category_name;
            $category->category_description = $request->description;
            $category->modifiertemplate_id =  $request->modifiertemplate_id;

            if($request->categoryparent){
                $category->category_father_id   = $request->categoryparent;
            }
            // update image
            if($request->hasfile('categoryimg'))
            {
                $pre_file  = Storage::disk('tenant')->path('cats/'.$category->categoryimg);
                if(File::exists($pre_file)){
                    File::delete($pre_file);
                }
                $file= $request->file('categoryimg');
                if ($file->isValid()) {
                   $file_name=uniqid().$file->getClientOriginalName();
                   $path= $file->storeAs('/cats',$file_name,[
                     'disk'=>'tenant'
                   ]);
                   $category->categoryimg = $file_name;
                }
            }
           $category->category_index = Category::max('category_index')+1;
           $category->save();

           return redirect()->route('categories',['type'=>$request->type])->with('success', __('Category Successfully Updated'));;


        } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Category $category)
    {
        try
        {
                $category->delete();
                $file = Storage::disk('tenant')->path('cats/'.$category->categoryimg);
                if (File::exists($file)) {
                    File::delete($file);
                }
                return  response()->json([
                    'success' => __('Category Successfully Deleted'),
                    'url'=>'?type='.$request->type
                ]);

         } catch (\Exception $e){
            return  response()->json([
                'error' => __('This Category Cannot Be Deleted'),
                'message'=>$e->getMessage()
            ]);
            }

    }
    public function delete_all(Request $request){
        try
        {
            foreach ($request->delete as $value) {
                    $category = Category::findorfail($value);
                    $category->delete();
                    $file = Storage::disk('tenant')->path('cats/'.$category->categoryimg);
                    if (File::exists($file)) {
                        File::delete($file);
                    }
            }
            return response()->json(
            [
                'success'=>__('Categories Successfully Deleted'),
                'url'=>'?type='.$request->type
            ]);

         } catch (\Exception $e){
            return response()->json([
                'error'=>__('Some Of Categories Cannot Be Deleted'),
                'message'=> $e->getMessage()
            ]);
        }
    }
    public function updateCategorySort(Request $request) {

        try{

            if($request->arrow)
            {
                 $category = Category::findOrfail($request->id);
                if($request->arrow =='up'){
                    $category->decrement('category_index');
                }
                else if($request->arrow =='down'){
                    $category->increment('category_index');
                }
                $category->save();
            }
            if($request->position)
            {
                $i=1;
                foreach ($request->position as $key => $value) {
                    $category = Category::findOrfail($value);
                    $category->category_index = $i;
                    $category->save();
                    $i++;
                }
            }
            return response()->json(
            [
            'success'=>'success',
            'url'=>'?type='.$request->type
            ]);

        }catch(\Exception $e){
            return response()->json([
                'error'=>__('Something Went Wrong'),
                'message'=> $e->getMessage()
            ]);
        }
    }
}
