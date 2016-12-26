<?php

spl_autoload_register(function ($class) {
    $path = $class . '.php';
    require_once $path;
});

$entityBody = file_get_contents('php://input');
$data = json_decode($entityBody, TRUE);

if (!empty($data['messageId'])) {
    $id = $data['messageId'];
} else {
    $id = "0";
}

if (!empty($data['func']) && $data['func'] == 'addMessage') {
    $chat = new ChatModel($data['nick'], $data['text']);
    $chat->save();
}

if (!empty($data['func']) && $data['func'] == 'getMessages') {
    $msg = '';
    if (empty($_SERVER['chatId']) || $_SERVER['chatId'] < $id) {
        $msg = ChatModel::getChat($id);
        $_SERVER['chatId'] = ChatModel::getLastId();
    }
    $answer = ['data' => $msg, 'nextMessageId' => $_SERVER['chatId']];
    echo (json_encode($answer));
}