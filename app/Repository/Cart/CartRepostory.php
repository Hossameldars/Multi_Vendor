<?php 
namespace App\Repository\Cart;

use App\Models\Product;

interface CartRepostory {
  public function get();
  public function add(Product $product,$quantity=1);
  public function update($id,$quantity);
  public function delete( $id);
  public function empyt();
  public function total();
}
