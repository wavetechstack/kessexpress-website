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
        // Register the components namespace
        Blade::componentNamespace('App\\View\\Components', 'x');

        // Register sections components
        Blade::component('hero', \App\View\Components\Sections\Hero::class);
        Blade::component('stats', \App\View\Components\Sections\Stats::class);
        Blade::component('service-card', \App\View\Components\Sections\ServiceCard::class);
        Blade::component('partners', \App\View\Components\Sections\Partners::class);

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
                [
                    'title' => 'Data Platform Services',
                    'description' => 'Scalable solutions for analytics and AI implementation.',
                    'icon' => 'database'
                ],
                [
                    'title' => 'Data Center Solutions',
                    'description' => 'Flexible on-premises, cloud & hybrid infrastructure options.',
                    'icon' => 'cloud'
                ],
                [
                    'title' => 'Managed Services',
                    'description' => '24/7 IT support for your business operations.',
                    'icon' => 'cog'
                ],
                [
                    'title' => 'Managed Security',
                    'description' => 'Round-the-clock cybersecurity monitoring and threat response.',
                    'icon' => 'lock'
                ],
                [
                    'title' => 'Networking',
                    'description' => 'Build robust and scalable network infrastructure.',
                    'icon' => 'network'
                ],
                [
                    'title' => 'E-Commerce Solutions',
                    'description' => 'Complete e-commerce scaling solutions across major platforms.',
                    'icon' => 'shopping-cart'
                ]
            ];

            $view->with('services', $services);
        });
    }
}