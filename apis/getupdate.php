<?php

error_reporting(0);

if (empty($_GET['chatid'])){
	die("error na api");
}

$chatid = $_GET['chatid'];
$chats = json_decode(file_get_contents("../db/{$chatid}.json") , true);

if ($chats['action']){
	$action[] =  $chats['action'];
}else{
	$action = [];
}


$sizeof = sizeof(($chats['messages']) ? $chats['messages'] : []);

die(json_encode(array("key" => $sizeof-1 , "obj" => $chats['messages'][$sizeof -1] , "action" => $action)));