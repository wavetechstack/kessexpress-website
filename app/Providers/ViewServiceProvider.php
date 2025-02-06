<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Register components
        Blade::componentNamespace('App\\View\\Components\\Sections', 'sections');
        
        // Share services data with home page
        View::composer('pages.home', function ($view) {
            $services = [
                [
                    'title' => 'Analytics & BI',
                    'description' => 'Unlock the power of your data with advanced analytics and business intelligence solutions.',
                    'icon' => 'chart-bar'
                ],
                [
                    'title' => 'Cybersecurity',
                    'description' => 'Protect your business with advanced security solutions against modern threats.',
                    'icon' => 'shield'
                ],
                // Add other services as needed
            ];
            
            $view->with('services', $services);
        });
    }
}
