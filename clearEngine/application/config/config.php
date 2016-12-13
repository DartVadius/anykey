<?php
function autoloadMain($class) {
    preg_match_all('/[A-Z][^A-Z]*/', $class, $results);
    $results =  end($results[0]);
    $pathToClassFile = __DIR__ . '/../'. strtolower($results). '/' . $class.'.php';
    if (file_exists($pathToClassFile)) {
        require_once $pathToClassFile;
    }
}
spl_autoload_register('autoloadMain');
define('APPLICATION_ENV', $_SERVER['APPLICATION_ENV']);

return [
    'layout' => 'layout',
    'defaultController' => 'index',
    'defaultAction' => 'index',
    'exceptionController' => 'error',
    'exceptionAction' => 'error',
    'title' => 'Ugly Blog',
    //количество статей на главной странице
    'article_limit' => 2,
    //количество статей на странице в админке
    'admin_art_limit' => 4,
    //минимальная длина логина, имени и пароля
    'login_length' => 6,
    'name_length' => 3,
    'pass_length' =>6,
    //группа доступа, которая будет присваиваться новым зарегистрировавшимся пользователям по умолчанию
    'group_value' => 1,
    'db' => [
        'host' => '',
        'name' => '',
        'user' => '',
        'password' => ''
    ],
    'email' => [
        'name' => "DartVadius",
        'email' => 'test@gmail.com'
    ]
];