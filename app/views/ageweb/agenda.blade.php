@extends('layouts.master') 

@section('content')
<div class="a" id="login-overlay" class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <!--****************************PRIMER CUADRO******************************************-->
            <div class="row">
                <div class="col-xs-6 table-responsive">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background: #2FA4E7; color: #ffffff;">Profesionales / Especialidad</div>
                        <div class="panel-body">
                        <form action="agendamientoagenda" method="get" id="formsegundopaso" name="formsegundopaso">
                            <div class="form-group">
                                <input type="hidden" name="textdisabled" id="textdisabled" value="{{$horariofinal}}">
                                <label for="text" class="control-label">Especialidad</label>
                            </div>
                            <div>
                                {{ Form::select ('str_especialista',$especialistas, $selected, ['class' => 'form-control', 'id'=>'str_especialista','onchange' => 'buscaprofesionales2();'])}}
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group"><label class="control-label">Médico</label></div>
                                <!--********************************ESPECIALISTA DEL PRIMER PASO DE AGENDAMIENTO*******-->
                                <input type="hidden" name="str_medico1" id="str_medico1" value="{{$id_medico}}">
                                <!--**********************************************************************************-->
                                <!--********************NOMBRE DE LA BD*************************************-->
                                <input type="hidden" name="str_nom_agenda" id="str_nom_agenda" value="{{$str_nom_agenda}}">
                                <!--********************FIN DE ASIGNACION DE NOMBRE DE LAS BD***************--> 
                            <div id="divmedicosagenda">
                                {{ Form::select ('str_medico',$inicializar, $selected, ['class' => 'form-control', 'id'=>'str_medico'])}}
                                <span class="help-block"></span>
                            </div>
                            <div><input type="Submit" value="Disponibilidad" class="btn btn-primary"></div>
                         </form>   
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 table-responsive">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background: #2FA4E7; color: #ffffff;">DEMO</div>
                        <div class="panel-body">
                            <ul class="list-unstyled" style="line-height: 2">
                                <li><span style="color:#317EAC">Instrucciones para Agendar:</span></li>
                                <li><span class="fa fa-check text-success"></span> Si ya selecciono previamente la especialidad y el profesional, solo seleccione la fecha y haga clic en <span style="background: #2FA4E7; color: #ffffff;">BUSCAR HORAS DISPONIBLES</span></li>
                                <li><span class="fa fa-check text-success"></span> Si desea una nueva búsqueda, seleccione la especialidad, médico y haga clic en <span style="background: #2FA4E7; color: #ffffff;">DISPONIBILIDAD</span></li>
                                <li><span class="fa fa-check text-success"></span> Seleccione una fecha</li>
                                <li><span class="fa fa-check text-success"></span> Haga clic en <span style="background: #2FA4E7; color: #ffffff;">BUSCAR HORAS DISPONIBLES</span></li>
                                <li><span class="fa fa-check text-success"></span> Seleccione hora deseada</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--******************************SEGUNDO CUADRO**************************************-->
            <div class="row">
                <div class="col-xs-5 table-responsive">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background: #2FA4E7; color: #ffffff;">Disponibilidad en Agenda</div>
                        <div class="panel-body">
                            <div id="divcalendario2"><input type="text" name="calendario" id="calendario" class="form-control" placeholder="Seleccione la fecha para su hora"></div>
                            <div style="padding-top:10px"><button type="button" class="btn btn-primary" style="padding:5px" onclick="buscarhorarios();">Buscar Horas Disponibles</button></div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-7 table-responsive">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background: #2FA4E7; color: #ffffff;">Disponibilidad Horaria</div>
                        <div class="panel-body">
                            <div id="divhoras" name="divhoras" style="padding: 20px;"></div>
                        </div>
                    </div>   
                </div>
            </div>
            <!--******************************TERCER CUADRO**************************************-->
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background: #2FA4E7; color: #ffffff;">Consideraciones</div>
                        <div class="panel-body">                          
                        <ul class="list-unstyled" style="line-height: 2">
                             <li><span style="color:#317EAC"> Considere la siguiente información:</span></li>
                                  <?php $nro_explode = count($var_array_consideraciones, COUNT_RECURSIVE);
                                  $cont = 0;
                                  while ($cont < $nro_explode) {?>
                                         <li><span class="fa fa-check text-success"></span>{{$var_array_consideraciones[$cont]}}</li>
                                         <?php $cont ++; } ?>
                             <li><span style="color:#317EAC">Fono: {{$str_fonos}}</span></li>
                        </ul> 
                        </div>  
                    </div>
                </div>
            </div>
            <!--*************************FIN DE CUADROS*************************************-->
        </div>
    </div>
</div>






<script>
//***********************LLENAR EL ARREGLO*******************
var data = new Array(3);
data[1] = 1;
data[2] = 2;
data[3] = 3;
//***********************DESHABILITAR DÍAS DE LA SEMANA******
domingo   = 0;
lunes     = 1;
martes    = 2;
miercoles = 3;
jueves    = 4;
viernes   = 5;
sabado    = 6;
diasdisabled = $('#textdisabled').val();

//alert (bloqferiado);
//***********************CONTENIDO DEL TOOLTIP***************
vartooltip = "Tiene consulta para hoy";
varclasses = "active";
//***********************MOSTRAR CONTENIDO DEL ARRAY*********
        $( document ).ready(function() {
            $('#calendario').datepicker({
                format:"DD-dd-mm-yyyy",
                keyboardNavigation: false,
                forceParse: false,
                daysOfWeekDisabled: diasdisabled,
                todayHighlight: true,
                autoclose: true,
                //datesDisabled: ['14/08/2018','15/08/2018'],
            });

        });

</script>
@endsection 

