<?php
// error_reporting(0);
header('Content-Type: application/json');


if (!$_POST) {
	
	header("HTTP/1.1 405");
	die( json_encode(array("code"=> 405,"message"=> "Get not supported"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );
}



if (empty($_POST['nome'])){
	header("HTTP/1.1 400");
	die( json_encode(array("code"=> 400,"message"=> "nome do chat e invalido !"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );

}

if (empty($_POST['avata'])){
	header("HTTP/1.1 400");
	die( json_encode(array("code"=> 400,"message"=> "avata do usuario e invalido !"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );

}

if (empty($_POST['msg'])){
	header("HTTP/1.1 400");
	die( json_encode(array("code"=> 400,"message"=> "msg do usuario e invalido !"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );

}

if (empty($_POST['chatid'])){
	header("HTTP/1.1 400");
	die( json_encode(array("code"=> 400,"message"=> "chatid e invalido !"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );

}

if (empty($_POST['token'])){
	header("HTTP/1.1 400");
	die( json_encode(array("code"=> 400,"message"=> "token do usuario e invalido !"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );

}

if (empty($_POST['cor'])){
	header("HTTP/1.1 400");
	die( json_encode(array("code"=> 400,"message"=> "cor do usuario e invalido !"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );

}


// carregas as messages salvas

$chatid = $_POST['chatid'];

$message = json_decode(file_get_contents("../db/{$chatid}.json"),true);

$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$avata = filter_input(INPUT_POST, 'avata', FILTER_SANITIZE_SPECIAL_CHARS);
$msg = filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_SPECIAL_CHARS);
$chatid = filter_input(INPUT_POST, 'chatid', FILTER_SANITIZE_SPECIAL_CHARS);
$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_SPECIAL_CHARS);
$cor = filter_input(INPUT_POST, 'cor', FILTER_SANITIZE_SPECIAL_CHARS);


$message['messages'][] = [
	"nome" => $nome , 
	"avata" => $avata, 
	"message" => $msg,
	"token" => $token,
	"cor" => $cor,
	"create" => date("d/m/Y")." as ".date("H:i"),
];


file_put_contents("../db/{$chatid}.json", json_encode( $message,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT));

header("HTTP/1.1 200");
die( json_encode(array("code"=> 200,"message"=> "msg enviada !"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );