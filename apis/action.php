<?php 



$chatid = $_GET['chatid'];
$token = $_GET['token'];

$chats = json_decode(file_get_contents("../db/{$chatid}.json") , true);

$chats['action'] = array(
 
	"msg" => $_GET['action'],
	"token" => $token,
	"time" => strtotime("+1 minutes"),
);

file_put_contents("../db/{$chatid}.json", json_encode($chats,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT));

echo json_encode(["message" => "ok"]);