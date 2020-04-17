
<?php
return [
    /*
     |--------------------------------------------------------------------------
     | Configuracion basica
     |--------------------------------------------------------------------------
     |
     |
     */
    'version'       => '0.1',
    'languages'     => [
        'es' => 'Español',
        'en' => 'Ingles',
    ],
    'images' => [
        [
            'name'    => 'thumbnail',
            'height'  => '100',
            'width'   => '100',
            'quality' => 90,
        ],
        [
            'name'    => 'small',
            'height'  => '185',
            'width'   => '185',
            'quality' => 90,
        ],
        [
            'name'    => 'medium',
            'height'  => '358',
            'width'   => '358',
            'quality' => 90,
        ],
        [
            'name'    => 'large',
            'height'  => '1000',
            'width'   => '1000',
            'quality' => 90,
        ],
    ],
    'images_types' => [
        'og-image',
        'cover',
        'main',
        'other',
    ],
    'pagination' => [5, 10, 20, 40, 80, 100],
    'hybridauth' => [
        'facebook' => [
            'enabled' => true,
            'callback' => env('APP_URL').'/social-auth/facebook',
            'keys' => [ 'key' => env('FACEBOOK_KEY'), 'secret' => env('FACEBOOK_SECRET') ]
        ],
        'twitter' => [
            'enabled' => true,
            'callback' => env('APP_URL').'/social-auth/twitter',
            'keys' => [ 'key' => env('TWITTER_KEY'), 'secret' => env('TWITTER_SECRET') ]
        ],
        'google' => [
            'enabled' => true,
            'callback' => env('APP_URL').'/social-auth/google',
            'keys' => [ 'key' => env('GOOGLE_KEY'), 'secret' => env('GOOGLE_SECRET') ]
        ]
    ],
    'sync' => [
        'server'       => env('SYNC_SERVER', ''),
        'username'     => env('SYNC_USERNAME', ''),
        'port'         => env('SYNC_PORT', ''),
        'path'         => env('SYNC_PATH', ''),
        'sync_folders' => [
            'storage/app/public/',
        ]
    ],
    'menu' => [
        '\Capmega\Blog\Helpers\Menu',
        '\Capmega\Base\Helpers\Menu',
    ],
    'search' => [
        'default' => false
    ],
];
