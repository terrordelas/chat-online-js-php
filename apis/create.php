<?php
error_reporting(0);
header('Content-Type: application/json');


if (!$_POST) {
	
	header("HTTP/1.1 405");
	die( json_encode(array("code"=> 405,"message"=> "Get not supported"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );
}



if (empty($_POST['namechat'])){
	header("HTTP/1.1 400");
	die( json_encode(array("code"=> 400,"message"=> "nome do chat e invalido !"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );

}

if (empty($_POST['id'])){
	header("HTTP/1.1 400");
	die( json_encode(array("code"=> 400,"message"=> "token do usuario e invalido !"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );

}




//carrega os chats ja no criados 

$chats = json_decode(file_get_contents("../db/chats.json") , true);

$idchat = rand(000000000 , 99999999);

$chats[$idchat] = [
	"name" => $_POST['namechat'],
	"chatid" => $idchat,
	"create" => time(),
	"owner" => $_POST['id'],
	"usuarios" => [ $_POST['id'] ]
]; 

file_put_contents("../db/chats.json", json_encode( $chats,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT));


header("HTTP/1.1 200");
die( json_encode(array("code"=> 200,"message"=> "chat criado !"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );