<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $colroarray = [
                "aqua",
                "antiquewhite",
                "burlywood",
                "turquoise",
                "yellowgreen"
            ];
            $firstTitleArray = [
                "Harness the Power of the Sun",
                "Go Green, Save Green",
                "Sustainable Energy Solutions for a Brighter Future",
                "Empowering Your Home with Solar Energy",
                "Switch to Solar, Save the Planet",
                "Choose Solar – The Eco-Friendly Energy Solution",
                "Sustainable Living Made Easy with Solar Products",
                "Eco-Friendly Energy for a Greener Tomorrow",
                "Solar Power: Clean Energy for a Clean Future",
                "Reduce, Reuse, Solar-Power!"
            ];
            $secondTitleArray = [
                "Capture the Sun's Energy with High-Efficiency Solar Panels",
                "Store Solar Power for Use Anytime",
                "Convert Solar Energy into Usable Power Efficiently",
                "Illuminate Your Space with Eco-Friendly Solar Lighting",
                "Heat Your Water with Renewable Solar Energy",
                "Innovative Solar Technology for Maximum Efficiency",
                "Advanced Solar Solutions for Modern Living",
                "Cutting-Edge Solar Products for Your Home",
                "Smart Energy Solutions with Solar Technology",
                "High-Tech Solar Power for High-Energy Savings"
            ];

            $view->with(['firstTitleArray' => $firstTitleArray, 'secondTitleArray' => $secondTitleArray, 'colroarray' => $colroarray]);
        });
        // Paginator::useBootstrapFive();
    }
}
