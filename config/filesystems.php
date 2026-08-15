<?php

return [

    'default' => env('FILESYSTEM_DISK', 'cloudinary'),

    'disks' => [

        'cloudinary' => [
            'driver' => 'cloudinary',
        ],

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        // A MÁGICA ACONTECE AQUI:
        // Quando o tema forçar o uso da pasta 'public', o Laravel vai jogar para o Cloudinary!
        'public' => [
            'driver' => 'cloudinary',
        ],

    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
