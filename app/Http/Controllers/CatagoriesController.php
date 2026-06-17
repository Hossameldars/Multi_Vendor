<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Image;
use App\Traits\Trait_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
class CatagoriesController extends Controller
{
  use Trait_image;
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
{
           if (!Gate::allows('Categories.create'))
            {
              abort(403);
            }
    $Catagories = Category::Filter($request->name)->paginate(3);
    //$Catagories = $query->paginate(3);
    return view('Dashboard.Catagories.index', compact('Catagories'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       Gate::authorize('Categories.create');
            
        $parents=Category::all();
        return view('Dashboard.Catagories.create',compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
    
        
      $category=  Category::create([
          'name'=>$request->name,
          'slug'=>Str::slug($request->name),
          'parent_id'=>$request->parent_id,
          'description'=>$request->description,
          'status'=>$request->status,
    
        ]);
           $path = $this->image($request,'Category_image');
           if ($path)
            {
            Image::create([
        'path' =>$path,
        'imageable_id'=>$category->id,
        'imageable_type'=> 'App\Models\Category'
        ]);  
        }
         toastr()->success('تم إضافة الفئة بنجاح!', 'تمت العمليه ');
        return redirect()->route('categories.index');
    }  
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $category= Category::findorfail($id);
        $parents=Category::where('id','<>',$id)->get();
             return view('Dashboard.Catagories.edit',compact('category','parents'));
    }

  
    public function update(UpdateCategoryRequest $request, string $id)
    {
          $category=Category::findOrFail($id);
             $old_image=$category->images;

         $category->update([
          'name'=>$request->name,
          'slug'=>Str::slug($request->name),
          'parent_id'=>$request->parent_id,
          'description'=>$request->description,
          'status'=>$request->status,
          
         ]);
         $path = $this->image($request,'Category_image');
           if ($path) {
        
        if ($old_image) {
            Storage::disk('public')->delete($old_image->path);
        }

      
        $category->images()->updateOrCreate(
            [
                'imageable_id'   => $category->id,
                'imageable_type' => 'App\Models\Category'
            ],
            ['path' => $path]
        );
    }
        return redirect()->route('categories.index');
    }

  
    public function destroy(string $id)
    {
          $category=Category::findOrFail($id);
          $category->delete();
          // if($category->image)
          //   {
          //       Storage::disk('public')->delete($category->image);
          //   }
        
        return redirect()->route('categories.index');
    }
  
      public function archive() {
    
      $Catagories = Category::onlyTrashed()->paginate(3); 
      return view('Dashboard.Catagories.archive', compact('Catagories'));
  }
    public function restore(Request $request,$id) {
    
       Category::withTrashed()->where('id',$id)->restore();
      return redirect()->route('categories.archive');
  }
    public function forceDelete(Request $request,$id) {
    
       $category=Category::withTrashed()->where('id',$id)->first();
       $category->forceDelete();
           if($category->image)
            {
                Storage::disk('public')->delete($category->image);
            }
      return redirect()->route('categories.archive');
  }

}
