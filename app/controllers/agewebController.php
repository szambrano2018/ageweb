<?php

class agewebController extends BaseController {

	protected $layout = 'layouts.master';
        
	        
        public function get_login() {
        DB::beginTransaction();
        try {
            $str_nom_agenda_login = Input::get('str_nom_agenda_login');
            return $this->layout->content = View::make('ageweb/login');
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();
                       
        }

        public function get_login2() {
        DB::beginTransaction();
        try {
            $str_nom_agenda_login = Input::get('str_nom_agenda_login');
            return $this->layout->content = View::make('ageweb/login2');
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();
                       
        }

        public function get_recuperaclave() {
        DB::beginTransaction();
        try {
            return $this->layout->content = View::make('ageweb/solicitacorreo');
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();
                       
        }

        public function get_registrar_usuario() {
        DB::beginTransaction();
        try {
            //***BUSCAR Y CARGAR LAS PREVISIONES**********************
            $prevision = DB::connection(Session::get('str_bd'))
                ->table('Prevision')
                ->select('id', 'Descripcion','estado')
                ->where('estado', '=', 1)
                ->orderBy('Descripcion', 'ASC')
                ->lists('Descripcion', 'id');
            $previsiones = array('todos' => "Seleccione") + $prevision;
            //***SE CONSTRUYE EL SELECT*******************************
            $sexo = array('0' => 'Seleccione', 'M' => 'Masculino', 'F' => 'Femenino');
            $selected = array();
            return $this->layout->content = View::make('ageweb/registro_usuario',compact('sexo','previsiones','selected'));
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();
                       
        }

        public function get_registrar_usuario2() {
        DB::beginTransaction();
        try {
            //***BUSCAR Y CARGAR LAS PREVISIONES**********************
            $prevision = DB::connection(Session::get('str_bd'))
                ->table('Prevision')
                ->select('id', 'Descripcion','estado')
                ->where('estado', '=', 1)
                ->orderBy('Descripcion', 'ASC')
                ->lists('Descripcion', 'id');
            $previsiones = array('todos' => "Seleccione") + $prevision;
            //***SE CONSTRUYE EL SELECT*******************************
            $sexo = array('0' => 'Seleccione', 'M' => 'Masculino', 'F' => 'Femenino');
            $selected = array();
            return $this->layout->content = View::make('ageweb/registro_usuario2',compact('sexo','previsiones','selected'));
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();
                       
        }
        
        public function get_agendamiento() {
        DB::beginTransaction();
        try {
            //**********************VERIFICAR LOS DATOS QUE VIENEN POR GET*********
            $id_medico        = Input::get('str_medico'); 
            $str_especialista = Input::get('str_especialista');   
            $str_nom_agenda   = Input::get('str_nom_agenda');

            //**********************BUSCO INFORMACION DEL TIPO DE PROFESIONAL******
            $especialista = DB::connection(Session::get('str_bd'))
                ->table('tipoprofesional')
                ->select('id_tipoprofesional', 'descripcion')
                ->where('visibleweb', '=', 1)
                ->orderBy('descripcion', 'ASC')
                ->lists('descripcion', 'id_tipoprofesional');
            $especialistas = array('todos' => "Seleccione") + $especialista;
            //**********************BUSCO HORARIO DEL PROFESIONAL******************
            $hora = DB::connection(Session::get('str_bd'))
                ->table('intervalos3')
                ->select('dia', 'Cta', 'id_medico')
                ->where('id_medico', '=', $id_medico)
                ->where('Cta', '=', 0)
                ->orderBy('dia', 'ASC')
                ->get();
            $horarios = "";
            foreach ($hora as $horas) {
                $int_dia = $horas->dia;
                $int_cta = $horas->Cta;
                //***************SE CONSTRUYE LA VARIABLE DE DIAS NO LABORABLES****
                if ($int_dia==1) {
                    $horarios = "1"; 
                }else if ($int_dia==2) {
                    $horarios = $horarios.","."2"; 
                }else if ($int_dia==3) {
                    $horarios = $horarios.","."3"; 
                }else if ($int_dia==4) {
                    $horarios = $horarios.","."4"; 
                }else if ($int_dia==5) {
                    $horarios = $horarios.","."5"; 
                }else if ($int_dia==6) {
                    $horarios = $horarios.","."6"; 
                }else if ($int_dia==7) {
                    $horarios = $horarios.","."0"; 
                }                
            }
            $horariofinal = "[".$horarios."]";
            //******************BUSCAR INFORMACIÓN DE CONSIDERACIONES*************
            $str_consideracion = DB::connection('agendappal')
                ->table('basedatos')
                ->select('*')
                ->where('md5', '=', Session::get('idmd5'))
                ->get();
            foreach ($str_consideracion as $str_consideraciones) {
                     $str_consideraciones = $str_consideraciones->infoagendamiento2;
            }
            $var_array_consideraciones = (explode("/",$str_consideraciones));
            //*******************BUSCA FONOS**************************************
            $str_fono = DB::connection('agendappal')
                ->table('basedatos')
                ->select('*')
                ->where('md5', '=', Session::get('idmd5'))
                ->get();
            foreach ($str_fono as $str_fonos) {
                     $str_fonos = $str_fonos->fonos;
            }
            //*******************FIN BUSCA FONOS**********************************
            $inicializar = array('todos' => "Seleccione");
            $selected = array();
            return $this->layout->content = View::make('ageweb/agenda',compact('selected','inicializar','horariofinal','str_nom_agenda','especialistas','str_especialista','id_medico','bloqferiado','var_array_consideraciones','str_fonos'));
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();
                       
        }

        public function get_primerpaso($id) {
        DB::beginTransaction();
        try {
            //**********************VERIFICA QUE BD ESTA ACTIVA************************
            $bdprincipal = DB::connection('agendappal')
                ->table('basedatos')
                ->select('bd', 'md5')
                ->where('md5', '=', $id)
                ->get();
            $var_url = "http://190.105.239.65:8080/agenda/inicio/".$id;
            foreach ($bdprincipal as $bdprincipales) {
                     //***COLOCAR EN UNA VARIABLE DE SESIÓN EL NOMBRE DE LA BD***
                     Session::put('str_bd',$bdprincipales->bd);
                     Session::put('url',$var_url);
                     Session::put('idmd5',$id);
                     $str_nom_agenda = $bdprincipales->bd;
            }
            //**********************BUSCO INFORMACION DEL TIPO DE PROFESIONAL******************
            $especialista = DB::connection(Session::get('str_bd'))
                ->table('tipoprofesional')
                ->select('id_tipoprofesional', 'descripcion')
                ->where('visibleweb', '=', 1)
                ->orderBy('descripcion', 'ASC')
                ->lists('descripcion', 'id_tipoprofesional');
            $especialistas = array('todos' => "Seleccione") + $especialista;
            
            $inicializar = array('Seleccione' => "Seleccione");
            $selected = array();
            return $this->layout->content = View::make('ageweb/filtrouno',compact('selected','especialistas','inicializar','id','str_nom_agenda'));
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();
                       
        }

        public function post_ajaxhorarios() {
        DB::beginTransaction();
        try {

            $inputs           = Input::All();
            $diasemana        = $inputs['data'][0];
            $dia              = $inputs['data'][1];
            $mes              = $inputs['data'][2];
            $ano              = $inputs['data'][3];
            $str_nom_agenda   = $inputs['data'][4];
            $int_medico       = $inputs['data'][5];
            $fecha_actual1    = $inputs['data'][6];

            //dd($fecha_actual1);
            //************************COLOCAR EL NRO DEL DIA DE LA SEMANA A LA QUE PERTENECE***
            if ($diasemana == "Domingo"){
                $diadelasemana = 0;
            }else if($diasemana == "Lunes"){
                $diadelasemana = 1;
            }else if($diasemana == "Martes"){
                $diadelasemana = 2;
            }else if($diasemana == "Miercoles"){
                $diadelasemana = 3;
            }else if($diasemana == "Jueves"){
                $diadelasemana = 4;
            }else if($diasemana == "Viernes"){
                $diadelasemana = 5;
            }else if($diasemana == "Sabado"){
                $diadelasemana = 6;
            } 
            //************************BUSCAR HORARIO SEGÚN EL DIA DE LA SEMANA SELECCIONADO****
            $horario_semanal2 = DB::connection($str_nom_agenda)
                ->table('intervalos3')
                ->select('*')
                ->where('id_medico', '=', $int_medico)
                ->where('dia', '=', $diadelasemana)
                ->get();
            //*************BUSCAR HORARIO ESPECIALES SEGÚN EL DIA DE LA SEMANA SELECCIONADO****
            $horario_semanal_especial = DB::connection($str_nom_agenda)
                ->table('horariosespeciales')
                ->select('*')
                ->where('id_medico', '=', $int_medico)
                ->where('dia', '=', $diadelasemana)
                ->get();
            //************************LLAMAR A LA VISTE Y PASARLE LOS ARRAY LIST***************
            $inicializar = array('Seleccione' => "Seleccione");
            $selected = array();
            return $this->layout->content = View::make('ageweb/horarios',compact('selected','inicializar','horario_semanal2','horario_semanal_especial','str_nom_agenda','int_medico','fecha_actual1','diadelasemana'));
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();
                       
        }

        public function post_ajaxmedicos() {
        DB::beginTransaction();
        try {

            $inputs             = Input::All();
            $str_nom_agenda     = $inputs['data'][0];
            $id_tipoprofesional = $inputs['data'][1];
            
            //dd(session::get('str_bd'));
            //**********************BUSCO INFORMACION DEL MEDICO*******************************
            $medico = DB::connection($str_nom_agenda)
                ->table('medicos')
                ->select('id_medico', 'nombre')
                ->where('id_tipoprofesional', '=', $id_tipoprofesional)
                ->where('visibleweb', '=', 1)
                ->where('sinagenda', '=', 0)
                ->where('activo', '=', 1)
                ->orderBy('nombre', 'ASC')
                ->lists('nombre', 'id_medico');
            $medicos = array('todos' => "Seleccione") + $medico;
            
            //************************LLAMAR A LA VISTE Y PASARLE LOS ARRAY LIST***************
            $inicializar = array('Seleccione' => "Seleccione");
            $selected = array();
            return $this->layout->content = View::make('ageweb/selectmedicos',compact('selected','inicializar','medicos'));
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();
                       
        }

//********************************************POR AQUI VOY ******************************************************************

        public function post_ajaxdisponibilidad() {
        DB::beginTransaction();
        try {
            $inputs           = Input::All();
            $str_nom_agenda   = $inputs['data'][0];
            $str_medico       = $inputs['data'][1];
            $str_especialista = $inputs['data'][2];
            $dia_hoy          = $inputs['data'][3];
            $fecha_actual     = $inputs['data'][4];

            //**********************BUSCO INFORMACION DEL MEDICO*******************************
            $medico = DB::connection($str_nom_agenda)
                ->table('medicos')
                ->select('id_medico', 'nombre', 'especialidad', 'id_tipoprofesional')
                ->where('id_medico', '=', $str_medico)
                ->where('id_tipoprofesional', '=', $str_especialista)
                ->get();
            foreach ($medico as $medicos) {
                $nom_medico       = $medicos->nombre;
                $nom_especialidad = $medicos->especialidad;
            } 

            //**********************BUSCAR PRÓXIMA HORA DISPONIBLE DEL MEDICO*******************
            $indice                = 2;
            $cont_horas            = 0;
            $hora_disponible       = 0;
            $sw_primero            = 0;
            $ctaregis              = 0;
            $dif_1                 = 0;
            
            //************************BUSCAR HORA DISPONIBLE***************************
                    //***CUENTA EL NRO DE REGISTRO*********************
                    $sqlcuenta = DB::connection($str_nom_agenda)
                            ->table('agenda')
                            ->select('fecha', 'hora', 'id_medico','dif')
                            ->where('id_medico', '=', $str_medico)
                            ->where('fecha', '=', $fecha_actual)
                            ->orderBy('hora', 'ASC')
                            ->get();

                    foreach ($sqlcuenta as $sqlcuenta2) {$ctaregis ++;}
                    //*************************************************
                     
                    $hora_disp = DB::connection($str_nom_agenda)
                            ->table('agenda')
                            ->select('fecha', 'hora', 'id_medico','dif')
                            ->where('id_medico', '=', $str_medico)
                            ->where('fecha', '=', $fecha_actual)
                            ->orderBy('hora', 'ASC')
                            ->get();
                    
                    if ($ctaregis > 0){
                    
                    foreach ($hora_disp as $hora_disponibles) {
                            $dif_1                 = $hora_disponibles->dif;
                            $hora_agenda           = substr($hora_disponibles->hora,11,5);
                            $minutoAnadir          = $hora_disponibles->dif;
                            $segundos_horaInicial  = strtotime($hora_agenda);
                            $segundos_minutoAnadir = $minutoAnadir*60;
                            $nuevaHora             = date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);
                            $buscarnuevaHora       = "1899-12-30 ".$nuevaHora.":00.000";

                            $var = "h".$indice;
                            $sw = 0;                         
                        
                             $hora_disp2 = DB::connection($str_nom_agenda)
                            ->table('agenda')
                            ->select('fecha', 'hora', 'id_medico')
                            ->where('id_medico', '=', $str_medico)
                            ->where('fecha', '=', $fecha_actual)
                            ->where('hora', '=', $buscarnuevaHora)
                            ->orderBy('hora', 'ASC')
                            ->get();
                            //***FOREACH PARA SABER SI YA ESTÁ AGENDADO***
                            foreach ($hora_disp2 as $hora_disp23) {               
                                     $sw = 1;
                            $cont_horas ++;
                            }
                            //***SI NO ESTÁ AGENDADO HACE ESTO***
                            if ($sw == 0 ){
                                $hora_disponible = $nuevaHora;
                                $hora_intervalo  = 0;
                                $sw_intervalos   = 0;
                                //***BUSCAR LOS PARAMETROS EN INTERVALOS3 PARA REALIZAR LA BUSQUEDA FINAL***
                                $cont_intervalos = 0;
                                $horario_semanal = DB::connection($str_nom_agenda)
                                        ->table('intervalos3')
                                        ->select('*')
                                        ->where('id_medico', '=', $str_medico)
                                        ->where('dia', '=', $dia_hoy)
                                        ->get();
                                $intervalos = 2;
                                foreach ($horario_semanal as $horario_semanales) {               
                                         $cta = $horario_semanales->Cta;
                                         $ht1 = $horario_semanales->ht1;
                                         while ($intervalos <= $cta) {
                                                $h = "h".$intervalos;
                                                //***SE VUELVE A BUSCAR LA HORA EN LA TABLA INTERVALOS3***
                                                $horario_semanal2 = DB::connection($str_nom_agenda)
                                                            ->table('intervalos3')
                                                            ->select('*')
                                                            ->where('id_medico', '=', $str_medico)
                                                            ->where('dia', '=', $dia_hoy)
                                                            ->where($h, '=', $hora_disponible)
                                                            ->get();
                                                foreach ($horario_semanal2 as $horario_semanales23) {               
                                                         $hora_intervalo = $hora_disponible;
                                                         $sw_intervalos = 1;
                                                         
                                                }
                                                //***SE SUMAN LAS HORAS CON EL HORARIO DE LA TARDE***
                                                if ($sw_intervalos == 0){
                                                    $minutoAnadir          = $hora_disponibles->dif;
                                                    $segundos_horaInicial  = strtotime($ht1);
                                                    $segundos_minutoAnadir = $minutoAnadir*60;
                                                    $nuevaHora2 = date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);
                                                    $hora_intervalo        = $nuevaHora2;
                                                    
                                                    
                                                }
                                                //***FIN DE BÚSQUEDA EN LA TABLA INTERVALOS3***************
                                         $intervalos ++;   
                                         }
                                         //***GUARDAR LA PRIMERA HORA DISPONIBLE***************
                                         if ($sw_intervalos == 1 && $sw_primero == 0){
                                             $hora_intervalo1 = $hora_disponible;
                                         }else if ($sw_intervalos == 0 && $sw_primero == 0){
                                                      $hora_intervalo1 = $nuevaHora2;
                                               }
                                         //*****************************************************
                                }
                            $sw_primero = 1;
                            }//***LLAVE DEL IF
                    //dd($hora_disponibles);
                    $indice ++;       
                    }

                     //***CIERRE DEL IF QUE CUENTA SI HAY REGISTROS***
                    }   else{//***SE BUSCA DONDE COMIENZA EL HORARIO DEL MÉDICO EN CASO QUE NO EXISTE NINGÚN AGENDAMIENTO***

                                                $horario_semanal3 = DB::connection($str_nom_agenda)
                                                            ->table('intervalos3')
                                                            ->select('*')
                                                            ->where('id_medico', '=', $str_medico)
                                                            ->where('dia', '=', $dia_hoy)
                                                            ->get();

                                                foreach ($horario_semanal3 as $horario_semanal33) {               
                                                         $h1    = $horario_semanal33->h1;
                                                         $h2    = $horario_semanal33->h2;
                                                         $cta   = $horario_semanal33->Cta;
                                                         $dif_1 = $horario_semanal33->intervalo;
                                                         if ($h1 == "I"){
                                                             $hora_intervalo1 = $h2; 
                                                         }else if ($h1 == "N"){
                                                                   $hora_intervalo1 = $h2;
                                                                }
                                                         
                                                } 
                        }
            //****VALIDAR SI EXISTE HORARIO DEFINIDO PARA ESTE DÍA****************************
            if ($cta == 0){$hora_intervalo1 = "00:00:00.000";}                        
            //************************LLAMAR A LA VISTE Y PASARLE LOS ARRAY LIST***************
            $inicializar = array('Seleccione' => "Seleccione");
            $selected = array();
            //***COLOCAR EN UNA VARIABLE DE SESIÓN EL NOMBRE DE LA BD***
            Session::put('hora_disp1',$hora_intervalo1);
            Session::put('fecha_disp1',$fecha_actual);
            Session::put('id_medico1',$str_medico);
            Session::put('id_especialidad1',$str_especialista);
            Session::put('dif',$dif_1);
            
            //***FIN DE CREAR VARIABLES DE SESIÓN***********************
            return $this->layout->content = View::make('ageweb/disponibilidad',compact('selected','inicializar','nom_medico','nom_especialidad','fecha_actual','hora_intervalo1'));
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();
                       
        }

        //***********************MUESTRA LOS MÉDICOS DE LA SEGUNDA NAVENGACIÓN DE LA AGENDA****
        public function post_ajaxmedicosagenda() {
        DB::beginTransaction();
        try {

            $inputs             = Input::All();
            $str_nom_agenda     = $inputs['data'][0];
            $id_tipoprofesional = $inputs['data'][1];
            
            //dd(session::get('str_bd'));
            //**********************BUSCO INFORMACION DEL MEDICO*******************************
            $medico = DB::connection($str_nom_agenda)
                ->table('medicos')
                ->select('id_medico', 'nombre')
                ->where('id_tipoprofesional', '=', $id_tipoprofesional)
                ->where('visibleweb', '=', 1)
                ->where('sinagenda', '=', 0)
                ->where('activo', '=', 1)
                ->orderBy('nombre', 'ASC')
                ->lists('nombre', 'id_medico');
            $medicos = array('todos' => "Seleccione") + $medico;
            
            //************************LLAMAR A LA VISTE Y PASARLE LOS ARRAY LIST***************
            $inicializar = array('Seleccione' => "Seleccione");
            $selected = array();
            return $this->layout->content = View::make('ageweb/selectmedicosagenda',compact('selected','inicializar','medicos'));
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();
                       
        }

        //*******************PARA ACTUALIZAR EL CALENDARIO A LOS NVOS FILTROS DE AGENDA*******
        public function get_agendamientoagenda() {
        DB::beginTransaction();
        try {
            //**********************VERIFICAR LOS DATOS QUE VIENEN POR GET*************
            $id_medico      = Input::get('str_medico');
            $str_nom_agenda = Input::get('str_nom_agenda');
            //**********************BUSCO INFORMACION DEL TIPO DE PROFESIONAL******************
            $especialista = DB::connection(Session::get('str_bd'))
                ->table('tipoprofesional')
                ->select('id_tipoprofesional', 'descripcion')
                ->where('visibleweb', '=', 1)
                ->orderBy('descripcion', 'ASC')
                ->lists('descripcion', 'id_tipoprofesional');
            $especialistas = array('todos' => "Seleccione") + $especialista;
            //**********************BUSCO HORARIO DEL PROFESIONAL******************
            $hora = DB::connection(Session::get('str_bd'))
                ->table('intervalos3')
                ->select('dia', 'Cta', 'id_medico')
                ->where('id_medico', '=', $id_medico)
                ->where('Cta', '=', 0)
                ->orderBy('dia', 'ASC')
                ->get();
            $horarios = "";
            foreach ($hora as $horas) {
                $int_dia = $horas->dia;
                $int_cta = $horas->Cta;
                //***************SE CONSTRUYE LA VARIABLE DE DIAS NO LABORABLES****
                if ($int_dia==1) {
                    $horarios = "1"; 
                }else if ($int_dia==2) {
                    $horarios = $horarios.","."2"; 
                }else if ($int_dia==3) {
                    $horarios = $horarios.","."3"; 
                }else if ($int_dia==4) {
                    $horarios = $horarios.","."4"; 
                }else if ($int_dia==5) {
                    $horarios = $horarios.","."5"; 
                }else if ($int_dia==6) {
                    $horarios = $horarios.","."6"; 
                }else if ($int_dia==7) {
                    $horarios = $horarios.","."0"; 
                }                
            }
            $horariofinal = "[".$horarios."]";
            //******************BUSCAR INFORMACIÓN DE CONSIDERACIONES*************
            $str_consideracion = DB::connection('agendappal')
                ->table('basedatos')
                ->select('*')
                ->where('md5', '=', Session::get('idmd5'))
                ->get();
            foreach ($str_consideracion as $str_consideraciones) {
                     $str_consideraciones = $str_consideraciones->infoagendamiento2;
            }
            $var_array_consideraciones = (explode("/",$str_consideraciones));
            //*******************BUSCA FONOS**************************************
            $str_fono = DB::connection('agendappal')
                ->table('basedatos')
                ->select('*')
                ->where('md5', '=', Session::get('idmd5'))
                ->get();
            foreach ($str_fono as $str_fonos) {
                     $str_fonos = $str_fonos->fonos;
            }
            //************************************************************************            
            $inicializar = array('todos' => "Seleccione");
            $selected = array();
            return $this->layout->content = View::make('ageweb/agenda',compact('selected','inicializar','horariofinal','str_nom_agenda','especialistas','id_medico','var_array_consideraciones','str_fonos'));
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();
                       
        }

        //**********************GUARDAR EL USUARIO Y REALIZAR LA RESERVA DE LA HORA*****

        public function post_guardarregistroreserva() {
        //***VALIDAR LOS CAMPOS QUE SE REQUIEREN*******************************************
        $inputs = Input::All();
        $reglas = array
            (
            'str_rut'       => 'required' ,
            'str_nombre'    => 'required' ,
            'str_paterno'   => 'required|alpha' ,
            'str_materno'   => 'required|alpha' ,
            'str_tlf'       => 'required|numeric' ,
            'str_celular'   => 'required|numeric' ,
            'str_email'     => 'required|email' ,
            'calendario'    => 'required' ,
            'str_password'  => 'required|min:5',
            'str_password2' => 'required|min:5'
        );
        $mensajes = array(
            "required" => "Es Obligatorio",
            "min"      => "M&iacute;nimo 5 Caracteres",
            "email"    => "Email no valido",
            "alpha"    => "Solo letras",
            "numeric"  => "Solo numeros",
        );
        $validar = Validator::make($inputs, $reglas, $mensajes);
        if ($validar->fails()) {
            return Redirect::back()->withErrors($validar);
        } else {
                //***GUARDA REGISTRO DEL USUARIO Y ENVÍA CORREO DE RESERVA******************
                $str_rut                  = $_POST['str_rut'];
                $str_nombre               = $_POST['str_nombre'];
                $str_paterno              = $_POST['str_paterno'];
                $str_materno              = $_POST['str_materno'];
                $calendario               = $_POST['calendario'];
                $str_sexo                 = $_POST['str_sexo'];
                $str_previsiones          = $_POST['str_previsiones'];                
                $str_tlf                  = $_POST['str_tlf'];
                $str_celular              = $_POST['str_celular'];
                $str_email                = $_POST['str_email'];
                $str_password             = $_POST['str_password'];
                $sw_registros             = 0;
                $sw_registros_usuario_web = 0;

                //**********************VERIFICA QUE BD ESTA ACTIVA************************
                $bdprincipal = DB::connection('agendappal')
                    ->table('usuarios')
                    ->select('dsnagenda', 'dsnficha')
                    ->where('dsnagenda', '=', Session::get('str_bd'))
                    ->get();
                foreach ($bdprincipal as $bdprincipales) {
                         //***COLOCAR EN UNA VARIABLE DE SESIÓN EL NOMBRE DE LA BD***
                         Session::put('str_ficha',$bdprincipales->dsnficha);
                }
       
                //***VERIFICA SI EL REGISTRO YA SE ENCUENTRA EN LA BD****
                $verifica_existe = DB::connection(Session::get('str_ficha'))
                    ->table('kardex')
                    ->select('RUT', 'Nombres')
                    ->where('RUT', '=', $str_rut)
                    ->get();
               
                foreach ($verifica_existe as $verifica_existes) {
                    $sw_registros = 1;
                    //echo "<script>alert('Su registro ya se encuentra en nuestra base de datos'); window.location='registrarse';</script>";
                }
                //***FIN DE REGISTRO*****************************************************
                if ($sw_registros == 0){
                    //***GUARDO EN LA TABLA KARDEX DE LA BD CORRESPONDIENTE***
                    DB::connection(Session::get('str_ficha')) 
                       ->table('kardex')->insert(
                            array('RUT'      => $str_rut,
                           'Nombres'         => $str_nombre,
                           'Appat'           => $str_paterno,
                           'Apmat'           => $str_materno,
                           'FechaNacimiento' => $calendario,
                           'Sexo'            => $str_sexo,
                           'prevision'       => $str_previsiones,                       
                           'fono'            => $str_tlf,
                           'celu'            => $str_celular,
                           'email'           => $str_email,
                           'clave'           => $str_password,
                            )
                    );
                }//***CIERRO LLAVES DEL IF***

                //***VERIFICA SI EL REGISTRO YA SE ENCUENTRA EN LA BD DE USUARIO UNICOS WEB*************
                $verifica_existe_usuario_web = DB::connection('usuarios_web')
                    ->table('tb_usuarios')
                    ->select('str_rut', 'str_username')
                    ->where('str_rut', '=', $str_rut)
                    ->get();
               
                foreach ($verifica_existe_usuario_web as $verifica_existe_usuario_web1) {
                         $sw_registros_usuario_web = 1;
                }
                //***IF PARA VERIFICAR EL USUARIO***
                if ($sw_registros_usuario_web == 0){
                    $var_strbd1 = Session::get('str_bd');
                    $var_strba2 = Session::get('str_ficha');
                    //***GUARDO EN LA TABLA USUARIOS DE LA BD usuarios_web***
                    DB::connection('usuarios_web') 
                       ->table('tb_usuarios')->insert(
                            array('str_rut'  => $str_rut,
                           'str_username'    => $str_email,
                           'str_password'    => $str_password,
                           'str_descripcion' => $str_nombre,
                           'str_email'       => $str_email,
                           'str_agenda'      => $var_strbd1,
                           'str_ficha'       => $var_strba2,
                           'int_estado'      => 1,                       
                           'int_acceso'      => 1,
                            )
                    );
                }//****CIERRO LLAVES DEL IF QUE VERIFICA SI YA EXISTE EL USUARIO WEB EN LA TABLA UNICA***

                //***AQUI SE DEBE AGENDAR LA HORA***
                //Session::get('str_bd')
                //dd($str_rut);
                $desc      = "Agendamiento Web";
                $horario   = "N";
                $dif       = Session::get('dif');
                $fecha     = Session::get('fecha_disp1');
                $hora      = "1899-12-30"." ".Session::get('hora_disp1');
                $id_medico = Session::get('id_medico1');
                $nombres   = $str_nombre." ".$str_paterno." ".$str_materno;
                DB::connection(Session::get('str_bd')) 
                   ->table('agenda')->insert(
                        array('RUT'    => $str_rut,
                       'fecha'         => $fecha,
                       'hora'          => $hora,
                       'id_medico'     => $id_medico,
                       'prevision'     => $str_previsiones,
                       'edad'          => 0,
                       'nombre'        => $nombres,
                       'fenac'         => $calendario,
                       'sexo'          => $str_sexo,
                       'fono'          => $str_celular,
                       'web'           => 1,
                       'sector'        => 0,
                       'beneficiario'  => 0,
                       'pago'          => 0,
                       'tipo_cons'     => 0,
                       'present'       => 0,
                       'atendido'      => 0,
                       'confirma'      => 0,
                       'fechahoracrea' => $fecha,
                       'tipo'          => 2,
                       'desc'          => $desc,
                       'id_usuario'    => 1,
                       'horario'       => $horario,
                       'dif'           => $dif,
                       'tipohorario'   => 0,
                       )
                );

                //***ENVIAR CORREO DE AGENDAMIENTO**************************
                    $id_reserva = DB::connection(Session::get('str_bd'))
                                        ->table('agenda')
                                        ->select('*')
                                        ->where('fecha', '=', $fecha)
                                        ->where('hora', '=', $hora)
                                        ->where('id_medico', '=', $id_medico)
                                        ->get();
                       
                    foreach ($id_reserva as $id_reservas) {
                             $id_reserva = $id_reservas->id;
                             //**********************BUSCO INFORMACION DEL MEDICO*******************************
                             $medico = DB::connection(Session::get('str_bd'))
                                ->table('medicos')
                                ->select('id_medico', 'nombre', 'especialidad', 'id_tipoprofesional')
                                ->where('id_medico', '=', $id_medico)
                                ->get();
                             foreach ($medico as $medicos) {
                                $nom_medico       = $medicos->nombre;
                                $nom_especialidad = $medicos->especialidad;
                             }

                    }

                    //***ENVIAR CORREO DE CONFIRMACIÓN****
                    $data2 = array
                        ('id_reserva'   => $id_reserva,
                         'md5'          => Session::get('idmd5'),
                         'hora'         => Session::get('hora_disp1'),
                    );
                    $fromEmail = 'infowebmedicas@gmail.com';
                    $fromName  = 'Confirmar Agendamiento Webmédica';
                    $toEmail   = $str_email;
                    $toName    = '';

                    Mail::send('emails.confirmarhora', $data2, function($message) use ($fromName, $fromEmail, $toEmail, $toName) {
                        $message->to($toEmail, $toName);  
                        $message->from($fromEmail, $fromName);
                        $message->subject('Confirmación de Hora Médica');
                    });
                    //***FIN CORREO DE CONFIRMACIÓN***

                    //***ENVIAR CORREO DE RESERVA****
                    $data = array
                        ('id_reserva'   => $id_reserva,
                         'str_medico'   => $nom_medico,
                         'fecha'        => Session::get('fecha_disp1'),
                         'hora'         => Session::get('hora_disp1'),
                         'especialidad' => $nom_especialidad
                    );
                    $fromEmail = 'infowebmedicas@gmail.com';
                    $fromName  = 'Agendamiento Webmédica';
                    $toEmail   = $str_email;
                    $toName    = '';

                    Mail::send('emails.mailagendamiento', $data, function($message) use ($fromName, $fromEmail, $toEmail, $toName) {
                        $message->to($toEmail, $toName);  
                        $message->from($fromEmail, $fromName);
                        $message->subject('Reserva de Hora Médica');
                    });
                    //***FIN CORREO DE RESERVA***
                    
                //**************************************************************************
                return $this->layout->content = View::make('ageweb/guardarregistro');
            }//***LLAVE DEL IF DE VALIDAR DATOS


 }

//*****************************************REALIZAR EL LOGIN********************************
 public function post_postlogin() {
    //***VALIDAR LOS CAMPOS QUE SE REQUIEREN*******************************************
        $inputs = Input::All();
        $reglas = array
            (
            'str_usuario' => 'required' ,
            'password'    => 'required|min:8'
        );
        $mensajes = array(
            "required" => "Es Obligatorio",
            "min"      => "M&iacute;nimo 8 Caracteres",
        );
        $validar = Validator::make($inputs, $reglas, $mensajes);
        if ($validar->fails()) {
            return Redirect::back()->withErrors($validar);
        } else {
                //***RECIBO LAS VARIABLES***
                $str_nom_agenda_login = Input::get('str_nom_agenda_login'); 
                $str_usuario          = Input::get('str_usuario'); 
                $password             = Input::get('password'); 
                $sw_usuario_web       = 0;  
                //***BUSCAR EL USUARIO Y PASSWORD**********************
                $post_usuario = DB::connection('usuarios_web')
                        ->table('tb_usuarios')
                        ->select('*')
                        ->where('str_username', '=', $str_usuario)
                        ->where('str_password', '=', $password)
                        ->where('int_estado', '=', 1)
                        ->get();

                foreach ($post_usuario as $post_usuarios) {
                         $str_rut_login = $post_usuarios->str_rut;
                         //***ACTIVO EL USUARIO*** 
                         $sw_usuario_web = 1;
                }
                //dd($sw_usuario_web);
                //***REALIZO LA ACCIÓN RESPECTIVA SEGÚN EL SW***
                if ($sw_usuario_web == 1){
                    //***BUSCAR BD QUE SE ENCUENTRA ACTIVA*************************
                    $bdprincipallogin = DB::connection('agendappal')
                        ->table('usuarios')
                        ->select('dsnagenda', 'dsnficha')
                        ->where('dsnagenda', '=', Session::get('str_bd'))
                        ->get();
                    foreach ($bdprincipallogin as $bdprincipallogins) {
                             //***COLOCAR EN UNA VARIABLE DE SESIÓN EL NOMBRE DE LA BD***
                             $bd_ficha = $bdprincipallogins->dsnficha;
                    }
                    //***BUSCAR LOS DATOS PERSONALES PARA EL AGENDAMIENTO**********
                    $dato_personal = DB::connection($bd_ficha)
                        ->table('kardex')
                        ->select('*')
                        ->where('RUT', '=', $str_rut_login)
                        ->get();
                    foreach ($dato_personal as $datos_personales) {
                             //***ASIGNAR INFORMACIÓN NECESARIA***
                             $nombres   = $datos_personales->Nombres." ".$datos_personales->Appat." ".$datos_personales->Apmat;
                             $fec_nac   = $datos_personales->FechaNacimiento;
                             $sexo      = $datos_personales->Sexo;
                             $prevision = $datos_personales->prevision;
                             $celular   = $datos_personales->celu;
                             $email     = $datos_personales->email;
                    }
                    //***REALIZAR EL AGENDAMIENTO**********************************
                    $desc      = "Agendamiento Web";
                    $horario   = "N";
                    $dif       = Session::get('dif');
                    $fecha     = Session::get('fecha_disp1');
                    $hora      = "1899-12-30"." ".Session::get('hora_disp1');
                    $id_medico = Session::get('id_medico1');
                    //dd($email);
                    DB::connection(Session::get('str_bd')) 
                       ->table('agenda')->insert(
                            array('RUT'    => $str_rut_login,
                           'fecha'         => $fecha,
                           'hora'          => $hora,
                           'id_medico'     => $id_medico,
                           'prevision'     => $prevision,
                           'edad'          => 0,
                           'nombre'        => $nombres,
                           'fenac'         => $fec_nac,
                           'sexo'          => $sexo,
                           'fono'          => $celular,
                           'web'           => 1,
                           'sector'        => 0,
                           'beneficiario'  => 0,
                           'pago'          => 0,
                           'tipo_cons'     => 0,
                           'present'       => 0,
                           'atendido'      => 0,
                           'confirma'      => 0,
                           'fechahoracrea' => $fecha,
                           'tipo'          => 2,
                           'desc'          => $desc,
                           'id_usuario'    => 1,
                           'horario'       => $horario,
                           'dif'           => $dif,
                           'tipohorario'   => 0,
                           )
                    );
                    //***FIN DEL AGENDAMIENTO***********************************

                    //***ENVIAR CORREO DE AGENDAMIENTO**************************
                    $id_reserva = DB::connection(Session::get('str_bd'))
                                        ->table('agenda')
                                        ->select('*')
                                        ->where('fecha', '=', $fecha)
                                        ->where('hora', '=', $hora)
                                        ->where('id_medico', '=', $id_medico)
                                        ->get();
                       
                    foreach ($id_reserva as $id_reservas) {
                             $id_reserva = $id_reservas->id;
                             //**********************BUSCO INFORMACION DEL MEDICO*******************************
                             $medico = DB::connection(Session::get('str_bd'))
                                ->table('medicos')
                                ->select('id_medico', 'nombre', 'especialidad', 'id_tipoprofesional')
                                ->where('id_medico', '=', $id_medico)
                                ->get();
                             foreach ($medico as $medicos) {
                                $nom_medico       = $medicos->nombre;
                                $nom_especialidad = $medicos->especialidad;
                             }

                    }
                    //***FIN DE BUSCAR LA INFORMACIÓN******************

                    //***ENVIAR CORREO DE CONFIRMACIÓN****
                    $data2 = array
                        ('id_reserva'   => $id_reserva,
                         'md5'          => Session::get('idmd5'),
                         'hora'         => Session::get('hora_disp1'),
                    );
                    $fromEmail = 'infowebmedicas@gmail.com';
                    $fromName  = 'Confirmar Agendamiento Webmédica';
                    $toEmail   = $email;
                    $toName    = '';

                    Mail::send('emails.confirmarhora', $data2, function($message) use ($fromName, $fromEmail, $toEmail, $toName) {
                        $message->to($toEmail, $toName);  
                        $message->from($fromEmail, $fromName);
                        $message->subject('Confirmación de Hora Médica');
                    });
                    //***FIN CORREO DE CONFIRMACIÓN***

                    //***ENVIAR EL CORREO DEL AGENDAMIENTO*************
                    $data = array
                        ('id_reserva'   => $id_reserva,
                         'str_medico'   => $nom_medico,
                         'fecha'        => Session::get('fecha_disp1'),
                         'hora'         => Session::get('hora_disp1'),
                         'especialidad' => $nom_especialidad
                    );
                    $fromEmail = 'infowebmedicas@gmail.com';
                    $fromName  = 'Agendamiento Webmédica';
                    $toEmail   = $email;
                    $toName    = '';

                    Mail::send('emails.mailagendamiento', $data, function($message) use ($fromName, $fromEmail, $toEmail, $toName) {
                        $message->to($toEmail, $toName);  
                        $message->from($fromEmail, $fromName);
                        $message->subject('Reserva de Hora Médica');
                    });   
                    //***MOSTRAR LA VISTA QUE FUE EXITOSO EL AGENDAMIENTO*******
                    return $this->layout->content = View::make('ageweb/guardarregistro');
                }else if ($sw_usuario_web == 0){
                    //***ENVIAR UN MSJ QUE NO SE ENCUENTRA REGISTRADO
                          return $this->layout->content = View::make('ageweb/noexitoso');
                }
                }//***FIN DE VALIDAR LOS CAMPOS DEL FORMULARIO***  
     //***FIN DEL MÉTODO***                     
 }
 //*****************************************REALIZAR EL LOGIN********************************
 public function post_login2() {
 DB::beginTransaction();
        try {
        //**************ASIGNAR LAS VARIABLES POST QUE VIENEN DEL FORMULARIO*****************
        $hora_agendar2         = Input::get('str_campo_hora');
        $dif_agenda_hora2      = Input::get('dif_agenda_hora'); 
        $fecha_agenda_hora2    = Input::get('fecha_agenda_hora');
        $idmedico_agenda_hora2 = Input::get('idmedico_agenda_hora');
        //***COLOCAR ESTOS DATOS EN VARIABLES DE SESIÓN PARA GUARDARLOS**********************
        Session::put('hora_agendar2',$hora_agendar2);
        Session::put('dif_agenda_hora2',$dif_agenda_hora2); 
        Session::put('fecha_agenda_hora2',$fecha_agenda_hora2); 
        Session::put('idmedico_agenda_hora2',$idmedico_agenda_hora2);  
        //dd(Session::get('idmedico_agenda_hora2'));
        return $this->layout->content = View::make('ageweb/login2');
 } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();
 }

 //*****************************************REALIZAR SEGUNDO LOGIN Y AGENDAMIENTO****************************
 public function post_postlogin2() {
    //***RECIBO LAS VARIABLES***
                $str_nom_agenda_login = Input::get('str_nom_agenda_login'); 
                $str_usuario          = Input::get('str_usuario2'); 
                $password             = Input::get('password2'); 
                $sw_usuario_web       = 0;  
                //***BUSCAR EL USUARIO Y PASSWORD**********************
                $post_usuario = DB::connection('usuarios_web')
                        ->table('tb_usuarios')
                        ->select('*')
                        ->where('str_username', '=', $str_usuario)
                        ->where('str_password', '=', $password)
                        ->where('int_estado', '=', 1)
                        ->get();

                foreach ($post_usuario as $post_usuarios) {
                         $str_rut_login = $post_usuarios->str_rut;
                         //***ACTIVO EL USUARIO*** 
                         $sw_usuario_web = 1;
                }
                //dd($sw_usuario_web);
                //***REALIZO LA ACCIÓN RESPECTIVA SEGÚN EL SW***
                if ($sw_usuario_web == 1){
                    //***BUSCAR BD QUE SE ENCUENTRA ACTIVA*************************
                    $bdprincipallogin = DB::connection('agendappal')
                        ->table('usuarios')
                        ->select('dsnagenda', 'dsnficha')
                        ->where('dsnagenda', '=', Session::get('str_bd'))
                        ->get();
                    foreach ($bdprincipallogin as $bdprincipallogins) {
                             //***COLOCAR EN UNA VARIABLE DE SESIÓN EL NOMBRE DE LA BD***
                             $bd_ficha = $bdprincipallogins->dsnficha;
                    }
                    //***BUSCAR LOS DATOS PERSONALES PARA EL AGENDAMIENTO**********
                    $dato_personal = DB::connection($bd_ficha)
                        ->table('kardex')
                        ->select('*')
                        ->where('RUT', '=', $str_rut_login)
                        ->get();
                    foreach ($dato_personal as $datos_personales) {
                             //***ASIGNAR INFORMACIÓN NECESARIA***
                             $nombres   = $datos_personales->Nombres." ".$datos_personales->Appat." ".$datos_personales->Apmat;
                             $fec_nac   = $datos_personales->FechaNacimiento;
                             $sexo      = $datos_personales->Sexo;
                             $prevision = $datos_personales->prevision;
                             $celular   = $datos_personales->celu;
                             $email     = $datos_personales->email;
                    }
                    //***REALIZAR EL AGENDAMIENTO**********************************
                    $desc      = "Agendamiento Web";
                    $horario   = "N";
                    $dif       = Session::get('dif_agenda_hora2');
                    $fecha     = Session::get('fecha_agenda_hora2');
                    $hora      = "1899-12-30"." ".Session::get('hora_agendar2');
                    $id_medico = Session::get('idmedico_agenda_hora2');
                    //dd($email);

                    DB::connection(Session::get('str_bd')) 
                       ->table('agenda')->insert(
                            array('RUT'    => $str_rut_login,
                           'fecha'         => $fecha,
                           'hora'          => $hora,
                           'id_medico'     => $id_medico,
                           'prevision'     => $prevision,
                           'edad'          => 0,
                           'nombre'        => $nombres,
                           'fenac'         => $fec_nac,
                           'sexo'          => $sexo,
                           'fono'          => $celular,
                           'web'           => 1,
                           'sector'        => 0,
                           'beneficiario'  => 0,
                           'pago'          => 0,
                           'tipo_cons'     => 0,
                           'present'       => 0,
                           'atendido'      => 0,
                           'confirma'      => 0,
                           'fechahoracrea' => $fecha,
                           'tipo'          => 2,
                           'desc'          => $desc,
                           'id_usuario'    => 1,
                           'horario'       => $horario,
                           'dif'           => $dif,
                           'tipohorario'   => 0,
                           )
                    );
                    //***FIN DEL AGENDAMIENTO***********************************

                    //***ENVIAR CORREO DE AGENDAMIENTO**************************
                    $id_reserva = DB::connection(Session::get('str_bd'))
                                        ->table('agenda')
                                        ->select('*')
                                        ->where('fecha', '=', $fecha)
                                        ->where('hora', '=', $hora)
                                        ->where('id_medico', '=', $id_medico)
                                        ->get();
                       
                    foreach ($id_reserva as $id_reservas) {
                             $id_reserva = $id_reservas->id;
                             //**********************BUSCO INFORMACION DEL MEDICO*******************************
                             $medico = DB::connection(Session::get('str_bd'))
                                ->table('medicos')
                                ->select('id_medico', 'nombre', 'especialidad', 'id_tipoprofesional')
                                ->where('id_medico', '=', $id_medico)
                                ->get();
                             foreach ($medico as $medicos) {
                                $nom_medico       = $medicos->nombre;
                                $nom_especialidad = $medicos->especialidad;
                             }

                    }
                    //***FIN DE BUSCAR LA INFORMACIÓN******************

                    //***ENVIAR CORREO DE CONFIRMACIÓN****
                    $data2 = array
                        ('id_reserva'   => $id_reserva,
                         'md5'          => Session::get('idmd5'),
                         'hora'         => Session::get('hora_disp1'),
                    );
                    $fromEmail = 'infowebmedicas@gmail.com';
                    $fromName  = 'Confirmar Agendamiento Webmédica';
                    $toEmail   = $email;
                    $toName    = '';

                    Mail::send('emails.confirmarhora', $data2, function($message) use ($fromName, $fromEmail, $toEmail, $toName) {
                        $message->to($toEmail, $toName);  
                        $message->from($fromEmail, $fromName);
                        $message->subject('Confirmación de Hora Médica');
                    });
                    //***FIN CORREO DE CONFIRMACIÓN***

                    //***ENVIAR CORREO DE AGENDAMIENTO**************************
                    $id_reserva = DB::connection(Session::get('str_bd'))
                                        ->table('agenda')
                                        ->select('*')
                                        ->where('fecha', '=', $fecha)
                                        ->where('hora', '=', $hora)
                                        ->where('id_medico', '=', $id_medico)
                                        ->get();
                       
                    foreach ($id_reserva as $id_reservas) {
                             $id_reserva = $id_reservas->id;
                             //**********************BUSCO INFORMACION DEL MEDICO*******************************
                             $medico = DB::connection(Session::get('str_bd'))
                                ->table('medicos')
                                ->select('id_medico', 'nombre', 'especialidad', 'id_tipoprofesional')
                                ->where('id_medico', '=', $id_medico)
                                ->get();
                             foreach ($medico as $medicos) {
                                $nom_medico       = $medicos->nombre;
                                $nom_especialidad = $medicos->especialidad;
                             }

                    }

                    $data = array
                        ('id_reserva'   => $id_reserva,
                         'str_medico'   => $nom_medico,
                         'fecha'        => Session::get('fecha_agenda_hora2'),
                         'hora'         => Session::get('hora_agendar2'),
                         'especialidad' => $nom_especialidad
                    );
                    $fromEmail = 'infowebmedicas@gmail.com';
                    $fromName  = 'Agendamiento Webmédica';
                    $toEmail   = $email;
                    $toName    = '';

                    Mail::send('emails.mailagendamiento', $data, function($message) use ($fromName, $fromEmail, $toEmail, $toName) {
                        $message->to($toEmail, $toName);  
                        $message->from($fromEmail, $fromName);
                        $message->subject('Reserva de Hora Médica');
                    });   
                    //***MOSTRAR LA VISTA QUE FUE EXITOSO EL AGENDAMIENTO*******
                    return $this->layout->content = View::make('ageweb/guardarregistro');
                }else if ($sw_usuario_web == 0){
                    //***ENVIAR UN MSJ QUE NO SE ENCUENTRA REGISTRADO
                          return $this->layout->content = View::make('ageweb/noexitoso');
                }
}//***FIN DEL MÉTODO***

//***********************GUARDAR CUANDO LA FECHA ES SELECCIONADA POR EL USUARIO EN LA AGENDA************
 public function post_segundoguardarregistroreserva() {
        //***VALIDAR LOS CAMPOS QUE SE REQUIEREN*******************************************
        $inputs = Input::All();
        $reglas = array
            (
            'str_rut'       => 'required' ,
            'str_nombre'    => 'required' ,
            'str_paterno'   => 'required|alpha' ,
            'str_materno'   => 'required|alpha' ,
            'str_tlf'       => 'required|numeric' ,
            'str_celular'   => 'required|numeric' ,
            'str_email'     => 'required|email' ,
            'calendario'    => 'required' ,
            'str_password'  => 'required|min:5',
            'str_password2' => 'required|min:5'
        );
        $mensajes = array(
            "required" => "Es Obligatorio",
            "min"      => "M&iacute;nimo 5 Caracteres",
            "email"    => "Email no valido",
            "alpha"    => "Solo letras",
            "numeric"  => "Solo numeros",
        );
        $validar = Validator::make($inputs, $reglas, $mensajes);
        if ($validar->fails()) {
            return Redirect::back()->withErrors($validar);
        } else {
                //***GUARDA REGISTRO DEL USUARIO Y ENVÍA CORREO DE RESERVA******************
                $str_rut                  = $_POST['str_rut'];
                $str_nombre               = $_POST['str_nombre'];
                $str_paterno              = $_POST['str_paterno'];
                $str_materno              = $_POST['str_materno'];
                $calendario               = $_POST['calendario'];
                $str_sexo                 = $_POST['str_sexo'];
                $str_previsiones          = $_POST['str_previsiones'];                
                $str_tlf                  = $_POST['str_tlf'];
                $str_celular              = $_POST['str_celular'];
                $str_email                = $_POST['str_email'];
                $str_password             = $_POST['str_password'];
                $sw_registros             = 0;
                $sw_registros_usuario_web = 0;

                //**********************VERIFICA QUE BD ESTA ACTIVA************************
                $bdprincipal = DB::connection('agendappal')
                    ->table('usuarios')
                    ->select('dsnagenda', 'dsnficha')
                    ->where('dsnagenda', '=', Session::get('str_bd'))
                    ->get();
                foreach ($bdprincipal as $bdprincipales) {
                         //***COLOCAR EN UNA VARIABLE DE SESIÓN EL NOMBRE DE LA BD***
                         Session::put('str_ficha',$bdprincipales->dsnficha);
                }
       
                //***VERIFICA SI EL REGISTRO YA SE ENCUENTRA EN LA BD****
                $verifica_existe = DB::connection(Session::get('str_ficha'))
                    ->table('kardex')
                    ->select('RUT', 'Nombres')
                    ->where('RUT', '=', $str_rut)
                    ->get();
               
                foreach ($verifica_existe as $verifica_existes) {
                    $sw_registros = 1;
                    //echo "<script>alert('Su registro ya se encuentra en nuestra base de datos'); window.location='registrarse';</script>";
                }
                //***FIN DE REGISTRO**************************************
                if ($sw_registros == 0){
                    //***GUARDO EN LA TABLA KARDEX DE LA BD CORRESPONDIENTE***
                    DB::connection(Session::get('str_ficha')) 
                       ->table('kardex')->insert(
                            array('RUT'      => $str_rut,
                           'Nombres'         => $str_nombre,
                           'Appat'           => $str_paterno,
                           'Apmat'           => $str_materno,
                           'FechaNacimiento' => $calendario,
                           'Sexo'            => $str_sexo,
                           'prevision'       => $str_previsiones,                       
                           'fono'            => $str_tlf,
                           'celu'            => $str_celular,
                           'email'           => $str_email,
                           'clave'           => $str_password,
                            )
                    );
                }//***CIERRO LLAVES DEL IF***

                //***VERIFICA SI EL REGISTRO YA SE ENCUENTRA EN LA BD DE USUARIO UNICOS WEB*************
                $verifica_existe_usuario_web = DB::connection('usuarios_web')
                    ->table('tb_usuarios')
                    ->select('str_rut', 'str_username')
                    ->where('str_rut', '=', $str_rut)
                    ->get();
               
                foreach ($verifica_existe_usuario_web as $verifica_existe_usuario_web1) {
                         $sw_registros_usuario_web = 1;
                }
                //***IF PARA VERIFICAR EL USUARIO***
                if ($sw_registros_usuario_web == 0){
                    $var_strbd1 = Session::get('str_bd');
                    $var_strba2 = Session::get('str_ficha');
                    //***GUARDO EN LA TABLA USUARIOS DE LA BD usuarios_web***
                    DB::connection('usuarios_web') 
                       ->table('tb_usuarios')->insert(
                            array('str_rut'  => $str_rut,
                           'str_username'    => $str_email,
                           'str_password'    => $str_password,
                           'str_descripcion' => $str_nombre,
                           'str_email'       => $str_email,
                           'str_agenda'      => $var_strbd1,
                           'str_ficha'       => $var_strba2,
                           'int_estado'      => 1,                       
                           'int_acceso'      => 1,
                            )
                    );
                }//****CIERRO LLAVES DEL IF QUE VERIFICA SI YA EXISTE EL USUARIO WEB EN LA TABLA UNICA***

                //***AQUI SE DEBE AGENDAR LA HORA***
                //Session::get('str_bd')
                //dd($str_rut);
                $desc      = "Agendamiento Web";
                $horario   = "N";
                $dif       = Session::get('dif_agenda_hora2');
                $fecha     = Session::get('fecha_agenda_hora2');
                $hora      = "1899-12-30"." ".Session::get('hora_agendar2');
                $id_medico = Session::get('idmedico_agenda_hora2');
                $nombres   = $str_nombre." ".$str_paterno." ".$str_materno;
                DB::connection(Session::get('str_bd')) 
                   ->table('agenda')->insert(
                        array('RUT'    => $str_rut,
                       'fecha'         => $fecha,
                       'hora'          => $hora,
                       'id_medico'     => $id_medico,
                       'prevision'     => $str_previsiones,
                       'edad'          => 0,
                       'nombre'        => $nombres,
                       'fenac'         => $calendario,
                       'sexo'          => $str_sexo,
                       'fono'          => $str_celular,
                       'web'           => 1,
                       'sector'        => 0,
                       'beneficiario'  => 0,
                       'pago'          => 0,
                       'tipo_cons'     => 0,
                       'present'       => 0,
                       'atendido'      => 0,
                       'confirma'      => 0,
                       'fechahoracrea' => $fecha,
                       'tipo'          => 2,
                       'desc'          => $desc,
                       'id_usuario'    => 1,
                       'horario'       => $horario,
                       'dif'           => $dif,
                       'tipohorario'   => 0,
                       )
                );
                
               //***ENVIAR CORREO DE AGENDAMIENTO**************************
                    $id_reserva = DB::connection(Session::get('str_bd'))
                                        ->table('agenda')
                                        ->select('*')
                                        ->where('fecha', '=', $fecha)
                                        ->where('hora', '=', $hora)
                                        ->where('id_medico', '=', $id_medico)
                                        ->get();
                       
                    foreach ($id_reserva as $id_reservas) {
                             $id_reserva = $id_reservas->id;
                             //**********************BUSCO INFORMACION DEL MEDICO*******************************
                             $medico = DB::connection(Session::get('str_bd'))
                                ->table('medicos')
                                ->select('id_medico', 'nombre', 'especialidad', 'id_tipoprofesional')
                                ->where('id_medico', '=', $id_medico)
                                ->get();
                             foreach ($medico as $medicos) {
                                $nom_medico       = $medicos->nombre;
                                $nom_especialidad = $medicos->especialidad;
                             }

                    }

                    //***ENVIAR CORREO DE CONFIRMACIÓN****
                    $data2 = array
                        ('id_reserva'   => $id_reserva,
                         'md5'          => Session::get('idmd5'),
                         'hora'         => Session::get('hora_disp1'),
                    );
                    $fromEmail = 'infowebmedicas@gmail.com';
                    $fromName  = 'Confirmar Agendamiento Webmédica';
                    $toEmail   = $str_email;
                    $toName    = '';

                    Mail::send('emails.confirmarhora', $data2, function($message) use ($fromName, $fromEmail, $toEmail, $toName) {
                        $message->to($toEmail, $toName);  
                        $message->from($fromEmail, $fromName);
                        $message->subject('Confirmación de Hora Médica');
                    });
                    //***FIN CORREO DE CONFIRMACIÓN***

                //***ENVIAR CORREO DE AGENDAMIENTO**************************
                    $id_reserva = DB::connection(Session::get('str_bd'))
                                        ->table('agenda')
                                        ->select('*')
                                        ->where('fecha', '=', $fecha)
                                        ->where('hora', '=', $hora)
                                        ->where('id_medico', '=', $id_medico)
                                        ->get();
                       
                    foreach ($id_reserva as $id_reservas) {
                             $id_reserva = $id_reservas->id;
                             //**********************BUSCO INFORMACION DEL MEDICO*******************************
                             $medico = DB::connection(Session::get('str_bd'))
                                ->table('medicos')
                                ->select('id_medico', 'nombre', 'especialidad', 'id_tipoprofesional')
                                ->where('id_medico', '=', $id_medico)
                                ->get();
                             foreach ($medico as $medicos) {
                                $nom_medico       = $medicos->nombre;
                                $nom_especialidad = $medicos->especialidad;
                             }

                    }

                    $data = array
                        ('id_reserva'   => $id_reserva,
                         'str_medico'   => $nom_medico,
                         'fecha'        => Session::get('fecha_agenda_hora2'),
                         'hora'         => Session::get('hora_agendar2'),
                         'especialidad' => $nom_especialidad
                    );
                    $fromEmail = 'infowebmedicas@gmail.com';
                    $fromName  = 'Agendamiento Webmédica';
                    $toEmail   = $str_email;
                    $toName    = '';

                    Mail::send('emails.mailagendamiento', $data, function($message) use ($fromName, $fromEmail, $toEmail, $toName) {
                        $message->to($toEmail, $toName);  
                        $message->from($fromEmail, $fromName);
                        $message->subject('Reserva de Hora Médica');
                    }); 

                //**************************************************************************
                return $this->layout->content = View::make('ageweb/guardarregistro');
            }//***LLAVE DEL IF DE VALIDAR DATOS
 }

 //*******************VALIDAR CORREO EN EL FORMULARIO DE REGISTRO*****************************

 public function post_ajaxvalidacorreos() {
        DB::beginTransaction();
        try {
            $sw_validado = 0;
            $inputs     = Input::All();
            $str_correo = $inputs['data'][0];

            //dd($fecha_actual1);
            //*************BUSCAR CORREO PARA VER SI EXISTE***********************************
            $email = DB::connection('usuarios_web')
                    ->table('tb_usuarios')
                    ->select('str_email')
                    ->where('str_email', '=', $str_correo)
                    ->get();
               
                foreach ($email as $emails) {
                         $sw_validado = 1;                         
                }
                if ($sw_validado == 1) {
                    return $this->layout->content = View::make('ageweb/emailnovalido');
                }  
                if ($sw_validado == 0) {
                    return $this->layout->content = View::make('ageweb/emailvalido');
                }          
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json('----------Ha ocurrido un error inesperado, por favor actualice la pagina y de persistir el error comuniquese con el administrador del sistema----------', 400);
        }
        DB::commit();
                       
        }

//******************************************FIN DEL CONTROLADOR****************************************************
}

