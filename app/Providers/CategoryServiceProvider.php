<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Fetch the categories from the database and share with all views
        $categories = DB::table('products')
                        ->select('category')
                        ->distinct()
                        ->get();

        // Share 'categories' variable across all views
        View::share('categories', $categories);
        
}
}