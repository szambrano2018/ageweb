<html>
    <head>
        <title>Agendamiento Web</title>
        {{ HTML::style('css/w3.css', array('media' => 'screen')) }}
        {{ HTML::style('this/gentelmaster/vendors/font-awesome/css/font-awesome.min.css', array('media' => 'screen')) }}
        <!--**********************************PRUEBA DE LIBRERIAS******************-->       
        {{ HTML::style('css/bootstrap.min.css', array('media' => 'screen')) }}
        {{ HTML::script('js/jquery.min.js') }}
        {{ HTML::script('js/javascript.js') }}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css" />
        {{ HTML::script('js/2.1.4/jquery.min.js') }}
        {{ HTML::style('css/bootstrap-datepicker.min.css', array('media' => 'screen')) }}
        {{ HTML::script('js/bootstrap-datepicker.min.js') }}
    <!--AQUI FUNCIONA EL CALENDARIO -->    
    </head>
    <body>
        @section('menu')        
        @show
        <div class="navbar navbar-inverse navbar-fixed-top" style="background-color: #337ab7;"><img src="{{ asset('images/logo_online.png') }}" width="270" height="50"  style="padding-left: 120px;"></div>
        <div class="container" style="padding-top: 100px;">
            @yield('content')
        </div>
        <footer class="row" style="padding-left: 130px;padding-top: 40px;">
            © 2018 - Sistema de Agendamiento Webmedica - Singa S.A.
        </footer>
        <!-- Bootstrap -->
        {{ HTML::script('this/gentelmaster/vendors/bootstrap/dist/js/bootstrap.min.js') }}
        
    </body>
</html>

