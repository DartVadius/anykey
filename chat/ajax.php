<?php

$entityBody = file_get_contents('php://input');
$data = json_decode($entityBody, TRUE);
$dsn = "mysql:host=anykey;dbname=test;charset=utf8";
$opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
$pdo = new PDO($dsn, 'root', '', $opt);
if (!empty($data['messageId'])) {
    $id = $data['messageId'];
} else {
    $id = "0";
}
if (!empty($data['func']) && $data['func'] == 'addMessage') {
    $sql = "INSERT INTO message SET
            nick = :nick,
            text = :text";
    $arr = array(
        'nick' => $data['nick'],
        'text' => $data['text'],
    );
    $res = $pdo->prepare($sql);
    $res->execute($arr);
}
$sql = "SELECT * FROM message WHERE id > $id";
$res = $pdo->query($sql);
$msg = $res->fetchAll();
$sql = "SELECT * FROM message ORDER BY id DESC LIMIT 1";
$res = $pdo->query($sql);
$id = $res->fetch()['id'];
$answer = ['data' => $msg, 'nextMessageId' => "$id"];
echo (json_encode($answer));
