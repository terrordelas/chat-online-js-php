<?php
error_reporting(0);
// header('Content-Type: application/json');

if (empty($_GET['chatid'])){
	header("HTTP/1.1 400");
	die( json_encode(array("code"=> 400,"message"=> "chatid e invalido !"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );
}

$chatid = $_GET['chatid'];

$message = json_decode(file_get_contents("../db/{$chatid}.json"),true);


echo json_encode($message);