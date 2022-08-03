<?php

use Carbon\Carbon;

if (! function_exists('appName')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function appName()
    {
        return config('app.name', 'DashCore');
    }
}

if (! function_exists('appDescription')) {
    /**
     * Helper to grab the application description.
     *
     * @return mixed
     */
    function appDescription()
    {
        return config('app.desc', 'Premium Template and Starter Kit for Laravel powered Apps');
    }
}

if (! function_exists('carbon')) {
    /**
     * Create a new Carbon instance from a time.
     *
     * @param $time
     *
     * @return Carbon
     * @throws Exception
     */
    function carbon($time)
    {
        return new Carbon($time);
    }
}

if (! function_exists('homeRoute')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        return 'home';
    }
}

if (! function_exists('strLeft')) {
    function strLeft($str, $length)
    {
        return substr($str, 0, $length);
    }
}

if (! function_exists('strRight')) {
    function strRight($str, $length)
    {
        return substr($str, -$length);
    }
}
