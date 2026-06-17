<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable =['user_id','fisrt_name','last_name',
    'birthday','gender','street_address','city',
    'state','postal_code','country','locale'];
    public function user()
    {
      return $this->belongsTo(User::class);
    }
      public function images()
{
      return $this->morphOne(Image::class, 'imageable');
}
    protected $casts = [
    'birthday' => 'date',
                      ];

}
