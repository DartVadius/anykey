<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

return [
    'layout' => 'layout',
    'db' => [
        'host' => 'localhost',
        'name' => 'easy_blog',
        'user' => 'root',
        'password' => ''
    ],
    'test' => [
        'name' => "ALex",
        'email' => 'testEmail@gmail.com',
    ]
];