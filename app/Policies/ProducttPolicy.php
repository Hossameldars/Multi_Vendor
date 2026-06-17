<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProducttPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny( $user): bool
    {
               return $user->hasPermission('products.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view( $user, Product $product): bool
    {
           return $user->hasPermission('products.view') &&$product->store_id==$user->store_id ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create( $user): bool
    {
         return $user->hasPermission('products.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update( $user, Product $product): bool
    {
           return $user->hasPermission('products.update') &&$product->store_id==$user->store_id ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete( $user, Product $product): bool
    {
           return $user->hasPermission('products.delete')&&$product->store_id==$user->store_id ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore( $user, Product $product): bool
    {
           return $user->hasPermission('products.restore')&&$product->store_id==$user->store_id ;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete( $user, Product $product): bool
    {
         return $user->hasPermission('products.forcedelete')&&$product->store_id==$user->store_id ;
    }
}
