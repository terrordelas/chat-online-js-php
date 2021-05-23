<?php

if ($_GET['type'] == "altercor"){
	$chatid = $_GET['chatid'];
	$chats = json_decode(file_get_contents("../db/{$chatid}.json") , true);

	foreach ($chats['messages'] as $key => $value) {
		if ($value['token'] == $_GET['user']){
			$chats['messages'][$key]['cor'] = $_GET['cor'];
		}
	}

	file_put_contents("../db/{$chatid}.json", json_encode( $chats,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT));

}

if ($_GET['type'] == "alterav"){
	$chatid = $_GET['chatid'];
	$chats = json_decode(file_get_contents("../db/{$chatid}.json") , true);

	foreach ($chats['messages'] as $key => $value) {
		if ($value['token'] == $_GET['user']){
			$chats['messages'][$key]['avata'] = $_GET['avata'];
		}
	}

	file_put_contents("../db/{$chatid}.json", json_encode( $chats,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT));

}