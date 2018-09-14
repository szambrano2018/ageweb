<html>
    <body>
        <style type='text/css'>

            #container{ text-align:center;
                        width: 800px;
                        border: 1px #000000 solid;

            }

            .contenido{
                font-family: Arial,Helvetica,Sans-serif;
                font-size: 14px;
                text-aling: justify;
            }
            .red {
                color:red;
                font-family: Arial,Helvetica,Sans-serif;
                font-size: 16px;

            }

            .write {
                font-size:16px; 
                font-family:Arial, Helvetica, sans-serif; 
                text-align:center; 
                color:#FFF;

            }       
            #footer {  
                border: 1px #000000 solid;


            }	
            .primera{
                font-family: Arial,Helvetica,Sans-serif;
                font-size: 14px;
                text-align: left;
                color:#000000;
            } 
            .footer{ text-align:center;
                     font-family:Arial, Helvetica, sans-serif; 
                     font-size:10px;}  

        </style>
    </head>

<body>
    <div id='container' align='center' border='1' >
        <div id='banner' align='center'>
            <img src='http://190.105.239.65:8080/ageweb/public/images/logo_online.png' width='300' height='75' />
        </div>
        <div id='contenido'>
            <br />	
            <span>
            <?php  //$contraseniaEncriptada = Crypt::encrypt($mensaje);?>  
                <p class='contenido'><h2 class='red'><h2></P>
                        <p class='contenido'>Recuperación de Password</p>
                        <br />
                        <table border='0' align='center' width='300px' style="background-color: #32659c">
                            <tr>
                                <td bordercolor='#82D7FF' style="background-color: #32659c">
                                    <h4 align='center' style="background-color: #32659c;">
                                        <a href=''><font color="white">Estimado {{$nombre}}, su contraseña para tener acceso al sistema es: {{$clave}}</font></a></h4>
                                </td>
                            </tr>
                        </table>
                        <br />
                        <p class='contenido'>Recuerda que sus datos son confidenciales y no transferibles</p>
                        <p class='contenido'>Si usted desconoce esta operaci&oacute;n, comun&iacute;quese con el administrador del sistema</p>

                        </span>

                        </div>
                        <div id='footer'>
                            <p class='footer'> &#169; 2018 WEBMÉDICA</p>
                            <p class='footer'>Favor no Responda. Este es un correo Generado automáticamente por el sistema de Agendamiento Webmédica. </p>
                        </div>

                        </div>
                        </body>
</html>

