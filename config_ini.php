<?php

if (isset($_REQUEST)) {
	
	$direccion 	= "";
	$usuario	= "";
	$password	= "";
	$bdnombre	= "";
	$error		= false;
	
	if(isset($_REQUEST['direccion']) && $_REQUEST['direccion'] != ""){
		$direccion	= $_REQUEST["direccion"];
	}else {
		$error = true;
	}
	
	if(isset($_REQUEST['usuario']) && $_REQUEST["usuario"] != ""){
		$usuario	= $_REQUEST["usuario"];
	}else {
		$error = true;
	}
	
	if(isset($_REQUEST["password"])){
		$password	= $_REQUEST["password"];
	}else {
		$error = true;
	}
	
	if(isset($_REQUEST["bdnombre"]) && $_REQUEST["bdnombre"] != ""){
		$bdnombre	= $_REQUEST["bdnombre"];
	}else {
		$error = true;
	}
	
	
	$bd_mysql = "";
	
	if(!$error){
		$f_conexion = fopen("conf/config.propieties", "a");
		if($f_conexion){
			$cadena = "direccion=".$direccion.PHP_EOL."usuario=".$usuario.PHP_EOL."password=".
						$password.PHP_EOL."nombre_BD=".$bdnombre;
			if(fwrite($f_conexion, $cadena)){
				
				$json_arr 	= Array("success" => 1,"error" => 0, "msj_error" => "");
				$json		= json_encode($json_arr);
				
				fclose($f_conexion);
				
				echo $json;
			}else {
				fclose($f_conexion);
				$json_arr 	= Array("success" => 0,"error" => 1, "msj_error" => "Error de escritura");
				$json		= json_encode($json_arr);
				echo $json;
			}
			
		}else {
			$json_arr 	= Array("success" => 0,"error" => 1, "msj_error" => "Error crear archivo");
			$json		= json_encode($json_arr);
			echo $json;
		}
		
	}else{
		$json_arr 	= Array("success" => 0,"error" => 1, "msj_error" => "Error de Parametros");
		$json		= json_encode($json_arr);
		echo $json;
	}
	
}