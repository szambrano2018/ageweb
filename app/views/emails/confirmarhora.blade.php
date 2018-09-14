<html>
    <head>

    </head>
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

            

        <div id='contenido'>
            <table width="740" border="0">
                <tr>
                    <td colspan="2"><img src='http://190.105.239.65:8080/ageweb/public/images/logo_online.png' width='200' height='65' /></td>
                    <td colspan="1"><strong style="font-size: 16px; color:#10a5da;">Sistema de Confirmación Automático de Horas Médicas</strong></td>
                </tr>
                <tr>
                    <td colspan="4" style="font-size: 14px;"><strong>Estimado Paciente:</strong> Usted ha resevado una Hora en nuestro sistema de Agedamiento Web puede Confirmar o Rechazar su hora haciendo Click en alguna de las opciones:</td> 
                    <tr colspan="4">&nbsp;</tr>  
                    <tr colspan="4">&nbsp;</tr> 
                </tr>
                 <tr>
                    <td colspan="4">&nbsp;</td>  
                    <td colspan="4">&nbsp;</td>  
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 14px; background-color: #32659c; color: #FFF;"><a style="color: #FFF;" href="http://190.105.239.65:8080/agenda/respuesta/{{$id_reserva}}/{{$md5}}">Confirmar Hora: {{$hora}}</a></td>
                    <td colspan="2" style="font-size: 14px; background-color: #32659c; color: #FFF;"><a style="color: #FFF;" href="http://190.105.239.65:8080/agenda/segundarespuesta/{{$id_reserva}}/{{$md5}}">Rechazar Hora</a></td>
                </tr>
                <tr>

<td></td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td style="font-size: 16px; color: #10a5da;">IMPORTANTE:</td>
                    <td colspan="3" valign="top" align="left">Al ejecutar ésta acción automáticamente se actualizará el estado de su hora.</td>
                </tr>
                <tr>
                    <td colspan="3" valign="top" align="left" style="padding-left:43px;">Llegue con a lo menos 10 minutos de antelación a la hora de atención.</td>
                </tr>
                <tr>
                    <td colspan="3" valign="top" align="left" style="padding-left:43px;">Si tiene inconvenientes para asistir a la consulta, llame al Centro Médico para reasignar su hora.</td>
                </tr>       
                <tr>
                    <td colspan="4">
                        <div id='footer'><center >
                            <p class='footer' style="font-size: 8px;"> &#169; 2018 WEBMÉDICA</p>
                        </div>
                    </td>
                </tr>
            </table>


        </div>
</body>
</html>