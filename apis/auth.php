<?php
error_reporting(0);
session_start();

header('Content-Type: application/json');


if (!$_POST) {
	
	header("HTTP/1.1 405");
	die( json_encode(array("code"=> 405,"message"=> "Get not supported"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );
}


if ($_POST['type'] == "login"){
	$conf = json_decode(file_get_contents("../db/users.json") , true);

	foreach ($conf as $users) {
		if ($users['usuario'] == $_POST['user']){
			if ($users['senha'] == $_POST['senha']){
				$_SESSION['token'] = $users['token'];
				$_SESSION['nome'] = $users['nome'];
				header("HTTP/1.1 200");
				die( json_encode(array("code"=> 200,"message"=> "usuario autenticado!"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );
			}else{
				header("HTTP/1.1 401");
				die( json_encode(array("code"=> 401,"message"=> "usuario / senha incorretos "),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );
			}
		}
	}

	header("HTTP/1.1 401");
	die( json_encode(array("code"=> 401,"message"=> "usuario / senha incorretos "),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );
}

if ($_POST['type'] == "cadastra") {
	// 

	$conf = json_decode(file_get_contents("../db/users.json") , true);
	foreach ($conf as $users) {
		if (trim($users['nome']) == trim($_POST['nome'])){
			header("HTTP/1.1 401");
			die( json_encode(array("code"=> 401,"message"=> "nome ja esta em uso ! "),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );
		}

		if (trim($users['usuario']) == trim($_POST['user'])){
			header("HTTP/1.1 401");
			die( json_encode(array("code"=> 401,"message"=> "usuario ja esta em uso ! "),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );
		}

	}

	

	$conf[] = [
		"nome" => $_POST['nome'],
		"usuario" => $_POST['user'],
		"senha" => $_POST['senha'],
		"token" =>  md5($_POST['user'])
	];

	$_SESSION['token'] = md5($_POST['user']);
	$_SESSION['nome'] = $_POST['nome'];

	file_put_contents("../db/users.json", json_encode( $conf ,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT));


	header("HTTP/1.1 200");
	die( json_encode(array("code"=> 200,"message"=> "usuario cadastrado !"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );

}