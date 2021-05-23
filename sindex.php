<!DOCTYPE html>
<html>
<head>
	<title></title>


  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="./lib/css/emoji.css" rel="stylesheet">

</head>
<body>
	<button type="button" onclick= "newno()"id="btn_push">Push Notification &#128512;</button>

	<div class="container">
      <div class="row justify-content-center">
        <div class="col-10">
          <div class="text-left">
            <p class="lead emoji-picker-container">
              <input type="email" class="form-control" placeholder="Input field" data-emojiable="true">
            </p>
            <p class="lead emoji-picker-container">
              <input type="email" class="form-control" placeholder="Input with max length of 10" data-emojiable="true" maxlength="10">
            </p>
            <p class="lead emoji-picker-container">
              <textarea class="form-control textarea-control" rows="3" placeholder="Textarea with emoji image input" data-emojiable="true"></textarea>
            </p>
            <p class="lead emoji-picker-container">
              <textarea class="form-control textarea-control" rows="3" placeholder="Textarea with emoji Unicode input" data-emojiable="true" data-emoji-input="unicode"></textarea>
            </p>
          </div>
        </div>
      </div>

</body>

 <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Begin emoji-picker JavaScript -->
    <script src="./lib/js/config.js"></script>
    <script src="./lib/js/util.js"></script>
    <script src="./lib/js/jquery.emojiarea.js"></script>
    <script src="./lib/js/emoji-picker.js"></script>


 <script>
      $(function() {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: '../lib/img/',
          popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
      });
    </script>


<script type="text/javascript">


 // Verifica se o browser suporta notificações
  if (!("Notification" in window)) {
    alert("Este browser não suporta notificações de Desktop");
  }else if (Notification.permission !== 'denied') {
    Notification.requestPermission(function (permission) {
      // If the user accepts, let's create a notification
      if (permission === "granted") {
        // var notification = new Notification("Hi there!");
        console.log("ok");
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
}

</script>
</html>