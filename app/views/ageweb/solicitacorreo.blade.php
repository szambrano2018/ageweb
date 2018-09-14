@extends('layouts.master') 

@section('content') 
<div class="a" id="login-overlay" class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-6">
                    <div class="well">                    
                    <form action="contrasena" method="get" id="formrecupera" name="formrecupera">
                            <div class="form-group">
                                <label for="usuario" class="control-label">Email</label>
                                <input type="hidden" id="str_nom_agenda_login" name="str_nom_agenda_login" value="{{Session::get('str_bd')}}">
                                <input type="email" class="form-control" id="str_email" name="str_email" placeholder="Introduzca el email de recuperación">
                                <span style="color: #ff3346 ;">{{$errors->first("str_email")}}</span>
                            </div>
                            <div><input type="Submit" value="Recuperar Password" class="btn btn-primary"></div>
                    </form>        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 