<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- styles -->
    <link rel="stylesheet" href="{{ URL::asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{--<style>
        .rjs-cursor {
    width: 12px;
    height: 12px;
    position: fixed;      /* Fixed position.. */
    top: 0;               /* at the top left.. */
    left: 0;
    z-index: 999999;      /* above everything else. */
    pointer-events: none; /* Cant't be clicked. */
    transition: none;     /* Cursor is always accurate */
    opacity: 0; /* Hidden by default */
    transform: translate(-50%; -50%);
  }

  .rjs-cursor-icon {      /* Styling for the visible part */
    width: 100%;
    height: 100%;
    border-radius: 100%;  /* Circle */
    background-color: rgba(123, 123, 123, 0.7); /* Backup value */
    transition: all 0.2s ease;
    transform-origin: 50% 50%;
  }

  .rjs-cursor.rjs_cursor_visible { opacity: 1; }
  .rjs-cursor.rjs_cursor_hidden { opacity: 0; }

  /* Display the cursors at the correct time */
  * { cursor: none; }

  @media (pointer: none), (pointer: coarse) {
      #rjs_cursor, #rjs_cursor .rjs-cursor-icon { display: none !important; visibility: hidden; opacity: 0; }

      * { cursor: auto !important; }
  }


  /* Hover effects */
  .rjs-cursor-icon { background-color: #D90A2D; }

  .rjs-cursor-icon::after {
    content: '';
    position: absolute;
    border: #D90A2D 1px solid;
    border-radius: 100%;
    display: inline-block;
    width: 24px;
    height: 24px;
    transform: translate(-25%, -25%);
  }



  .rjs-cursor.rjs_cursor_hover .rjs-cursor-icon { transform: scale(2); }
  .rjs-cursor.rjs_cursor_hover .rjs-cursor-icon::after { opacity: 0; transform: scale(100); }




  /* The body element is required to fill the complete browser. This will be the case on almost every website that has content. Otherwise you could add this as a fallback */

    </style>--}}
    <style>

    </style>
</head>

<body>
    <div id="rjs_cursor" class="rjs-cursor">
        <div class="rjs-cursor-icon"></div>
      </div>
    @yield('content')
    {{-- <div id="app">

        <main class="">


        </main>

    </div> --}}

    <script type="javascript"src="{{ URL::asset('js/dashboard.js') }}"></script>



    {{-- <script type="module">
        import Echo from 'laravel-echo';

        Echo.channel('events')
        .listen('RealTimeMessage', (e) => console.log('RealTimeMessage: ' + e.message));
    </script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    @stack('custom-scripts')
    <script>
        function chckmsgs(){

            let request = $.ajax({
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    url: "{{url("notifications")}}",
                    type: "post",
                    data: {id : 1}
                });
                // Callback handler that will be called on success
                request.done(function (response, textStatus, jqXHR){
                    console.log(response);
                });
                request.fail(function (jqXHR, textStatus, errorThrown){
                // Log the error to the console
                console.error(
                    "The following error occurred: "+
                    textStatus, errorThrown
                    );
                });
        }
        //chckmsgs();
        //setInterval(function() {
            //chckmsgs();
        //}, 5000);
        window.laravel_echo_port='{{ env("LARAVEL_ECHO_PORT") }}';
    </script>
    <script src="//{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
    <script src="{{ url('/js/laravel-echo-setup.js') }}" type="module"></script>

    <script type="text/javascript">
        var i = 0;
        window.Echo.channel('user-channel')
        .listen('.UserEvent', (data) => {
            i++;
            $("#notification").append('<div class="alert alert-success">'+i+'.'+data.title+'</div>');
        });


</script>
</body>

</html>
