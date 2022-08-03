<?php

namespace App\Providers;

use App\Models\SidebarMenu;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $adminMenu = [];
        $managerMenu = [];
        $userMenu = [];
        foreach (json_decode(SidebarMenu::where('status', 1)->where('type', 1)->orderBy('order', 'ASC')->get()->pluck('options')) as $key) {
            $adminMenu[] = json_decode($key);
        }
        foreach (json_decode(SidebarMenu::where('status', 1)->where('type', 4)->orderBy('order', 'ASC')->get()->pluck('options')) as $key) {
            $managerMenu[] = json_decode($key);
        }
        foreach (json_decode(SidebarMenu::where('status', 1)->where('type', 2)->orwhere('type', 3)->orderBy('order', 'ASC')->get()->pluck('options')) as $key) {
            $userMenu[] = json_decode($key);
        }
        // Share all menuData to all the views
        \View::share('menuData', [$adminMenu]);
        \View::share('managermenuData', [$managerMenu]);
        \View::share('usermenuData', [$userMenu]);
    }
}
