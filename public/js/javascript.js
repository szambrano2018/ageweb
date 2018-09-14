function test(){
alert("test");
}

function guardar(){
    
    var data = new Array(11);

    data[0]=$("#nombre").val();
    data[1]=$("#apellido").val();
    data[2]=$("#pasaporte").val();
    data[3]=$("#nacionalidad").val();
    data[4]=$("#ciudad").val();
    data[5]=$("#pais").val();
    data[6]=$("#direccion").val();
    data[7]=$("#telefono").val();
    data[8]=$("#correo").val();
    data[9]=$("#frecuencia").val();
    data[10]=$("#usuario").val();
    data[11]=$("#password").val();
    
    $.ajax({
        url: 'guarda',
        type: 'GET',
        data: {data: data},
//        dataType: 'JSON',
        beforeSend: function () {
//         alert('Procesando...');
        },
        error: function (respuesta) {
            alert('Ha surgido un error...');
//          alert(respuesta);
        },
        success: function (respuesta) {
            alert('Su usuario ha sido creado con éxito');
        }
    });
}

//*******************************************CODIGO DE LA AGENDA WEB*****************************************

function buscarhorarios()
{
    var data = new Array(12);
    var divhoras;
    divhoras          = document.getElementById("divhoras");
    fechaage          = document.getElementsByName("calendario")[0].value;
    str_nom_agenda    = document.getElementsByName("str_nom_agenda")[0].value;
    
    str_medico1       = document.getElementsByName("str_medico1")[0].value;
    str_medico2       = document.getElementsByName("str_medico")[0].value;

    //*******************ASIGNAREL VALOR DEL MÉDICOQUE SE USARAN PARA EL QUERY********************
    int_medico = str_medico1
    //*******************BUSCO EL DIA DE LA SEMANA A LA PERTENECE LA FECHA SELECCIONADA***********
   
    var cadena = fechaage.split("-");
    semana       = cadena[0];
    dia          = cadena[1];
    mes          = cadena[2];
    ano          = cadena[3];
    fecha_actual = ano+"-"+mes+"-"+dia;

    //*******************ASIGNAR AL ARRAY DE DATOS************************************************

    data[0] = semana;
    data[1] = dia;
    data[2] = mes;
    data[3] = ano;
    data[4] = str_nom_agenda;
    data[5] = int_medico;
    data[6] = fecha_actual;
    
    //*******************ENVÍO CON JQUERY LA INFORMACION******************************************
    $.ajax({
        url: 'horarios',
        type: 'POST',
        data: {data: data},
        dataType: 'html',
        beforeSend: function () {
            //alert('Procesando...');
        },
        error:function( jqXHR, textStatus, errorThrown ) {
             alert( errorThrown ); 
             //alert("Ha ocurrido un error");
        },
        success: function (respuesta) {
            $('#divhoras').html(respuesta);
        }
    });
}

//*******************************************BUSCAR LOS MEDICOS SEGÚN SU ESPECIALIDAD*************

function buscaprofesionales()
{
    var data = new Array(5);
    divmedicos      = document.getElementById("divmedicos");
    id_especialidad = document.getElementsByName("str_especialista")[0].value;
    str_nom_agenda  = document.getElementsByName("str_nom_agenda")[0].value;

    //*******************ASIGNAR AL ARRAY DE DATOS************************************************

    data[0] = str_nom_agenda;
    data[1] = id_especialidad;
    
    //*******************ENVÍO CON JQUERY LA INFORMACION******************************************
    $.ajax({
        url: '../especialidad',
        type: 'POST',
        data: {data: data},
        dataType: 'html',
        beforeSend: function () {
            //alert('Procesando...');
        },
        error:function( jqXHR, textStatus, errorThrown ) {
             //alert( errorThrown ); 
             alert("Ha ocurrido un error");
        },
        success: function (respuesta) {
            $('#divmedicos').html(respuesta);
        }
    });
}

//**********BUSCAR LOS MEDICOS SEGÚN SU ESPECIALIDAD EN SEGUNDA PANTALLA DE LA AGENDA*************

function buscaprofesionales2()
{
    var data = new Array(5);
    divmedicosagenda = document.getElementById("divmedicosagenda");
    id_especialidad  = document.getElementsByName("str_especialista")[0].value;
    str_nom_agenda   = document.getElementsByName("str_nom_agenda")[0].value;

    //*******************ASIGNAR AL ARRAY DE DATOS************************************************

    data[0] = str_nom_agenda;
    data[1] = id_especialidad;
    
    //*******************ENVÍO CON JQUERY LA INFORMACION******************************************
    $.ajax({
        url: 'especialidadagenda',
        type: 'POST',
        data: {data: data},
        dataType: 'html',
        beforeSend: function () {
            //alert('Procesando...');
        },
        error:function( jqXHR, textStatus, errorThrown ) {
             //alert( errorThrown ); 
             alert("Ha ocurrido un error");
        },
        success: function (respuesta) {
            $('#divmedicosagenda').html(respuesta);
        }
    });
}


//*******************************************BUSCAR DISPONIBILIDAD DE MEDICOS*********************

function buscadisponibilidad()
{
    var data = new Array(7);
    divhoradisponible = document.getElementById("divhoradisponible");
    str_medico        = document.getElementsByName("str_medico")[0].value;
    str_especialista  = document.getElementsByName("str_especialista")[0].value;
    str_nom_agenda    = document.getElementsByName("str_nom_agenda")[0].value;

    //*******************BUSCO EL DIA DE LA SEMANA A LA PERTENECE LA FECHA SELECCIONADA***********
    var f         = new Date();
    var hoy       = f.getDay();
    //***PARA ASIGNAR EL DIA DOMINGO***
    if (hoy==0){hoy = 7;}
    //*********************************
    var dia       = f.getDate();
    var mes       = f.getMonth()+1;
    var ano       = f.getFullYear();
    var fecactual = ano+"-"+mes+"-"+dia;
    //*******************ASIGNAR AL ARRAY DE DATOS************************************************
    data[0] = str_nom_agenda;
    data[1] = str_medico;
    data[2] = str_especialista;
    data[3] = hoy;
    data[4] = fecactual;

    //*******************ACTIVAR LOS BOTONES*****************************************************
    $('#reserva').attr("disabled", false);
    $('#masreservas').attr("disabled", false);
    //*******************ENVÍO CON JQUERY LA INFORMACION******************************************
    $.ajax({
        url: '../disponibilidad',
        type: 'POST',
        data: {data: data},
        dataType: 'html',
        beforeSend: function () {
            //alert('Procesando...');
        },
        error:function( jqXHR, textStatus, errorThrown ) {
             alert( errorThrown ); 
             //alert("Ha ocurrido un error");
        },
        success: function (respuesta) {
            $('#divhoradisponible').html(respuesta);
        }
    });
}

//*******************************************FUNCIÓN PARA VALIDAR RUT********************
function Rut2()
{   
    texto = document.getElementsByName("str_rut")[0].value;
    var tmpstr = "";    
    for ( i=0; i < texto.length ; i++ )     
        if ( texto.charAt(i) != ' ' && texto.charAt(i) != '.' && texto.charAt(i) != '-' )
            tmpstr = tmpstr + texto.charAt(i);  
    texto = tmpstr; 
    largo = texto.length;   

    if ( largo < 2 )    
    {       
        alert("Debe ingresar el rut completo")      
        return false;   
    }   

    for (i=0; i < largo ; i++ ) 
    {           
        if ( texto.charAt(i) !="0" && texto.charAt(i) != "1" && texto.charAt(i) !="2" && texto.charAt(i) != "3" && texto.charAt(i) != "4" && texto.charAt(i) !="5" && texto.charAt(i) != "6" && texto.charAt(i) != "7" && texto.charAt(i) !="8" && texto.charAt(i) != "9" && texto.charAt(i) !="k" && texto.charAt(i) != "K" )
        {           
            alert("El valor ingresado no corresponde a un R.U.T valido");           
            return false;       
        }   
    }   

    var invertido = ""; 
    for ( i=(largo-1),j=0; i>=0; i--,j++ )      
        invertido = invertido + texto.charAt(i);    
    var dtexto = "";    
    dtexto = dtexto + invertido.charAt(0);  
    dtexto = dtexto + '-';  
    cnt = 0;    

    for ( i=1,j=2; i<largo; i++,j++ )   
    {       
        //alert("i=[" + i + "] j=[" + j +"]" );     
        if ( cnt == 3 )     
        {           
            dtexto = dtexto + '.';          
            j++;            
            dtexto = dtexto + invertido.charAt(i);          
            cnt = 1;        
        }       
        else        
        {               
            dtexto = dtexto + invertido.charAt(i);          
            cnt++;      
        }   
    }   

    invertido = ""; 
    for ( i=(dtexto.length-1),j=0; i>=0; i--,j++ )      
        invertido = invertido + dtexto.charAt(i);   

    document.getElementsByName("str_rut")[0].value = invertido.toUpperCase()     

    if ( revisarDigito3(texto) )        
        return true;    

    return false;
}
function revisarDigito( dvr )
{   
    dv = dvr + ""   
    if ( dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' && dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k'  && dv != 'K') 
    {       
        alert("Debe ingresar un digito verificador valido");        
        window.document.form1.rut.focus();      
        window.document.form1.rut.select();     
        return false;   
    }   
    return true;
}

function revisarDigito3( crut )
{   
    largo = crut.length;    
    if ( largo < 2 )    
    {       
        alert("Debe ingresar el rut completo")      
        return false;   
    }   
    if ( largo > 2 )        
        rut = crut.substring(0, largo - 1); 
    else        
        rut = crut.charAt(0);   
    dv = crut.charAt(largo-1);  
    revisarDigito( dv );    

    if ( rut == null || dv == null )
        return 0    

    var dvr = '0'   
    suma = 0    
    mul  = 2    

    for (i= rut.length -1 ; i >= 0; i--)    
    {   
        suma = suma + rut.charAt(i) * mul       
        if (mul == 7)           
            mul = 2     
        else                
            mul++   
    }   
    res = suma % 11 
    if (res==1)     
        dvr = 'k'   
    else if (res==0)        
        dvr = '0'   
    else    
    {       
        dvi = 11-res        
        dvr = dvi + ""  
    }
    if ( dvr != dv.toLowerCase() )  
    {       
        alert("EL rut es incorrecto")       
        document.getElementsByName("str_rut")[0].focus;  
        return false    
    }

    return true
}


function numerosval(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    nro = "0123456789";
    especiales = [8];
    // alert(key);
    if (tecla == 13) {
        return;
    }

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }
    if (nro.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}

//*******************************************FUNCION SOLO LETRAS*************************

function soloLetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " �����abcdefghijklmnñopqrstuvwxyz";
    especiales = [8, 9];

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}

//******************************************FUNCION SOLO NUMEROS**********************

function numerosval(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    nro = "0123456789";
    especiales = [8];
    // alert(key);
    if (tecla == 13) {
        return;
    }

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }
    if (nro.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}

//*******************************************AGENDAR HORA DISPONIBLE*********************

function ajaxagendar(valor)
{
    alert(valor);
}

//*******************************************ACTIVA EL BOTÓN REGISTRARSE****************

//*******************************************VALIDA EMAIL*******************************

function ajaxvalidaemail()
{
    var data = new Array(2);
    divcorreo  = document.getElementById("divcorreo");
    str_correo = document.getElementsByName("str_email")[0].value;

    //*******************ASIGNAR AL ARRAY DE DATOS************************************************
    data[0] = str_correo;
    //*******************ENVÍO CON JQUERY LA INFORMACION******************************************
    $.ajax({
        url: 'verificaemail',
        type: 'POST',
        data: {data: data},
        dataType: 'html',
        beforeSend: function () {
            //alert('Procesando...');
        },
        error:function( jqXHR, textStatus, errorThrown ) {
             alert( errorThrown ); 
             //alert("Ha ocurrido un error");
        },
        success: function (respuesta) {
            $('#divcorreo').html(respuesta);
        }
    });
}

//*****************************************ACTIVAR BOTÓN DE REGISTRARSE*****************
function ajaxactivarregistrarse()
{
   int_email_registrado = document.getElementsByName("int_email_registrado")[0].value;
   //***DEHABILITAR BOTÓN PORQUE EXISTE EMAIL***
   if (int_email_registrado == 1){
       $('#btn_registrar').attr("disabled", true);
       document.getElementsByName("str_password")[0].value = "";
       document.getElementsByName("tmp_password")[0].value = "";
   }//***HABILITAR BOTÓN PORQUE EL EMAIL ESTÁ CORRECTO***
    else if (int_email_registrado == 0){
            $('#btn_registrar').attr("disabled", false);
   }
}

