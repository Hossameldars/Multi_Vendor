<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Database\Seeders\StoreSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      DB::table('users')->delete();
    $store_id=  Store::first()->id;
        User::create(
          [
          'name'=>'hossam',
          'email'=>'hossasmm423@gmail.com',
          'password'=>'123456789',
          'store_id'=>$store_id
          ]);
          
    }
}
