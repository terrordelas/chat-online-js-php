

<?php
    
    session_start();

    error_reporting(0);
    if (!$_POST) {
        header('Content-Type: application/json');
        header("HTTP/1.1 405");
        die( json_encode(array("code"=> 405,"message"=> "Get not supported"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );
    }


    $conf = json_decode(file_get_contents("../db/chats.json") , true);
    $key = $_POST['chatid'];

    if (!$conf[$key]){
        header('Content-Type: application/json');
        header("HTTP/1.1 400");

        if ($_SESSION['open']){
            unset($_SESSION['open']);
        }
        die( json_encode(array("code"=> 400,"message"=> "chat não encontrado !"),JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) );
    }

    $confchat = $conf[$key];

    if (!$_SESSION['token'] ){
        $_SESSION['openmodal'] = true;
    }

    $confss = json_decode(file_get_contents("../db/chats.json") , true);

    if (!in_array($_SESSION['token'], $confss[$key]['usuarios'])){
        $confss[$key]['usuarios'][] = $_SESSION['token'];
        $_SESSION['newuser'] = $_SESSION['token'];
        file_put_contents("../db/chats.json", json_encode( $confss ,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT));
    }


$avatas = [
    'https://avatars.dicebear.com/api/male/1.svg',
    'https://avatars.dicebear.com/api/male/2.svg',
    'https://avatars.dicebear.com/api/male/3.svg',
    'https://avatars.dicebear.com/api/male/4.svg',
    'https://avatars.dicebear.com/api/male/5.svg',

    'https://avatars.dicebear.com/api/jdenticon/1.svg',
    'https://avatars.dicebear.com/api/jdenticon/2.svg',
    'https://avatars.dicebear.com/api/jdenticon/3.svg',
    'https://avatars.dicebear.com/api/jdenticon/4.svg',
    'https://avatars.dicebear.com/api/jdenticon/5.svg',

    'https://avatars.dicebear.com/api/gridy/1.svg',
    'https://avatars.dicebear.com/api/gridy/2.svg',
    'https://avatars.dicebear.com/api/gridy/3.svg',
    'https://avatars.dicebear.com/api/gridy/4.svg',
    'https://avatars.dicebear.com/api/gridy/5.svg'
];



$avatars = $avatas[array_rand($avatas)];


?>



<style type="text/css">

    @media screen and (max-width: 995px), 
       screen and (max-height: 700px) {

        body{
            margin-top: -10px;
            margin-bottom: 50px;
        }
    }

    ::-webkit-scrollbar {
        width: 12px;
    }

    ::-webkit-scrollbar-thumb {
        -webkit-border-radius: 10px;
        border-radius: 10px;
        background: #646567; 
        -webkit-box-shadow: inset 0 0 6px #646567; 
    }


    .contentmsgchat{
        border: none;
    }   

    #contentmsgchat3{
        border: 2px solid #646567;
    }

    #textarea{
        border: 2px solid #646567;
    }

    

    .outmsg{
        
        display: inline-block;
    }

    .outmsgText{
        margin-top: -15px;
        margin-left: 9px;
        margin-right: 9px;
    }

    .dateOutMessageText{
        font-size: 12px;
        float: right;
        color: black;
        margin-top: 6px;
        /*margin-bottom: 10px;*/
    }


    .imguser{
        width: 20px;
        height: 20px;
        /*border: 1px solid purple;*/
        float:left;
        margin-left: 13px;
        border-radius: 10px;
    }

    
    .fromOut{
        font-size: 12px;
        float: left;
        margin-top: -20px;
        margin-right: 4px;
        margin-left: 4px;
        color: black;
        
    }



    .imguserIN{
        
        width: 20px;
        height: 20px;
        position: relative;
        right: 0;
        margin-right: 12px;
        float:right;
        border-radius: 10px;
    }

    
    .inmsgText{
        margin-left: 9px;
        margin-right: 9px;
        margin-top: 2px;
        margin-bottom: 2px;
    }

    .dateInMessageText{
        font-size: 12px;
        /*margin-left: 75%;*/
        float: right;
        color: black;
        margin-right: 3px;
    }

    .fromIn{
        font-size: 12px;
        color: black;
        float: left;
        margin-left: 10px;
    }

        #point1{
    
    border-radius: 90%;
    background: url('https://imagepng.org/wp-content/uploads/2017/10/circulo-preto.png');
    background-color: transparent;
    margin-left: 1px;
    margin-top: 10px;
    width: 10px;
    height: 10px;
 
    
}

#point2{
    
    border-radius: 90%;
    background: url('https://imagepng.org/wp-content/uploads/2017/10/circulo-preto.png');
    background-color: transparent;
 
    margin-top: 10px;
    margin-left: 1px;
    width: 10px;
    height: 10px;

    
}

#point3{
    
    border-radius: 90%;
    background: url('https://imagepng.org/wp-content/uploads/2017/10/circulo-preto.png');
    background-color: transparent;
    margin-top: 10px;
    margin-left: 1px;
    width: 10px;
    height: 10px;

    
}

.conf{
    background-color: #212529;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 5px;

}
</style>

<style type="text/css" id="stylechatin">


</style>

<style type="text/css" id="stylechatout">


</style>


<div class="modal fade" id="menuconf" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content" id="modalcontentconf">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confs</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modejfd">

            <div class="conf" onclick="altercor()">cor da msg</div>

            <div class="conf" onclick="alterav()" >avata</div>

            <div class="conf" onclick="(()=>{
                
                var url_atual = window.location.href;

                var url = url_atual.split('?')[0] ? url_atual.split('?')[0] : url_atual;
                var chatid = $('#chatid').val();
                $('#modejfd').html(`<div class='conf'>${url}?chatid=${chatid}</div>`);
            })()">Link</div>
            

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="(()=>{window.location.reload()})()" data-bs-dismiss="modal">fecha</button>
        <!-- <button type="button" class="btn btn-success">salva</button> -->
      </div>
    </div>
  </div>
</div>


<div class="row" style="background-color: #313235; color: #ffffff; padding: 10px; border-radius: 10px;">
    <h5><?php echo strtoupper($confchat['name'])?>&nbsp;<i style="float: right; margin-left: -5px;" data-bs-toggle="modal" data-bs-target="#menuconf" class="fas fa-cogs"></i></h5>
    <hr style="width: 95%">
    <input type="hidden" name="chatid" id="chatid" value="<?php echo $key?>">
    <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']?>">
    <input type="hidden" name="cor" id="cor" value="0">
    <input type="hidden" name="avata" id="avata" value="<?php echo $avatars;?>">
    <input type="hidden" name="id_message" id="id_message">
    <div class="card contentmsgchat" >
            <div class="card-body" >
                
                <div class="card mb-3" id="contentmsgchat3" >

                    <div class="card-body mensagens" id="msgchat" style="height: 500px; overflow-x: auto;"></div>

                </div>

                    
                    
                <div style="display: flex;">

                    <textarea id="textarea" class="form-control"  onkeypress="addaction('<?php echo $_SESSION['nome']?> esta escrevendo')" rows="1" placeholder="Escreve mensagem" aria-label="Escreve mensagem" aria-describedby="basic-addon1"></textarea>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-success" id = "btn" onclick="enviamsg()">envia</button>
                </div>
                    
            </div>
            
        </div>

</div>

<script type="text/javascript">
    if ($('nome') == ""){
        $("#openmodal").click();
    }   
</script>

<script type="text/javascript">

    var cores = ["#f03c3c", "#db1db2" , "#08c4b5" , "#b5b20d" , "rgb(111 66 193)", "rgb(13 110 253)" , "rgb(102 16 242)","rgb(253 126 20)" ,"rgb(13 202 240)" , "rgb(32 201 151)"
        ];

        const random = Math.floor(Math.random() * cores.length);
        var cor = cores[random];
        

    function loop(){
        intva = setInterval(function(){

        var cores = ["#f03c3c", "#db1db2" , "#08c4b5" , "#b5b20d" , "rgb(111 66 193)", "rgb(13 110 253)" , "rgb(102 16 242)","rgb(253 126 20)" ,"rgb(13 202 240)" , "rgb(32 201 151)"
        ];

        const random = Math.floor(Math.random() * cores.length);
        var cor = cores[random];

        try{
        $.ajax({

        url: "apis/getupdate.php",
        type: "GET",
        data:{
            chatid: $("#chatid").val()
        },success:function(data){
            try{
                data = JSON.parse(data);
            }catch(e){
                return;
            }

            if (data['action'].length != 0){
                

                if (data['action'][0]['token'] != $("#token").val()){
                    $(".action").remove();
                    $("#msgchat").append(`<div class="action" style="display: inline-flex; padding: 16px;"> ${data['action'][0]['msg']} &nbsp;<span id="point1" ></span><span id="point2" ></span><span id="point3" > </span></div>`);
                    // $("#msgchat").animate({scrollTop: $('#msgchat').offset().top +9000});
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

                if (data['obj']['token'] == $("#token").val()){
                    return;
                }else{
                    removeaction();
                    $("#id_message").val(data['key']);

                    var obj = data['obj'];

                    $("#msgchat").css({
                        "height": "500px"
                    });

                    cor = obj['cor'];

                    $(".action").remove();

                    $("#msgchat").append(`<div class="outmsg"><div class="imguser" style="background: url('${obj['avata']}');"></div><br><div class="out_${obj['token']}"><br><span class="fromOut">From: ${obj['nome']}</span><br><div class="outmsgText">${obj['message']}</div><span class="dateOutMessageText">${obj['create']}</span><br></div></div><br>`);
                    $("#msgchat").animate({scrollTop: $('#msgchat').offset().top +9000});
                    $('#stylechatout').append(`.out_${obj['token']}{background-color: ${cor}; margin-top: 10px;width: 100%;margin-right: 35%;color: white;padding: 5px;border-radius: 3.5px 5px 5px 5px;}.out_${obj['token']}:before {content: "";display: inline-block;vertical-align: top;margin-right: 0px;margin-top: -15px;margin-left: 1px;float:left;margin-left: 8px;width: 0; height: 0; border-radius: 0px 0px 1px 1px;border-left: 10px solid transparent;border-right: 10px solid transparent;border-bottom: 10px solid ${cor};}`);

                }

                
            }
        }
        }); 
        }catch(e){
            console.log("sem novas msgs");
        }

        } , 1000 );
    }

    $.ajax({

        url: "apis/message.php",
        type: "GET",
        data:{
            type: "getallmessage",
            chatid: $("#chatid").val()
        },success:function(data){
            data = JSON.parse(data);
            try{
                data['messages'].forEach(function(obj , index , array){
                $("#id_message").val(index);

                

                if ($("#token").val() == obj['token']){
                    
                    $("#msgchat").css({
                        "height": "500px"
                    });

                    if (!obj['cor'] ){
                        $("#cor").val(cor)
                    }else{
                        cor = obj['cor'];
                        $("#cor").val(cor)
                    }

                    $('#avata').val(`${obj['avata']}`);

                    $("#msgchat").append(`<div class="inmsg"><div class="imguserIN" style="background: url('${obj['avata']}');"></div><br><div class="teste_${obj['token']}"><span class="fromIn">From: ${obj['nome']}</span><br><div class="inmsgText">${obj['message']}</div><span class="dateInMessageText">${obj['create']}</span></div><span></span></div><br><br><br><br>`);
                    // window.scroll(0,$('#btn').offset().top);
                    $("#msgchat").animate({scrollTop: $('#msgchat').offset().top +9000});

                    $('#stylechatin').html(`.teste_${obj['token']}{background-color: ${cor}; margin-top: 10px;margin-left: 25%;color: white;padding: 5px;float: right;width: 50% auto;border-radius: 3.5px 5px 5px 5px;}.teste_${obj['token']}:before {content: "";display: inline-block;vertical-align: top;margin-right: 0px;margin-top: -15px;margin-left: 94.6%;float:right;margin-right: 8px;width: 0; height: 0; border-radius: 0px 0px 1px 1px; border-left: 10px solid transparent;border-right: 10px solid transparent; border-bottom: 11px solid ${cor};}`);

                    loop();

                }else{
        
                    $("#msgchat").css({
                        "height": "300px"
                    });

                    
                    cor = obj['cor'];
                    
                    

                    $('#stylechatout').append(`.out_${obj['token']}{background-color: ${cor}; margin-top: 10px;width: 100%;margin-right: 35%;color: white;padding: 5px;border-radius: 3.5px 5px 5px 5px;}.out_${obj['token']}:before {content: "";display: inline-block;vertical-align: top;margin-right: 0px;margin-top: -15px;margin-left: 1px;float:left;margin-left: 8px;width: 0; height: 0; border-radius: 0px 0px 1px 1px;border-left: 10px solid transparent;border-right: 10px solid transparent;border-bottom: 10px solid ${cor};}`);

                    $("#msgchat").append(`<div class="outmsg"><div class="imguser" style="background: url('${obj['avata']}');"></div><br><div class="out_${obj['token']}"><br><span class=  "fromOut">From: ${obj['nome']}</span><br><div class="outmsgText">${obj['message']}</div><span class="dateOutMessageText">${obj['create']}</span><br></div></div><br>`);
                    // window.scroll(0,$('#btn').offset().top);
                    $("#msgchat").animate({scrollTop: $('#msgchat').offset().top +9000});
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

                $("#msgchat").css({
                    "height": "200px"
                });

                $('#stylechatout').append(`.seta-cima{background-color: #0ce3f2; margin-top: 10px;width: 100%;margin-right: 35%;color: white;padding: 5px;border-radius: 3.5px 5px 5px 5px;}.seta-cima:before {content: "";display: inline-block;vertical-align: top;margin-right: 0px;margin-top: -15px;margin-left: 1px;float:left;margin-left: 8px;width: 0; height: 0; border-radius: 0px 0px 1px 1px;border-left: 10px solid transparent;border-right: 10px solid transparent;border-bottom: 10px solid #0ce3f2;}`);

                $("#msgchat").append(`<div class="outmsg"><div class="imguser" style="background: url('https://avatars.dicebear.com/api/bottts/hfghfggghfff.svg');"></div><br><div class="seta-cima"><br><span class="fromOut">From: BOT</span><br><div class="outmsgText">Ainda não a mensagens!</div><span class="dateOutMessageText">${today} as ${hora}:${min}</span><br></div></div><br>`);
                
                // $("#msgchat").animate({scrollTop: $('#msgchat').offset().top +9000});
            }
        }
    }); 

    function enviamsg() {

            try{
                if (intva){
                    console.log("loop on ativo");
                }
            }catch{
                loop()
            }
            

            if ($('#textarea').val() == '' ){
                console.log("msg is empty");
                return;
            }

            if ($('#nome').val() == ""){

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

            var token = $('#token').val();

            $("#msgchat").css({
                "height": "500px"
            });

            $("#msgchat").append(`<div class="inmsg"><div class="imguserIN" style="background: url('${avata}');"></div><br><div class="in_${token}"><span class="fromIn">From: ${nome}</span><br><div class="inmsgText">${msg}</div><span class="dateInMessageText">${today} as ${hora}:${min}</span></div><span></span></div><br><br><br><br>`);

            if ($("#cor").val() == 0){
                $("#cor").val(cor);
            }else{
                var cor = $("#cor").val();
            }

            $('#stylechatin').append(`.in_${token}{background-color: ${cor}; margin-top: 10px;margin-left: 25%;color: white;padding: 5px;float: right;width: 50% auto;border-radius: 3.5px 5px 5px 5px;}.in_${token}:before {content: "";display: inline-block;vertical-align: top;margin-right: 0px;margin-top: -15px;margin-left: 94.6%;float:right;margin-right: 8px;width: 0; height: 0; border-radius: 0px 0px 1px 1px; border-left: 10px solid transparent;border-right: 10px solid transparent; border-bottom: 11px solid ${cor};}`);

            $.ajax({
                url: "apis/send.php",
                type: "POST",
                data:{
                    nome: nome,
                    avata: avata,
                    msg: msg,
                    chatid: $("#chatid").val(),
                    token: $('#token').val(),
                    cor: $("#cor").val()
                },
                async: true
                
            });

            $("#msgchat").animate({scrollTop: $('#msgchat').offset().top +9000});
        }

        function addaction(msg){
            $.ajax({url: "apis/action.php",data:{chatid: $("#chatid").val(),token: $('#token').val(),action: msg},async: true});
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

function removeaction(){
    $.ajax({url: "apis/removeaction.php",data:{type: "removeaction",chatid: $("#chatid").val()},async: true});
}



</script>

<?php if($_SESSION['newuser']):?>
    <script type="text/javascript">addaction("novo usuario entrou no chat ! <?php $_SESSION['nome']?>")</script>
<?php endif; unset($_SESSION['newuser'])?>

<script type="text/javascript">

    $(document).on('keyup', 'textarea', function(event) {   
    if (event.which == 13) {
         if(event.shiftKey){
             console.log('Quebra de linha');
         }else{
            if (detectmob() == false){
                enviamsg()
            }
        }
    }
});

    function detectmob() { 
        if( navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i) ){ return true; } else { return false; } }


    function altercor(){

         var cores = ["#f03c3c", "#db1db2" , "#08c4b5" , "#b5b20d" , "rgb(111 66 193)", "rgb(13 110 253)" , "rgb(102 16 242)","rgb(253 126 20)" ,"rgb(13 202 240)" , "rgb(32 201 151)"
                ];

        var html = '';
        for (var i = 0; i < cores.length; i++) {
            corindex = cores[i];
            // console.log(corindex);
            html += `<div class="col-1" ><div onclick="setcor('${corindex}')" style="background-color: ${corindex}; padding: 18px; padding-left:12px; border-radius: 100%;"></div> </div>&nbsp;`;
        }

        $("#modalcontentconf").html(`<div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Confs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>&nbsp;&nbsp;&nbsp;&nbsp;click na cor que voce deseja usa</h5><br>
                <div class="row">&nbsp;&nbsp;&nbsp;&nbsp;
                   ${html}
                </div>
                <br>
            </div>
            
            </div>`);
    }


    function setcor(cor){

        $("#modalcontentconf").html("")
        $.ajax({url: "apis/alter.php",data:{type: "altercor",chatid: $("#chatid").val() , cor: cor , user: $("#token").val()},async: true, success:()=>{window.location.reload();}});

    }

    function alterav(){
        var avatars = ['https://avatars.dicebear.com/api/male/1.svg','https://avatars.dicebear.com/api/male/2.svg','https://avatars.dicebear.com/api/male/3.svg','https://avatars.dicebear.com/api/male/4.svg','https://avatars.dicebear.com/api/male/5.svg','https://avatars.dicebear.com/api/jdenticon/1.svg','https://avatars.dicebear.com/api/jdenticon/2.svg','https://avatars.dicebear.com/api/jdenticon/3.svg','https://avatars.dicebear.com/api/jdenticon/4.svg','https://avatars.dicebear.com/api/jdenticon/5.svg','https://avatars.dicebear.com/api/gridy/1.svg','https://avatars.dicebear.com/api/gridy/2.svg','https://avatars.dicebear.com/api/gridy/3.svg','https://avatars.dicebear.com/api/gridy/4.svg','https://avatars.dicebear.com/api/gridy/5.svg'];

        var html = '';
        for (var i = 0; i < avatars.length; i++) {
            avata = avatars[i];
            // console.log(corindex);
            html += `<div class="col-1" ><div onclick="setavata('${avata}')" style="background: url('${avata}'); width:40px; height:40px; margin-bottom: 5px; border-radius: 100%;"></div> </div>&nbsp;`;
        }

        $("#modalcontentconf").html(`<div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Confs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>&nbsp;&nbsp;&nbsp;&nbsp;click no avata que voce deseja usa</h5><br>
                <div class="row">&nbsp;&nbsp;&nbsp;&nbsp;
                   ${html}
                </div>
                <br>
            </div>
            
            </div>`);


    }

    function setavata(a){

        $("#modalcontentconf").html("")
        $.ajax({url: "apis/alter.php",data:{type: "alterav",chatid: $("#chatid").val() , avata: a , user: $("#token").val()},async: true, success:()=>{window.location.reload();}});

    }
</script>