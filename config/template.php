<?php

/*
 * All configuration options for Laravel Boilerplate
 * http://laravel-boilerplate.com.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Access
    |--------------------------------------------------------------------------
    |
    | Configurations related to the template's access/authorization options
    */
    'access' => [
        'user' => [
            /*
             * Whether or not the register route and view are active
             */
            'registration' => env('ENABLE_REGISTRATION', true),
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Locale
    |--------------------------------------------------------------------------
    |
    | Configurations related to the boilerplate's locale system
    */
    'locale' => [
        /*
         * Whether or not to show the language picker, or just default to the default
         * locale specified in the app config file
         */
        'status' => false,

        /*
         * Available languages
         *
         * Add your language code to this array.
         * The code must have the same name as the language folder.
         * Be sure to add the new language in an alphabetical order.
         *
         * The language picker will not be available if there is only one language option
         * Commenting out languages will make them unavailable to the user
         */
        'languages' => [
            'ar' => ['name' => 'Arabic', 'rtl' => true],
            'en' => ['name' => 'English', 'rtl' => false],
            'es' => ['name' => 'Spanish', 'rtl' => false],
            'it' => ['name' => 'Italian', 'rtl' => false]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Testing Mode
    |--------------------------------------------------------------------------
    |
    | When your application is currently running tests
    |
    */
    'testing' => env('APP_TESTING', false),
];
