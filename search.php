<?php
include_once 'db_mysql.php';

if(isset($_REQUEST)){
	$text_lsids = "";
	if(isset($_REQUEST['var_lsids'])){
		
		$text_lsids = $_REQUEST['var_lsids'];
		$lsids_ar 	= explode("\n", $text_lsids);
		$condicion	= "";
		if(count($lsids_ar) > 0){
			
			for ($i = 0; $i < count($lsids_ar); $i++) {

				if($i == 0){
					$condicion .= " WHERE name like '".$lsids_ar[$i]."'";
				}else{
					$condicion .= " OR name like '".$lsids_ar[$i]."'";
				}
			}
			
			$consulta = "";
			$bd_mysql = new DB_Sql();
			if($bd_mysql->abrirConexion()){
				$consulta = "SELECT taxon_id, name, rank, parent_id, lsid FROM _taxon_tree ".$condicion;
				$result   = $bd_mysql->consulta($consulta);
				
				if($result && $bd_mysql->num_rows($result) > 0){
					$datos_ar = Array();
					while($lsids_result = $bd_mysql->fetch_array($result)){
						$parent = traerPadre($lsids_result["parent_id"], $bd_mysql);
						$datos_ar[] = Array("name" => $lsids_result["name"],"lsid" => $lsids_result["lsid"],"rank" => $lsids_result["rank"], "parent" => $parent["name"], "parent_id" => $parent["lsid"]);
					}
					
					$bd_mysql->cerrarConexion();
					
					$json_arr 	= Array("datos" => $datos_ar,"success" => 1,"error" => 0, "msj_error" => "");
					$json		= json_encode($json_arr);
					echo $json;
				}else{
					$json_arr 	= Array("success" => 0,"error" => 1, "msj_error" => "No se encontro resultados");
					$json		= json_encode($json_arr);
					echo $json;
				}
			}
			
		}else{
			$json_arr 	= Array("success" => 0,"error" => 1, "msj_error" => "Error en conexion con BD");
			$json		= json_encode($json_arr);
			echo $json;
		}
		
	}
}

function traerPadre($id = 0, $bd_mysql = ""){
	$consulta = "SELECT name, lsid FROM _taxon_tree WHERE taxon_id = ".$id;
	$result   = $bd_mysql->consulta($consulta);
	
	if($result && $bd_mysql->num_rows($result) > 0){
		$lsids_result = $bd_mysql->fetch_array($result);
		return $lsids_result;
	}
	
}