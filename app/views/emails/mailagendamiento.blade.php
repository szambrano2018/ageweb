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
                    <td colspan="2"><img src='http://190.105.239.65:8080/ageweb/public/images/logo_online.png' width='270' height='65' /></td>
                    <td colspan="1"><strong style="font-size: 16px; color:#10a5da;">Sistema de Reserva de Horas Médicas</strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 16px;">Número de Reserva:</td>
                    <td colspan="2" style="font-size: 16px;">{{$id_reserva}}</td>
                </tr>
                 <tr>
                    <td colspan="4" style="font-size: 14px;"><strong>Estimado Paciente:</strong> le informamos que usted ha realizado una reserva de Hora en nuestro sistema de Agendamiento Web, con los siguientes datos: </td> 
                    <tr colspan="4">&nbsp;</tr>  
                    <tr colspan="4">&nbsp;</tr> 
                </tr>
                <tr>
                    <td style="font-size: 14px; background-color: #32659c; color: #FFF;">Médico/Unidad:</td>
                    <td style="font-size: 14px; background-color: #32659c; color: #FFF;">Fecha de Reserva:</td>
                    <td style="font-size: 14px; background-color: #32659c; color: #FFF;">Hora de Reserva:</td>
                    <td style="font-size: 14px; background-color: #32659c; color: #FFF;">Especialidad:</td>
                </tr>
                <tr>
                    <td>{{$str_medico}}</td>
                    <td>{{$fecha}}</td>
                    <td>{{$hora}}</td>
                    <td>{{$especialidad}}</td>
                </tr>
                <tr>

<td></td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td style="font-size: 16px; color: #10a5da;">IMPORTANTE:</td>
                    <td colspan="3" valign="top" align="center">Usted recibirá un correo para Confirmar o Rechazar la hora tomada, esta acción automáticamente actualizará el estado de su hora.
                </tr>
                <tr>
                    <td colspan="4">
                        <div id='footer'><center >
                            <p class='footer' style="font-size: 8px;"> &#169; WebMedica 2018</p>
                        </div>
                    </td>
                </tr>
            </table>


        </div>
</body>
</html>
