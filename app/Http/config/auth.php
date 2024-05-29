<?php
[
'defaults' => [
    'guard' => 'api',
    'passwords' => 'users',
],



'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
];