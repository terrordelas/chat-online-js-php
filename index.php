<?php
	
	error_reporting(0);
	session_start();


	if (isset($_GET['chatid'])){

		
		$_SESSION['open'] = $_GET['chatid'];

	}

	if (isset($_GET['nome'])){
		$_SESSION['nome'] = $_GET['nome'];
	}else{

		if (!$_SESSION['nome'] || !$_SESSION['token'] ){
			$_SESSION['openmodal'] = true;
		}
		
	}


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" />

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

  
    <link href="./lib/css/emoji.css" rel="stylesheet">

	<style type="text/css">
	/*body{
		background-color: #1c1c1c;
	}*/
	.card{
		background-color: #313235;
		color: #ffffff;
		margin-bottom: 10px;
	}

 
	.title{
		color: white;
		 
	}

	.modal-content{
		background-color: #313235;
		color: #ffffff;
	}

	.form-control{
		background-color: #313235;
		color: white;
		border: 1px solid #5e5e61;
		color: white;

	}

	.form-control:focus{
		background-color: #313235;
		color: white;
	}

	.modal-footer{
		border-top: 2px solid #5e5e61;
	}

	.modal-header{
		border-bottom: 2px solid #5e5e61;
	}



</style>


</head>
<body class="bg-dark text-white">
<br>
<div id="msgs" style=" position: absolute; padding: 10px; z-index: 99999; right: 10px;"></div>

<br>

<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']?>">
<input type="hidden" name="name" id = "nome" value="<?php echo $_SESSION['nome']?>">

<div class="container">
	

	<div class="container-fluid">
		<div class="row ">
	 		<h5 class="title">YOUR CHATS</h5>
	 		<hr class="title">
		</div>
		<div class="card" onclick="addchat()" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
	  		<div class="card-body">
	    		<h5 class="card-title">NEW CHAT <i  style="float: right; margin-top:2px; font-size: 25px;" class="fas fa-plus-circle"></i></h5>
	  		</div>
		</div>

		<div class="row">
			<?php

				//caregas os chats 

				$chats = json_decode(file_get_contents("./db/chats.json") , true);

				foreach ($chats as $idchat => $infos) {
					if (in_array($_SESSION['token'], $infos['usuarios'])){
						echo '<div class="col-sm-6"><div class="card" onclick="abrichat(`'.$idchat.'`)" ><div class="card-body"><h5 class="card-title">'.$infos['name'].'&nbsp;<i  style="float: right; margin-top:2px; font-size: 25px;" class="fas fa-arrow-right"></i></h5></div></div></div>';
					}
				}
				
			?>
		</div>
		
	</div>
</div>

<input type="hidden" id="openmodal" data-bs-toggle="modal" data-bs-target="#openuser">
<div class="modal fade" id="openuser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalsessao" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="modalcont">
     <div class="modal-header">
        <h5 class="modal-title" id="modalsessao">Inicia sessão</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalsessaobody">

		<button type="button" class="btn btn-success" onclick="login()" >entra</button>
		<button type="button" class="btn btn-primary" onclick="cadastra()" >cadastra</button>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" id="salva" onclick="salva()">salva</button>
      </div>
    </div>
  </div>
</div>

</body>

	<script src="https://kit.fontawesome.com/4b324138d1.js" ></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="./lib/js/config.js"></script>
    <script src="./lib/js/util.js"></script>
    <script src="./lib/js/jquery.emojiarea.js"></script>
    <script src="./lib/js/emoji-picker.js"></script>
	<script type="text/javascript">
		
		function addchat() {
			$("#staticBackdropLabel").text("Cria novo chat");
			$("#salva").text("Cria");
			$(".modal-body").html(`
				<form id="form">
					<input type="hidden" name="type" value="addchat">
					<input type="hidden" name="id" value="<?php echo $_SESSION['token'];?>">
					<div class="mb-3">
						<label for="namechat" class="form-label">Nome do chat</label>
						<input type="text" class="form-control" name="namechat" id="namechat" placeholder="tech checkers">
					</div>
				</form>
			`);
		}


		function salva(){

			$.ajax({
				url: "apis/create.php",
				type: "POST",
				data: $("form").serialize(),
				success:(data)=>{
					setTimeout(()=>{ window.location.reload()} , 1000);
					msgs(`${data['message']}` , "success" , "green");
				},error:(e)=>{
					msgs(`${e['responseJSON']['message']}`);
				}
			});
		}

		$("#form").submit(function(event){
			event.preventDefault();
			
		});


		function msgs(msg,title,cor){

			var id = Math.floor(Math.random() * 100);
			var idbr = Math.floor(Math.random() * 100);
			if (!title || title == '' || title == undefined || title == null || title == NaN) {title = "Erro";}else{title =title;}
			if (!cor || cor == '' || cor == undefined || cor == null || cor == NaN) {cor = "red";}else{cor =cor;}

			$("#error").fadeIn(0);	

			$('#msgs').prepend(`<div  id = '${id}'style="display: inline; padding: 10px;margin-top: 10px;border-radius: 5px;padding: 10px;background: ${cor};color: white; float: right;"><b>${title}</b></br><span id="stats">${msg}</span></div><br id="${idbr}">`);
			$(`#${id}`).fadeOut(5500,function(){document.getElementById(`${id}`).remove(); document.getElementById(`${idbr}`).remove()});

		}

		function abrichat(chatid) {
			$.ajax({
				url: "apis/open.php",
				type: "POST",
				data: { type: "openchat" , chatid: chatid},
				success:(data)=>{

					$(".container-fluid").html(data);
				},error:(e)=>{
					msgs(`${e['responseJSON']['message']}`);
				}
			});
		}

		// Verifica se o browser suporta notificações
		if (!("Notification" in window)) {
			console.log("Este browser não suporta notificações de Desktop");
		}else if (Notification.permission !== 'denied') {
			Notification.requestPermission(function (permission) {
			// If the user accepts, let's create a notification
				if (permission === "granted") {
					console.log("permission accept");
				}
			});
		}


		function login(){
			$("#modalcont").html(`<div class="modal-header"><h5 class="modal-title" id="modalsessao">Inicia sessão</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body" id="modalsessaobody"><form id="form"><input type="hidden" name="type" value="login"><div class="mb-3"><label for="name" class="form-label">usuario</label><input type="text" class="form-control" name="user" id="namen" placeholder="teste"></div><div class="mb-3"><label for="name" class="form-label">senha</label><input type="text" class="form-control" name="senha" id="namen" placeholder="teste"></div></form></div><div class="modal-footer"><button type="button" class="btn btn-primary" onclick="cadastra()">cadastra</button><button type="button" class="btn btn-success" onclick="submitlogin()">entra</button></div>`);
		}
		function cadastra(){
				$("#modalcont").html(`<div class="modal-header"><h5 class="modal-title" id="modalsessao">Inicia sessão</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body" id="modalsessaobody"><form id="form"><input type="hidden" name="type" value="cadastra"><div class="mb-3"><label for="name" class="form-label">Nome</label><input type="text" class="form-control" name="nome" id="namen" placeholder="terrordelas"></div><div class="mb-3"><label for="name" class="form-label">usuario</label><input type="text" class="form-control" name="user" id="namen" placeholder="teste"></div><div class="mb-3"><label for="name" class="form-label">senha</label><input type="text" class="form-control" name="senha" id="namen" placeholder="teste"></div></form></div><div class="modal-footer"><button type="button" class="btn btn-success" onclick="login()" >entra</button><button type="button" class="btn btn-primary" onclick="submitlogin()" >cadastra</button></div>`);
			

		}
		
		function submitlogin(){
			$.ajax({
				url: "apis/auth.php",
				type: "POST",
				data: $("#form").serialize(),
				success:(data)=>{
					setTimeout(()=>{ window.location.reload()} , 1000);
					msgs(`${data['message']}` , "success" , "#5cb85c");
				},error:(e)=>{
					msgs(`${e['responseJSON']['message']}`);
				}
			});
		}

	</script>

	<?php if($_SESSION['open']):?>
		<script type="text/javascript">
			abrichat('<?php echo $_SESSION["open"]?>');
		</script>
	<?php endif; unset($_SESSION['open'])?>

	<?php if($_SESSION['openmodal']):?>
		<script type="text/javascript">
			$("#openmodal").click();
		</script>
	<?php endif; unset($_SESSION['openmodal']);?>



</html>

