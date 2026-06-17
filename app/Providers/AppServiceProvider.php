<?php

namespace App\Providers;

use App\Models\Permission;
use App\Repository\Cart\CartModelRepostory;
use App\Repository\Cart\CartRepostory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      $this->app->bind(
            CartRepostory::class,
        CartModelRepostory::class
    
    );
    $this->app->singleton('cart', function () {
            return new CartModelRepostory();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
      App::setLocale(request('locale','en'));
      Paginator::useBootstrapFive();

  $permissions = Permission::pluck('name');
         foreach($permissions as $permission){
            Gate::define($permission,function($user) use ($permission)  {
      return $user->hasPermission($permission)  ;
      });
         }
    
    
        }
}
