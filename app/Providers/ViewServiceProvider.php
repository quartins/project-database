<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ✅ ตรวจสอบว่าส่งไปที่ 'layouts.navigation'
        View::composer('layouts.navigation', function ($view) {
             // ✅ ตรวจสอบว่าส่งด้วยชื่อ 'navCategories'
            $view->with('navCategories', Category::all());
        });
    }
}