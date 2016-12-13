<?php
abstract class BaseModel {
    protected $pdo = null;
    protected static $tableName;
    public function __construct() {
        $this->pdo = PDOLib::getInstance()->getPdo();
    }
    abstract protected function save();
    abstract protected function update();
}