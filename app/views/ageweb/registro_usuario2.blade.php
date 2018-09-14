@extends('layouts.master') 

@section('content') 
<div class="a" id="login-overlay" class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="well">
                    <div align="left">
                @if(Session::has('mensaje'))
                        <h2>{{ Session::get('mensaje') }}</h2>
                @endif
            </div>
                    <form action="segundareserva" method="post" id="formregistro" name="formregistro">
                           <div class="form-group col-xs-4">
                                <label for="rut" class="control-label">Rut </label> <span style="color: #ff3346 ;">{{$errors->first("str_rut")}}</span>
                                <input type="text" class="form-control" id="str_rut" name="str_rut" onKeyPress="return numerosval(event)" onblur="Rut2()"  placeholder="25.800.600-1">
                                
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="usuario" class="control-label">Nombres</label><span style="color: #ff3346 ;">{{$errors->first("str_nombre")}}</span>
                                <input type="text" class="form-control" id="str_nombre" name="str_nombre" onKeyPress="return soloLetras(event)"  placeholder="Pedro Emilio">
                                
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="str_paterno" class="control-label">Ap. Paterno</label><span style="color: #ff3346 ;">{{$errors->first("str_paterno")}}</span>
                                <input type="text" class="form-control" id="str_paterno" name="str_paterno" onKeyPress="return soloLetras(event)"  placeholder="Mardones">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="str_materno" class="control-label">Ap. Materno</label><span style="color: #ff3346 ;">{{$errors->first("str_materno")}}</span>
                                <input type="text" class="form-control" id="str_materno" name="str_materno" onKeyPress="return soloLetras(event)"  placeholder="Mardones">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="usuario" class="control-label">Sexo</label>
                                {{ Form::select ('str_sexo',$sexo, $selected, ['class' => 'form-control', 'id'=>'str_sexo'])}}
                                <span class="help-block"></span>
                            </div>

                            <div class="form-group col-xs-4">
                                <label for="usuario" class="control-label">Previsión</label>
                                {{ Form::select ('str_previsiones',$previsiones, $selected, ['class' => 'form-control', 'id'=>'str_previsiones'])}}
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="usuario" class="control-label">Fec. Nacimiento</label><span style="color: #ff3346 ;">{{$errors->first("calendario")}}</span>
                                <input type="text" name="calendario" id="calendario" class="form-control" placeholder="Ejemplo: AAAA-MM-DD">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="str_tlf" class="control-label">Teléfono</label><span style="color: #ff3346 ;">{{$errors->first("str_tlf")}}</span>
                                <input type="text" class="form-control" id="str_tlf" name="str_tlf" onKeyPress="return numerosval(event)" maxlength="9"  placeholder="963345987">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="str_celular" class="control-label">Celular</label><span style="color: #ff3346 ;">{{$errors->first("str_celular")}}</span>
                                <input type="text" class="form-control" id="str_celular" name="str_celular" onKeyPress="return numerosval(event)" maxlength="9"  placeholder="963345987">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="str_email" class="control-label">Email</label><span id="divcorreo" style="color: #ff3346 ;">{{$errors->first("str_email")}}</span>
                                <input type="email" class="form-control" id="str_email" name="str_email" value=""  placeholder="example@gmail.com" onblur="ajaxvalidaemail()">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="str_password" class="control-label">Contraseña</label><span style="color: #ff3346 ;">{{$errors->first("str_password")}}</span>
                                <input type="password" class="form-control" id="str_password" name="str_password" maxlength="8" placeholder="Máximo 8 carácteres. Ejemplo: 12345678" onblur="ajaxactivarregistrarse()">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-xs-4">
                                <label for="str_password" class="control-label">Escriba de Nuevo su Contraseña</label><span style="color: #ff3346 ;">{{$errors->first("str_password2")}}</span>
                                <input type="password" class="form-control" id="str_password2" name="str_password2" maxlength="8" placeholder="Máximo 8 carácteres. Ejemplo: 12345678">
                                <span class="help-block"></span>
                           </div>
                           <div class="form-group col-xs-4">
                                <input type="Submit" id="btn_registrar" name="btn_registrar" value="Registrarse" class="btn btn-primary">
                           </div>
                    </form>
                    <form action="segundologin" method="get" id="formatras" name="formatras">
                            <input type="Submit" value="Volver Atrás" class="btn btn-primary">
                    </form>        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
//***********************MOSTRAR CONTENIDO DEL ARRAY*********
        $( document ).ready(function() {
            $('#calendario').datepicker({
                format:"yyyy-mm-dd",
                keyboardNavigation: false,
                forceParse: false,
                todayHighlight: true,
                autoclose: true,
            });

        });

</script>
@endsection 