<?php
 namespace App\Traits;


use App\Models\Image;

 trait Trait_image
 {
  public function image($request,$namefile)
  {
    if (!$request->hasfile('image'))
        {
          return ; 
        }
          $file= $request->file('image');
        //  $file->getClientOriginalName();
          $path=$file->store($namefile,'public');
      
      return $path; 
          
    
  }
  
  
 }