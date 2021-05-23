<?php


$chatid = $_GET['chatid'];

$chats = json_decode(file_get_contents("../db/{$chatid}.json") , true);

unset($chats['action']);

file_put_contents("../db/{$chatid}.json", json_encode($chats,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT));

echo json_encode(["message" => "ok"]);