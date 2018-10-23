<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Pusher Test</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
    <?php 
        require __DIR__ . '/vendor/autoload.php';
        $dotenv = new Dotenv\Dotenv(__DIR__);
        $dotenv->load();
        echo "<script> var keys = {}; keys['cluster'] = '" . getenv('CLUSTER') . "';";
        echo "keys['KEY'] = '" . getenv('KEY') . "';";
        echo "keys['SECRET'] = '" . getenv('SECRET') . "';";
        echo "keys['APP_ID'] = '" . getenv('APP_ID') . "';</script>";
    ?>    
</head>

<body>
    <div class="overlay active">
        <div class="modal block-username">
            <input type="text" class="enter-message" id="username" placeholder="Your name">
            <a href="#" class="send-message" id="get-username">
                <i class="material-icons">send</i>
            </a>
        </div>
    </div>
    
    <div class="wrapper">
        <div class="chat">
            <div class="block-messages">

            </div>
            <div class="block-new-message">
                <input type="text" id="enter-message" class="enter-message">
                <a href="#" class="send-message" id="send-message">
                    <i class="material-icons">send</i>
                </a>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script>
        window.onload = function() {

            let usernameInput = document.getElementById('username'),
                getUsername = document.getElementById('get-username'),
                sendMessage  = document.getElementById('send-message'),
                enterMessage = document.getElementById('enter-message'),
                blockMessages = document.querySelector('.block-messages'),
                username;
            
            getUsername.addEventListener('click', function(e) {
                e.preventDefault();
                if (!usernameInput.value) return;
                usernameInput.closest('.overlay').classList.remove('active');
                username = usernameInput.value;
            })

            usernameInput.addEventListener('keypress', function(e) {
                if (e.keyCode === 13) {
                    getUsername.click();
                }
            })
            //Pusher.logToConsole = true;

            let pusher = new Pusher(keys['KEY'], {
                cluster: 'eu',
                forceTLS: true
            });

            var channel = pusher.subscribe('chat');
            channel.bind('new-message', function (data) {
                /* alert('ok');
                console.log('%c' + data, 'color:red'); */                
                let message = data.message;
                let templateMessage = `<div class="message">
                                        <div class="message__user">${username}</div>
                                        <div class="message__text">${message}</div>
                                        <div class="message__time"></div>
                                    </div>`;
                $(blockMessages).append(templateMessage);
                blockMessages.scrollTop = 9999;
            });

            sendMessage.addEventListener('click', function(e) {
                e.preventDefault();
                if (!enterMessage.value) return;
                let time = new Date();
                $.ajax({
                    method: 'post',
                    url: 'handler.php',
                    data: {
                        message: enterMessage.value
                    }
                })
                enterMessage.value = '';
            })

            enterMessage.addEventListener('keypress', function(e) {
                if (e.keyCode == 13) {
                    sendMessage.click();
                }
            })
        }
    </script>
</body>

</html>