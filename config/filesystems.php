<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            // 'url' => env('APP_URL').'/storage',
            // 'visibility' => 'public',
        ],

        'public_uploads' => [
            'driver' => 'local',
            'root'   => public_path(),
        ],

        'products' => [
            'driver' => 'local',
            'root' => public_path('uploads/products'),

        ],
        'advertisments' => [
            'driver' => 'local',
            'root' => public_path('uploads/advertisments'),

        ],
        'recuringsub' => [
            'driver' => 'local',
            'root' => public_path('uploads/recuringsub'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'RecuringSubFilter' => [
            'driver' => 'local',
            'root' => public_path('uploads/RecuringSubFilter'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],
        'RecuringFilter' => [
            'driver' => 'local',
            'root' => public_path('uploads/RecuringFilter'),
            // 'url' => env('APP_URL') . '/storage',
            // 'visibility' => 'public',
        ],

        'recuring' => [
            'driver' => 'local',
            'root' => public_path('uploads/recuring'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'categories' => [
            'driver' => 'local',
            'root' => public_path('uploads/categories'),
            // 'url' => env('APP_URL') . '/storage',
            // 'visibility' => 'public',
        ],
        'Filters' => [
            'driver' => 'local',
            'root' => public_path('uploads/Filters'),
            // 'url' => env('APP_URL') . '/storage',
            // 'visibility' => 'public',
        ],
        'SubFilters' => [
            'driver' => 'local',
            'root' => public_path('uploads/SubFilters'),
            // 'url' => env('APP_URL') . '/storage',
            // 'visibility' => 'public',
        ],

        'subcategories' => [
            'driver' => 'local',
            'root' => public_path('uploads/subcategories'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],
        'admins' => [
            'driver' => 'local',
            'root' => public_path('uploads/admins'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],
        'upgrade-requests' => [
            'driver' => 'local',
            'root' => public_path('uploads/upgrade-requests'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],
        'organiztions' => [
            'driver' => 'local',
            'root' => public_path('uploads/organiztions'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],
        'posts' => [
            'driver' => 'local',
            'root' => public_path('uploads/posts'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],
        'settings' => [
            'driver' => 'local',
            'root' => public_path('uploads/settings'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_S3_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
	        'visibility'  => 'public'
        ],

        's3-stagging' => [
            'root' => '/stagging',
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_S3_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
	        'visibility'  => 'public'
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
