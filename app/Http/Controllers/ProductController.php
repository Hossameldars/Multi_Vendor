<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Role;
use App\Models\Store;
use App\Models\Tag;
use App\Traits\Trait_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    
    use Trait_image;

        public function index()
    { 
      $products= Product::paginate(3);
      return view('Dashboard.Product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
        $stores =Store::all();
        $categories=Category::all();
          return view('Dashboard.Product.create',compact('categories','stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
  $product=    Product::create([
    'name'          => $request->name,
    'store_id'      => $request->store_id,
    'catagory_id'   => $request->catagory_id,
    'slug'          => Str::slug($request->name),
    'description'   => $request->description,
    'price'         => $request->price,
    'compare_price' => $request->compare_price,
    'options'       => $request->options,
    'featured'      => $request->boolean('featured'),
    'status'        => $request->status ?? 'active',
]);
$path= $this->image($request,'Product');
       if ($path)
            {
            Image::create([
        'path' =>$path,
        'imageable_id'=>$product->id,
        'imageable_type'=> 'App\Models\Product'
        ]); } 
   toastr()->success('تم إضافة المنتج  بنجاح!', 'تمت العمليه ');
         return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    { 
       $this->authorize('products.update',Product::class);
        $product=Product::findOrFail($id);
        $stores =Store::all();
        $categories=Category::all();
        $tags= implode(',',$product->Tags()->pluck('name')->toArray());

           //dd($tags);
        return view('Dashboard.Product.edit',compact('categories','stores','product','tags'));
    }

  
    public function update(UpdateProductRequest $request, $id)
    {
        $product=Product::findOrFail($id);
        $product->update([
    'name'          => $request->name,
    'store_id'      => $request->store_id,
    'catagory_id'   => $request->catagory_id,
    'slug'          => Str::slug($request->name),
    'description'   => $request->description,
    'price'         => $request->price,
    'compare_price' => $request->compare_price,
    'options'       => $request->options,
    'featured'      => $request->boolean('featured'),
    'status'        => $request->status ?? 'active',
        ]);
          $path= $this->image($request,'Product');
       if ($path){
        if ($product->images)
          {
          Storage::disk('public')->delete($product->images->path);
          }
            $product->images()->updateOrCreate(
            [
                'imageable_id'   => $product->id,
                'imageable_type' => 'App\Models\Product'
            ],
            ['path' => $path]
        ); } 
        $tags=explode(',',$request->tags);
        $tag_ids= []; 
        if ($tags)
          {
            foreach($tags as $t_name)
              {
                $slug =Str::slug($t_name);
                $tag=Tag::where('slug',$slug)->first();
                if(!$tag)
                  {
                    $tag=Tag::create([
                      'name'=>$t_name,
                      'slug'=>$slug
                    ]);
                  }
              $tag_ids[]=$tag->id;
              }
          }
          $product->tags()->sync($tag_ids);
           toastr()->success('تم نعديل  المنتج  بنجاح!', 'تمت العمليه ');
         return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        //
    }
}
