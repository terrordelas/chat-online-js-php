

window.addEventListener('blur', newno);
		window.addEventListener('pagehide', newno);

		if (!("Notification" in window)) {
			alert("Este browser não suporta notificações de Desktop");
		}else if (Notification.permission !== 'denied') {
			Notification.requestPermission(function (permission) {

				if (permission === "granted") {

					console.log("not active");

				}
			});
		}


		function spawnNotification(opcoes) {
			var n = new Notification(opcoes.title, opcoes.opt);

			if (opcoes.link !== '') {
				n.addEventListener("click", function() {               
				    n.close();
				    window.focus();
				    window.location.href = opcoes.link;
				});
			}
		}

		function newno() {
			spawnNotification({
			opt: {
				body: "Criando nova notificação",
				icon: "notification-flat.png"
				},
				title: "Olá mundo!",
				link: "https://www.google.com.br/"
			})

			console.log("fui chamando ");
		}


	$.ajax({

		url: "./api.php",
		type: "GET",
		data:{
			type: "getallmessage",
			chatid: $("#chatid").val()
		},success:function(data){
			data = JSON.parse(data);
			try{
				data['messages'].forEach(function(obj , index , array){
				$("#id_message").val(index);

				

				if ($("#id_user").val() == obj['id_user']){
					
					$("#msgs").css({
						"height": "500px"
					});

					if (!obj['cor'] ){
						$("#cor").val(cor)
					}else{
						cor = obj['cor'];
						$("#cor").val(cor)
					}

					$('#avata').val(`${obj['avata']}`);

					$("#msgs").append(`<div class="inmsg"><div class="imguserIN" style="background: url('${obj['avata']}');"></div><br><div class="teste_${obj['id_user']}"><span class="fromIn">From: ${obj['nome']}</span><br><div class="inmsgText">${obj['message']}</div><span class="dateInMessageText">${obj['create']}</span></div><span></span></div><br><br><br><br>`);
					// window.scroll(0,$('#btn').offset().top);
					$("#msgs").animate({scrollTop: $('#msgs').offset().top +9000});

					$('#stylechatin').html(`.teste_${obj['id_user']}{background-color: ${cor}; margin-top: 10px;margin-left: 25%;color: white;padding: 5px;float: right;width: 50% auto;border-radius: 3.5px 5px 5px 5px;}.teste_${obj['id_user']}:before {content: "";display: inline-block;vertical-align: top;margin-right: 0px;margin-top: -15px;margin-left: 94.6%;float:right;margin-right: 8px;width: 0; height: 0; border-radius: 0px 0px 1px 1px; border-left: 10px solid transparent;border-right: 10px solid transparent; border-bottom: 11px solid ${cor};}`);


				}else{
		
					$("#msgs").css({
						"height": "500px"
					});

					
					cor = obj['cor'];
					
					

					$('#stylechatout').append(`.out_${obj['id_user']}{background-color: ${cor}; margin-top: 10px;width: 100%;margin-right: 35%;color: white;padding: 5px;border-radius: 3.5px 5px 5px 5px;}.out_${obj['id_user']}:before {content: "";display: inline-block;vertical-align: top;margin-right: 0px;margin-top: -15px;margin-left: 1px;float:left;margin-left: 8px;width: 0; height: 0; border-radius: 0px 0px 1px 1px;border-left: 10px solid transparent;border-right: 10px solid transparent;border-bottom: 10px solid ${cor};}`);

					$("#msgs").append(`<div class="outmsg"><div class="imguser" style="background: url('${obj['avata']}');"></div><br><div class="out_${obj['id_user']}"><br><span class=	"fromOut">From: ${obj['nome']}</span><br><div class="outmsgText">${obj['message']}</div><span class="dateOutMessageText">${obj['create']}</span><br></div></div><br>`);
					// window.scroll(0,$('#btn').offset().top);
					$("#msgs").animate({scrollTop: $('#msgs').offset().top +9000});
					// $("#stylechatout").html('');
					
				}
			});

			}catch(e){

				var today1 = new Date();
				var dd = String(today1.getDate()).padStart(2, '0');
				var mm = String(today1.getMonth() + 1).padStart(2, '0');
				var yyyy = today1.getFullYear();
				var today = mm + '/' + dd + '/' + yyyy;
				var ano4    = today1.getFullYear();
				var hora    = today1.getHours();          
				var min     = today1.getMinutes();   

				$("#msgs").css({
					"height": "200px"
				});

				$('#stylechatout').append(`.seta-cima{background-color: #0ce3f2; margin-top: 10px;width: 100%;margin-right: 35%;color: white;padding: 5px;border-radius: 3.5px 5px 5px 5px;}.seta-cima:before {content: "";display: inline-block;vertical-align: top;margin-right: 0px;margin-top: -15px;margin-left: 1px;float:left;margin-left: 8px;width: 0; height: 0; border-radius: 0px 0px 1px 1px;border-left: 10px solid transparent;border-right: 10px solid transparent;border-bottom: 10px solid #0ce3f2;}`);

				$("#msgs").append(`<div class="outmsg"><div class="imguser" style="background: url('https://avatars.dicebear.com/api/bottts/hfghfggghfff.svg');"></div><br><div class="seta-cima"><br><span class="fromOut">From: BOT</span><br><div class="outmsgText">Ainda não a mensagens!</div><span class="dateOutMessageText">${today} as ${hora}:${min}</span><br></div></div><br>`);
				
				$("#msgs").animate({scrollTop: $('#msgs').offset().top +9000});
			}
		}
	});	

	setInterval(function(){
		console.log("Get Updates msgs");

		var cores = ["#f03c3c", "#db1db2" , "#08c4b5" , "#b5b20d" , "rgb(111 66 193)", "rgb(13 110 253)" , "rgb(102 16 242)","rgb(253 126 20)" ,"rgb(13 202 240)" , "rgb(32 201 151)"
		];

		const random = Math.floor(Math.random() * cores.length);
		var cor = cores[random];

		try{
			$.ajax({

			url: "./api.php",
			type: "GET",
			data:{
				type: "getupdate",
				chatid: $("#chatid").val()
			},success:function(data){
				try{
					data = JSON.parse(data);
				}catch(e){
					return;
				}

				if (data['action'].length != 0){
					

					if (data['action'][0]['id_user'] != $("#id_user").val()){
						console.log("new action");
						$(".action").remove();
						$("#msgs").append(`<div class="action" style="display: inline-flex; padding: 16px;"> ${data['action'][0]['nome']} escrevendo &nbsp;<span id="point1" ></span><span id="point2" ></span><span id="point3" > </span></div>`);
						$("#msgs").animate({scrollTop: $('#msgs').offset().top +9000});
						animattionpoints();
						var it = setTimeout(function(){
							$(".action").remove();
							removeaction()
						},2000);
					}
				}

				if (data['key'] == $("#id_message").val()){
					return;
				}else{

					if (data['obj']['id_user'] == $("#id_user").val()){
						return;
					}else{
						removeaction()
						$("#id_message").val(data['key']);

						var obj = data['obj'];

						$("#msgs").css({
							"height": "500px"
						});

						cor = obj['cor'];

						$(".action").remove();

						$("#msgs").append(`<div class="outmsg"><div class="imguser" style="background: url('${obj['avata']}');"></div><br><div class="out_${obj['id_user']}"><br><span class="fromOut">From: ${obj['nome']}</span><br><div class="outmsgText">${obj['message']}</div><span class="dateOutMessageText">${obj['create']}</span><br></div></div><br>`);
						$("#msgs").animate({scrollTop: $('#msgs').offset().top +9000});
						$('#stylechatout').append(`.out_${obj['id_user']}{background-color: ${cor}; margin-top: 10px;width: 100%;margin-right: 35%;color: white;padding: 5px;border-radius: 3.5px 5px 5px 5px;}.out_${obj['id_user']}:before {content: "";display: inline-block;vertical-align: top;margin-right: 0px;margin-top: -15px;margin-left: 1px;float:left;margin-left: 8px;width: 0; height: 0; border-radius: 0px 0px 1px 1px;border-left: 10px solid transparent;border-right: 10px solid transparent;border-bottom: 10px solid ${cor};}`);

					}

					
				}
			}
			});	
		}catch(e){
			console.log("sem novas msgs");
		}

	} , 1000 );


	function enviamsg() {


		if ($('#textarea').val() == '' ){
			console.log("msg is empty");
			return;
		}

		if ($('#nome').val() == ""){
			alert("Por favor , ultilize um nome !");
			$("html,body").animate({scrollTop: $('#nome').offset().top -1000});
			return;
		}

		var msg = $('#textarea').val();
		$('#textarea').val('');

		var cores = ["#f03c3c", "#db1db2" , "#08c4b5" , "#b5b20d" , "rgb(111 66 193)", "rgb(13 110 253)" , "rgb(102 16 242)","rgb(253 126 20)" ,"rgb(13 202 240)" , "rgb(32 201 151)"
		];

		const random = Math.floor(Math.random() * cores.length);
		var cor = cores[random];

   		var nome = $("#nome").val();
   		var avata = $("#avata").val();

		var today1 = new Date();
		var dd = String(today1.getDate()).padStart(2, '0');
		var mm = String(today1.getMonth() + 1).padStart(2, '0'); //January is 0!
		var yyyy = today1.getFullYear();

		var today = mm + '/' + dd + '/' + yyyy;
		var ano4    = today1.getFullYear();
		var hora    = today1.getHours();          
		var min     = today1.getMinutes();     

		var id_user = $('#id_user').val();

		$("#msgs").css({
			"height": "500px"
		});

		$("#msgs").append(`<div class="inmsg"><div class="imguserIN" style="background: url('${avata}');"></div><br><div class="in_${id_user}"><span class="fromIn">From: ${nome}</span><br><div class="inmsgText">${msg}</div><span class="dateInMessageText">${today} as ${hora}:${min}</span></div><span></span></div><br><br><br><br>`);

		if ($("#cor").val() == 0){
			$("#cor").val(cor);
		}else{
			var cor = $("#cor").val();
		}

		$('#stylechatin').append(`.in_${id_user}{background-color: ${cor}; margin-top: 10px;margin-left: 25%;color: white;padding: 5px;float: right;width: 50% auto;border-radius: 3.5px 5px 5px 5px;}.in_${id_user}:before {content: "";display: inline-block;vertical-align: top;margin-right: 0px;margin-top: -15px;margin-left: 94.6%;float:right;margin-right: 8px;width: 0; height: 0; border-radius: 0px 0px 1px 1px; border-left: 10px solid transparent;border-right: 10px solid transparent; border-bottom: 11px solid ${cor};}`);

		$.ajax({
			url: "./api.php",
			data:{
				nome: nome,
				avata: avata,
				msg: msg,
				chatid: $("#chatid").val(),
				type: "addmsg",
				id_user: $('#id_user').val(),
				cor: $("#cor").val()
			},
			async: true
			,sucess:function(){
				console.log("msg add");
			}
		});

		// window.scroll(20,$('#msgs').offset().top -20);
		$("#msgs").animate({scrollTop: $('#msgs').offset().top +9000});
	}


	function addaction(){

		if ($('#nome').val() == ""){
			alert("Por favor , ultilize um nome !");
			$("html,body").animate({scrollTop: $('#nome').offset().top -1000});
			return;
		}

		$.ajax({
			url: "./api.php",
			data:{
				type: "addaction",
				chatid: $("#chatid").val(),
				nome: $("#nome").val(),
				id_user: $('#id_user').val(),

				action: "escrevendo"
			},
			async: true
			,sucess:function(){

			}
		});
	}

	function removeaction(){
		if ($('#nome').val() == ""){
			alert("Por favor , ultilize um nome !");
			$("html,body").animate({scrollTop: $('#nome').offset().top -1000});
			return;
		}

		$.ajax({
			url: "./api.php",
			data:{
				type: "removeaction",
				chatid: $("#chatid").val(),

			},
			async: true
			,sucess:function(){

			}
		});
	}


function animattionpoints(){
	
	// var cor = $("#cor").val();

    setTimeout(function(){
       $(`#point1`).css({
        "margin-top" : "9.5px",
        "background-color" : "#2be0da",
        "opacity": "0.1"

      });
    },100);

    setTimeout(function(){
       $(`#point2`).css({
        "margin-top" : "12px",
        "background-color" : "#2be0da",
        "opacity": "0.1"
      });
    },200);

    setTimeout(function(){
       $(`#point3`).css({
        "margin-top" : "12px",
        "background-color" : "#2be0da",
        "opacity": "0.1"
      });
    },300);

    setTimeout(function(){
       $(`#point1`).css({
        "margin-top" : "8.5px",
        "background-color" : "#2be0da",
        "opacity": "0.9"
      });
    },700);

    setTimeout(function(){
       $(`#point2`).css({
        "margin-top" : "9px",
        "background-color" : "#2be0da",
        "opacity": "0.9"
      });
    },800);

    setTimeout(function(){
       $(`#point3`).css({
        "margin-top" : "9px",
        "background-color" : "#2be0da",
        "opacity": "0.9"
      });
    },900);
    
    setTimeout(function(){
       $(`#point1`).css({
        "margin-top" : "5.5px",
        "background-color" : "#2be0da",
        "opacity": "0.5"
      });
      
    },400);

    setTimeout(function(){
       $(`#point2`).css({
        "margin-top" : "5px",
        "background-color" : "#2be0da",
        "opacity": "0.5"
      });
    },500);

    setTimeout(function(){
       $(`#point3`).css({
        "margin-top" : "5px",
        "background-color" : "#2be0da",
        "opacity": "0.5"
      });
    },600);
}