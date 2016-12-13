<?php
/**
 * Singleton class
 *
 */
final class PDOLib
{
    private $pdo; // PDO instance;
    /**
     * Call this method to get singleton
     *
     * @return Singleton
     */
    public static function getInstance()
    {
        static $inst = null;


        if ($inst === null) {
            $inst = new PDOLib();
        }
        return $inst;
    }


    public function getPDO() {
        return $this->pdo;
    }

    /**
     * Private ctor so nobody else can instance it
     *
     */
    private function __construct()
    {
        $dsn = "mysql:host=".HOST_NAME.";dbname=".DB_NAME.";charset=utf8";
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $this->pdo = new PDO($dsn, USER_NAME, PASSWORD, $opt);
    }

    private function __clone()
    {

    }
}