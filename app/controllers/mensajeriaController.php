<?php

class mensajeriaController extends BaseController {

	protected $layout = 'layouts.master';

	 public function get_olvidocontrasena() {
	 	DB::beginTransaction();
        try {
	    //***VALIDAR LOS CAMPOS QUE SE REQUIEREN*******************************************
        $inputs = Input::All();
        $reglas = array
            (
            'str_email' => 'required' ,
        );
        $mensajes = array(
            "required" => "El Email es Obligatorio",
            "min"      => "M&iacute;nimo 5 Caracteres",
        );
        $validar = Validator::make($inputs, $reglas, $mensajes);
        if ($validar->fails()) {
            return Redirect::back()->withErrors($validar);
        } else {	    
		 	    //***RECUPERO EMAIL DE RECUPERACION****************
		 	    $str_email = Input::get('str_email');
		 	    //***BUSCAR LA INFORMACIÓN PARA ENVIAR EL CORREO***
	                $verifica_existe_usuario_web = DB::connection('usuarios_web')
	                    ->table('tb_usuarios')
	                    ->select('*')
	                    ->where('str_email', '=', $str_email)
	                    ->get();
	               
	                foreach ($verifica_existe_usuario_web as $verifica_existe_usuario_web1) {
	                         $clave  = $verifica_existe_usuario_web1->str_password;
	                         $nombre = $verifica_existe_usuario_web1->str_descripcion;
	                }
		 	    //***FIN DE BUSCAR LA INFORMACIÓN******************
		 	    //***ENVIAR EL CORREO DE LA CONTRASEÑA*************
			 	$data = array
		            ('clave'  => $clave,
		             'nombre' => $nombre
		        );
		        $fromEmail = 'infowebmedicas@gmail.com';
		        $fromName  = 'Agendamiento Webmédica';
		        $toEmail   = $str_email;
		        $toName    = '';

		        Mail::send('emails.recuperaclave', $data, function($message) use ($fromName, $fromEmail, $toEmail, $toName) {
		            $message->to($toEmail, $toName);  
		            $message->from($fromEmail, $fromName);
		            $message->subject('Recordatorio de Contraseña');
		        });
		        return $this->layout->content = View::make('ageweb/correoexitoso'); 
	         }   
	         } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();                 
     }//*****************FIN DEL MÉTODO*****************

     public function get_updateconfirmar($idreserva,$md5) {
     	//***************BUSCAR BASE DE DATOS ACTIVA*****************
     	$bdprincipal = DB::connection('agendappal')
                ->table('basedatos')
                ->select('bd', 'md5')
                ->where('md5', '=', $md5)
                ->get();
            foreach ($bdprincipal as $bdprincipales) {
                     //***COLOCAR EN UNA VARIABLE DE SESIÓN EL NOMBRE DE LA BD***
                     $bd_principal = $bdprincipales->bd;
            }
        //***************ACTUALIZAR ESTATUS DEL AGENDAMIENTO*********
     	$bdupdate = DB::connection($bd_principal)
                  ->table('agenda')
                  ->where('id', '=', $idreserva)
                  ->update(array('web' => 2));
        //***************RETORNAR UNA VISTA EXITOSA******************
        return $this->layout->content = View::make('ageweb/respuestaenviada');

     }

     public function get_updaterechazar($idreserva,$md5) {
     	//***************BUSCAR BASE DE DATOS ACTIVA*****************
     	$bdprincipal = DB::connection('agendappal')
                ->table('basedatos')
                ->select('bd', 'md5')
                ->where('md5', '=', $md5)
                ->get();
            foreach ($bdprincipal as $bdprincipales) {
                     //***COLOCAR EN UNA VARIABLE DE SESIÓN EL NOMBRE DE LA BD***
                     $bd_principal = $bdprincipales->bd;
            }
        //***************ACTUALIZAR ESTATUS DEL AGENDAMIENTO*********
     	$bdupdate = DB::connection($bd_principal)
                  ->table('agenda')
                  ->where('id', '=', $idreserva)
                  ->update(array('web' => 3));
        //***************RETORNAR UNA VISTA EXITOSA******************
        return $this->layout->content = View::make('ageweb/respuestaenviada');

     }


//**********************************FIN DEL CONTROLADOR******************************************
}