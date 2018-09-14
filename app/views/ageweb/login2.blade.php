@extends('layouts.master') 

@section('content') 
<div class="a" id="login-overlay" class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-6">
                    <div class="well">
                    
                    <form action="segundoverificalogin" method="post" id="formlogin" name="formlogin">
                                                        
                            <div class="form-group">
                                <label for="usuario" class="control-label">Email</label>
                                <input type="hidden" id="str_nom_agenda_login" name="str_nom_agenda_login" value="{{Session::get('str_bd')}}">
                                <input type="email" class="form-control" id="str_usuario2" name="str_usuario2" placeholder="example@gmail.com">
                                <span style="color: #ff3346 ;">{{$errors->first("str_usuario2")}}</span>
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label">Contraseña</label>
                                <input type="password" class="form-control" id="password2" name="password2" maxlength="8">
                                <span style="color: #ff3346 ;">{{$errors->first("password2")}}</span>
                            </div>
                            <div class="checkbox">
                                <label>
                                     <a href="email">¿Olvidó Contraseña?</a>
                                </label>
                                <label>
                                    <a href="segundoregistrarse">Registrarse</a>
                                </label>
                            </div>
                            <input type="Submit" value="Agendar Hora" class="btn btn-primary">
                    </form>        
                    </div>
                </div>
                <div class="col-xs-6">
                    <p class="lead">Validación de Usuario <span class="text-success"></span></p>
                    <ul class="list-unstyled" style="line-height: 2">
                        <li><span class="fa fa-check text-success"></span> Usuario: webmedica@webmedica.com</li>
                        <li><span class="fa fa-check text-success"></span> Password: pass990</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 