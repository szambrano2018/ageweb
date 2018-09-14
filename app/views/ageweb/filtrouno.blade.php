@extends('layouts.master') 

@section('content') 
<div class="a" id="login-overlay" class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-6">
                    <div class="well">
                    
                    <form action="../agendamiento" method="get" id="formprimerpaso" name="formprimerpaso">
                            <!--********************NOMBRE DE LA BD*************************************-->
                            <input type="hidden" name="str_nom_agenda" id="str_nom_agenda" value="{{$str_nom_agenda}}">
                            <!--********************FIN DE ASIGNACION DE NOMBRE DE LAS BD***************-->                    
                            <div class="form-group"><label class="control-label">Especialidad</label></div>
                            <div class="form-group">
                                {{ Form::select ('str_especialista',$especialistas, $selected, ['class' => 'form-control', 'id'=>'str_especialista','name'=>'str_especialista','onchange' => 'buscaprofesionales();'])}}
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group"><label class="control-label">Médico</label></div>
                            <div class="form-group" id="divmedicos">
                                {{ Form::select ('str_medico',$inicializar, $selected, ['class' => 'form-control', 'id'=>'str_medico'])}}
                            </div>                            
                            <input type="Submit" id="masreservas" value="Más Horas" disabled class="btn btn-primary">
                    </form> 
                    <form action="../login" method="get" id="formlogin" name="formlogin">
                                <input type="hidden" name="id_medico_reg" id="id_medico_reg">
                                <input type="hidden" name="str_fecha_reg" id="str_fecha_reg">
                                <input type="hidden" name="str_hora" id="str_hora">
                                <input type="Submit" id="reserva" value="Reservar Hora" disabled class="btn btn-primary">
                    </form>       
                    </div>
                </div>
                <div class="col-xs-6" id="divhoradisponible">
                    <p class="lead">Datos del médico<span class="text-success"></span></p>
                    <ul class="list-unstyled" style="line-height: 2">
                        <li><span class="fa fa-check text-success"></span> Seleccione el especialista</li>
                        <li><span class="fa fa-check text-success"></span> Seleccione el médico</li>
                        <li><span class="fa fa-check text-success"></span> Si desea reservar hora haga clic en <span style="background: #2FA4E7; color: #ffffff;">RESERVAR HORA</span></li>
                        <li><span class="fa fa-check text-success"></span> Haga clic en <span style="background: #2FA4E7; color: #ffffff;">MÁS HORAS</span> si desea ver horarios de otros profesionales o reservar en otra fecha</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 