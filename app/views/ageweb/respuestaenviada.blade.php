@extends('layouts.master') 

@section('content') 
<div class="a" id="login-overlay" class="modal-dialog">
    <div class="modal-content" style="width:500px;">
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-4">
                    <div class="well" style="width:450px;">                    
                           <p class="lead">Proceso Exitóso<span class="text-success"></span></p>
                            <ul class="list-unstyled" style="line-height: 2">
                                <li><span class="fa fa-check text-success"></span> Su respuesta fue recibida exitósamente</li>
                            </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 