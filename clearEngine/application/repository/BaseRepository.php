<?php

/**
 * BaseRepository
 *
 * @author DartVadius
 */
abstract class BaseRepository {
    protected $pdo = null;
    public function __construct() {
        $this->pdo = PDOLib::getInstance()->getPdo();
    }
}
