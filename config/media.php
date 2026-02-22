<?php

return [

    'disk' => env('MEDIA_DISK', 'r2'),

    'format' => 'webp',

    'quality' => 80,

    'variants' => [
        'thumbnail' => ['width' => 150],
        'small' => ['width' => 400],
        'medium' => ['width' => 800],
        'large' => ['width' => 1200],
    ],

];
