<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Store;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
    'name', 'store_id', 'catagory_id', 'slug',
    'description', 'price', 'compare_price',
    'options', 'featured', 'status'
];
     protected static function booted(): void
    {
        static::addGlobalScope('products',function (Builder $builder){
      
         if (Auth::check()) { 
        $builder->where('store_id', Auth::user()->store_id);
    }
           static::creating([function (Product $product){
            $product->slug=Str::slug($product->name);
           }]);
        });
    }
    public function Category()
    {
      return $this->belongsTo(Category::class,'catagory_id');
    }
    public function Store()
    {
      return $this->belongsTo(Store::class);
    }
      public function images()
{
      return $this->morphOne(Image::class, 'imageable');
}
    public function Tags()
    {
      return $this->belongsToMany(
        Tag::class,
        'product_tag',
        'product_id',
        'tag_id',
        'id',
        'id'

        );
    }
    // App\Models\Product.php

public function getDiscountPercentageAttribute(): int
{
    if (!$this->compare_price || $this->compare_price <= $this->price) {
        return 0;
    }

    return (int) round(
        (($this->compare_price - $this->price) / $this->compare_price) * 100
    );
}
 public function scopeFilter(Builder $builder ,$filter)
 {
    $options= array_merge([
      'store_id'=>null,
      'catagory_id'=>null,
      'tag_id'=>[],
      'status'=>'active'
    ],$filter);
      $builder->when($options['status'],function($builder,$value){
      $builder->where('status',$value);
    });
    $builder->when($options['store_id'],function($builder,$value){
      $builder->where('store_id',$value);
    });
      $builder->when($options['catagory_id'],function($builder,$value){
      $builder->where('catagory_id',$value);
    });
      $builder->when($options['tag_id'],function($builder,$value){
      $builder->whereExists(function($query)use ($value){
               $query->select(1)
               ->form('product_tag')
               ->whereRaw('product_id= product.id')
               ->where('tag_id',$value);
      });

    });
 }
}
