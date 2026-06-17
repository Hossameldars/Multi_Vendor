<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
  protected $fillable=['name','slug','parent_id',
  'description','image','status'];
  public function Parent()
  {
    return   $this->belongsTo(Category::class ,'parent_id');
  }
  public function  scopeFilter(Builder $builder,$value)
  {
   if ($value ?? false)
    {
       $builder->where('name', 'like', '%' . $value . '%');
    }
  }
  public function images()
{
      return $this->morphOne(Image::class, 'imageable');
}
}
