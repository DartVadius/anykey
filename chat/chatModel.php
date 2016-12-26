<?php

/**
 * chat
 *
 * @author DartVadius
 */
class ChatModel {

    public static $tableName = 'message';
    private $nick;
    private $text;

    public function __construct($nick, $text) {
        $this->nick = $nick;
        $this->text = $text;
    }

    public function save() {
        $sql = "INSERT INTO " . self::$tableName . " SET
            nick = :nick,
            text = :text";
        $arr = array(
            'nick' => $this->nick,
            'text' => $this->text,
        );
        $res = MyPdo::getInstance()->getPDO()->prepare($sql);
        $res->execute($arr);
    }

    public static function getChat($id) {
        $sql = "SELECT * FROM " . self::$tableName . " WHERE id > :lastId";
        $arr = array(
            'lastId' => $id
        );
        $res = MyPdo::getInstance()->getPDO()->prepare($sql);
        $res->execute($arr);
        $msg = $res->fetchAll();
        return $msg;
    }

    public static function getLastId() {
        $sql = "SELECT id FROM " . self::$tableName . " ORDER BY id DESC LIMIT 1";
        $res = MyPdo::getInstance()->getPDO()->prepare($sql);
        $res->execute();
        $id = $res->fetch()['id'];
        return $id;
    }

}
