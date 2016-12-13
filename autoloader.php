<?php
//файл с автолоадером нужно подгружать там, где вызываются классы

//1-й вариант 
function __autoload($class) {
    //парсим имя класса (все части имени класса, начинающиеся с заглавной буквы)
    preg_match_all('/[A-Z][^A-Z]*/', $class, $results);
    //берем последний элемент полученного массива (т.е., например, из названия anyClassPhpModel получаем 'Model')
    $results =  end($results[0]);
    //задаем путь к файлу, в данном случае из каталога автолоадера на один уровень вверх и в папку с названием,
    //котрое мы спарсили выше
    $pathToClassFile = __DIR__ . '/../'. strtolower($results). '/' . $class.'.php';
    //если файл существует, подкючаем его
    if (file_exists($pathToClassFile)) {
        require_once $pathToClassFile;
    }
}

//2-й вариант 
//пишем пользовательские функции автозагрузки
function autoload1($class) {
    //любая функция подкючения файла
    require_once 'classes/' . $class . '.class.php';
}
function autoload2($class) {
    preg_match_all('/[A-Z][^A-Z]*/', $class, $results);    
    $results =  end($results[0]);    
    $pathToClassFile = __DIR__ . '/../'. strtolower($results). '/' . $class.'.php';    
    if (file_exists($pathToClassFile)) {
        require_once $pathToClassFile;
    }
}
//и подкючаем их, порядок подключения будет соответствующим 
spl_autoload_register('autoload1');
spl_autoload_register('autoload2');