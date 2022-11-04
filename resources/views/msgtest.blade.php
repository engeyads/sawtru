@extends('home')


@section('articles')


        <div class="container">
            <div class="row chat-row">
                <div class="chat-content">
                    <ul></ul>
                </div>

                <div class="chat-section">
                    <div class="chat-box">
                        <div class="chat-input bg-primary" id="chatInput" contenteditable="">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.socket.io/4.0.1/socket.io.min.js" integrity="sha384-LzhRnpGmQP+lOvWruF/lgkcqD+WDVt9fU3H4BWmwP5u5LTmkUGafMcpZKNObVMLU" crossorigin="anonymous"></script>

        <script>
            $(function() {
                let ip_address = 'sawtru.dev';
                let socket_port = '3000';
                let socket = io(ip_address + ':' + socket_port);

                let chatInput = $('#chatInput');

                chatInput.keypress(function(e) {
                    let message = $(this).html();
                    if(e.which === 13 && !e.shiftKey) {
                        socket.emit('sendChatToServer', message);
                        chatInput.html('');
                        return false;
                    }
                });

                socket.on('sendChatToClient', (message) => {
                    $('.chat-content ul').append(`<li>${message}</li>`);
                });
            });
        </script>
@endsection
