<?php
include "common/SysParam.def";

#echo "OLI";
#phpDebug($_POST);

//pgsql://admin:123@localhost/app_db
#echo $DSN;
#exit;

//VALIDACION DE USUARIO Y REGISTRO DE CONEXION
if ( !$conn = phpBDconectar( false, $DSN, false, false ) ){
        $errorSes="No se pudo contectar a la Base de Datos. Intente m&aacute;s tarde.";
        echo $errorSes;
	exit;
}

phpBDclose($conn);

## Genera nombre de sesion
#session_set_cookie_params(0, "/", "spensiones.cl" );

## crea nombre de la session
$sessionName = sha1( $usuario.date('mdyH').$password );

## Define el Nombre de la sesi�n a utilizar
$prevSession=session_name( $sessionName );

# Inicia la sesion para los datos del usuario
session_start();

$_SESSION['miVariable'] = 'LUIS';

header("location: inicio.php?$sessionName");
?>
