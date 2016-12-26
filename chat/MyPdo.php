<?php

/**
 * Singleton class
 *
 */
final class MyPdo {

    private $pdo;

    /**
     * Call this method to get singleton
     *
     * @return Singleton
     */
    public static function getInstance() {
        static $inst = null;
        if ($inst === null) {
            $inst = new MyPdo();
        }
        return $inst;
    }

    public function getPDO() {
        return $this->pdo;
    }

    private function __construct() {
        $dsn = "mysql:host=anykey;dbname=test;charset=utf8";
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $user = 'root';
        $pass = '';
        $this->pdo = new PDO($dsn, $user, $pass, $opt);
    }

    private function __clone() {

    }

}
