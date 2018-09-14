 <?php
       //*************************************************INICIALIZAR VARIABLES****************************************
       $indice = 2;
       foreach ($horario_semanal2 as $horario_semanales) {       	        
       	        $var = "h".$indice;                
                ?> 
                <!--**********************************FORMULARIO PARA AGENDAR LA HORA*************************-->
                <form action="verificaloginagenda" method="post" id="form_hora_agendar" name="form_hora_agendar">
                <!--***WHILE PARA RECORRER EL HORARIO DE LA TABLA INTERVALOS3*********************************-->
                @while ($indice <= 120)<?php 
                      //******************************SE ASIGNA LA HORA CORRESPONDIENTE**************************
	                  $horas = $horario_semanales->$var; 
                    ?> 
                    <!--*****CAMPO PARA TRAER EL INTERVALO DE LA HORA (Y OTROS) Y ENVIARLO AL FORMULARIO LOGIN-->
                    <input type="hidden" name="dif_agenda_hora" id="dif_agenda_hora" value="{{$horario_semanales->intervalo}}">
                    <input type="hidden" name="fecha_agenda_hora" id="fecha_agenda_hora" value="{{$fecha_actual1}}">
                    <input type="hidden" name="idmedico_agenda_hora" id="idmedico_agenda_hora" value="{{$int_medico}}">
                    <!--***FIN DE CAMPO PARA TRAER EL INTERVALO DE LA HORA Y ENVIARLO AL FORMULARIO LOGIN-->
                    <?php
	                  //***AQUI DEBO VERIFICAR LOS BLOQUEOS DE FERIADOS*************
	                  $sw_feriado = 0;
                      $bloqueos_feriado = DB::connection(Session::get('str_bd'))
                               ->table('feriados')
                               ->select('*')
                               ->where('fecha1', '>=', $fecha_actual1)
                               ->Where('fecha2', '<=', $fecha_actual1)
                               ->orderBy('fecha1', 'ASC')
                               ->get();
                        foreach ($bloqueos_feriado as $bloqueos_feriados) {
                                 $sw_feriado = 1;
                                 }
                      //dd($sw_feriado);
	                  //***REALIZAR CONSULTA PARA VALIDAR SI ÉSTA HORA ESTÁ AGENDADA***
	                    $sw_agendado           = 0;
	                    $minutoAnadir          = 0;
                      $segundos_horaInicial  = strtotime($horas);
                      $segundos_minutoAnadir = $minutoAnadir*60;
                      $nuevaHora             = date("H:i",$segundos_horaInicial);
                      $buscarnuevaHora       = "1899-12-30 ".$nuevaHora.":00.000";

                      $hora_mostrar = DB::connection($str_nom_agenda)
                            ->table('agenda')
                            ->select('fecha', 'hora', 'id_medico')
                            ->where('id_medico', '=', $int_medico)
                            ->where('fecha', '=', $fecha_actual1)
                            ->where('hora', '=', $buscarnuevaHora)
                            ->orderBy('hora', 'ASC')
                            ->get();
                      //***FOREACH PARA SABER SI YA ESTÁ AGENDADO***
                       foreach ($hora_mostrar as $hora_mostrarle) {               
                                $sw_agendado = 1;  
                       }
	                  //***FIN DE VALIDAR HORA AGENDADA********************************
                      //***AQUI DEBO VERIFICAR LOS BLOQUEOS POR RANGOS DE HORAS******
                      $sw_bloq_rango = 0; 
                      $fechanva      = $fecha_actual1." "."00:00:00";
                      
                      $bloqueos_rango = DB::connection(Session::get('str_bd'))
                               ->table('bloqueos')
                               ->select('*')
                               ->where('fecha', '=', $fechanva)
                               ->where('intini', '<>', 0)
                               ->orderBy('fecha', 'ASC')
                               ->get();

                        foreach ($bloqueos_rango as $bloqueos_rangos) {
                        	     $hora_inicio = $bloqueos_rangos->intini;
                        	     $hora_fin    = $bloqueos_rangos->intfin;
                                 
                        	     $bloqueosint = $hora_inicio;
                        	    //***VERIFICAR CUALES SON LAS HORAS BLOQUEDAS***
                        	     $bloqueos_rango2 = DB::connection($str_nom_agenda)
                                        ->table('intervalos3')
                                        ->select('*')
                                        ->where('id_medico', '=', $int_medico)
                                        ->where('dia', '=', $diadelasemana)
                                        ->get();
                                
                                foreach ($bloqueos_rango2 as $bloqueos_rango22) {
                                	     
                                	     while ($bloqueosint <= $hora_fin) {
                                	     	    $var_bloq = "h".$bloqueosint;
                                	            $h = $bloqueos_rango22->$var_bloq;
                                	     	    if ($horas == $h){
                                	     	    	$sw_bloq_rango = 1;
                                	     	    }
                                	     $bloqueosint ++; 
                                	     }                                    
                                }
                                 
                        } //dd($bloqueos_rango22->$var_bloq);
                      //***FIN DE VERIFICAR LOS BLOQUEOS POR RANGOS DE HORAS***
                      //***BLOQUEO INDIVIDUAL POR RANGO DE FECHAS**************
                      $fechanva2          = $fecha_actual1." "."00:00:00";
                      $sw_bloq_individual = 0; 
                      
                      $bloqueos_individual = DB::connection(Session::get('str_bd'))
                               ->table('bloqueos')
                               ->select('*')
                               ->where('intini', '=', 0)
                               ->where('fecha1', '>=', $fechanva2)
                               ->where('fecha2', '<=', $fechanva2)
                               ->get();
                       foreach ($bloqueos_individual as $bloqueos_individuales) {
                       	        $sw_bloq_individual = 1;
                       }

                      //***FIN DE BLOQUEO INDIVUDUAL POR RANGOS DE FECHAS******
	                  ?>                    
	                  <!--****************************SE VALIDA QUE NO IMPRIMA DATOS ERRONEOS*****************-->
	                  @if (strlen($horas) > 3 && $sw_agendado == 0 && $sw_feriado == 0 && $sw_bloq_rango == 0 && $sw_bloq_individual == 0)
                    
	                    <!--**********************DIBUJAR LOS BOTONES****************************************-->
			                <!--<button type="button" class="btn btn-primary" id="{{$var}}" onclick="ajaxagendar('{{$var}}');" style="padding:5px">{{$horas}}</button>-->
                      <input type="Submit" id="str_campo_hora" name="str_campo_hora" value="{{$horas}}" class="btn btn-primary">                    
			              @endif                 
	                  <?php 
	                     //*************************SE INCREMENTA EL CONTADOR**************
		                   $indice ++; 
		                   $var = "h".$indice;
		              ?>               
                  @endwhile
                  <!--****************************FIN DEL FORMULARIO***************************************-->
                  </form> 
       <?php    //***FIN DE VERIFICAR LOS BLOQUEOS******************************  

       }//***LLAVE QUE CIERRA EL foreach***
        //*************************************************HORARIOS ESPECIALES***********************************
       /*$indice = 2;
       foreach ($horario_semanal_especial as $horario_semanal_especiales) {       	        
       	        $var = "h".$indice;

                ?>@while ($indice <= 120)<?php 
                      //******************************SE ASIGNA LA HORA CORRESPONDIENTE**************************
	                  $horas = $horario_semanal_especiales->$var; ?>
	                  <!--****************************SE VALIDA QUE NO IMPRIMA DATOS ERRONEOS*****************-->
	                  @if (strlen($horas) > 3 && $sw_feriado == 0 && $sw_bloq_individual == 0)
	                        <!--**********************DIBUJAR LOS BOTONES****************************************-->
			                <button type="button" class="btn btn-info" id="{{$var}}" onclick="ajaxagendar('{{$var}}');" style="padding:5px">{{$horas}}</button>
			          @endif  
	                  <?php 
	                       //*************************SE INCREMENTA EL CONTADOR**************
		                   $indice ++; 
		                   $var = "h".$indice;
		              ?>               
                  @endwhile
       <?php     
        }*/
       ?>

