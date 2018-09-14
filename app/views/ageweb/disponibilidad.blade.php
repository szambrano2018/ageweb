<div>
<p class="lead">Datos del médico<span class="text-success"></span></p>
	<ul class="list-unstyled" style="line-height: 2">
		<li><span class="fa fa-check text-success"></span> Dr. <span style="color: #2FA4E7;">{{$nom_medico}}</span></li>
		<li><span class="fa fa-check text-success"></span> Especialidad <span style="color: #2FA4E7;">{{$nom_especialidad}}</span></li>
	</ul>
</div>

<form class="form-group" role="form">
  <div style="padding-top:10px;"><p class="lead">Próxima hora disponible</p></div>
  <div class="form-group">Fecha</div>
  <div class="form-group"><input type="text" class="form-control" disabled="true" value="{{$fecha_actual}}" name = "str_fecha" id = "str_fecha"></div>
  <div class="form-group">Hora</div>
  <div class="form-group"><input type="text" class="form-control" disabled="true" value="{{$hora_intervalo1}}" name = "str_hora" id = "str_hora"></div>
</form>


                                                                                                                                                                                    