<?php
class SequreLib {    
    public static function clearReq($str) {
        $res = NULL;
        $res = trim($str);
        $res = addslashes($res);
        $res = htmlspecialchars ($res);
        return $res;
    }
    public static function emailValidate ($email) {
        $s = '"';
        if (preg_match("/^(\w+([\.\w+])*)@\w+(\.\w+)?\.\w{2,3}$/i", $email) ||
            preg_match("/^$s{1}.+$s{1}@\w+(\.\w+)?\.\w{2,3}$/i", $email)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
