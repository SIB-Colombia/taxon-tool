<?php
class DB_Sql{

	private $conexion;
	private $servidor;
	private $usuario;
	private $password;
	private $bd_nombre; 
	private $total_consultas;

	public function DB_Sql(){
		if(!isset($this->conexion)){
			
			$f_conexion = fopen("conf/config.propieties", "r");
			if($f_conexion){
				
				$params = Array();
				while (!feof($f_conexion)){
					$params[] = fgets($f_conexion);
				}
				
				$this->servidor = explode("=", $params[0]);
				$this->servidor = trim($this->servidor[1]);
				$this->usuario	= explode("=", $params[1]);
				$this->usuario = trim($this->usuario[1]);
				$this->password	= explode("=", $params[2]);
				$this->password = trim($this->password[1]);
				
				$this->bd_nombre	= explode("=", $params[3]);
				$this->bd_nombre 	= trim($this->bd_nombre[1]);
								
			}
			
			fclose($f_conexion);
		
		}
	}

	public function consulta($consulta){
		$this->total_consultas++;
		$resultado = mysql_query($consulta,$this->conexion);
		if(!$resultado){
			echo 'MySQL Error: ' . mysql_error();
			exit;
		}
		return $resultado;
	}

	public function fetch_array($consulta){
		return mysql_fetch_array($consulta);
	}

	public function num_rows($consulta){
		return mysql_num_rows($consulta);
	}

	public function getTotalConsultas(){
		return $this->total_consultas;
	}
	
	public function abrirConexion(){
		$this->conexion = (mysql_connect($this->servidor,$this->usuario,$this->password)) or die(mysql_error());
		mysql_select_db($this->bd_nombre,$this->conexion) or die(mysql_error());
		return $this->conexion;
	}
	
	public function cerrarConexion(){
		return mysql_close($this->conexion);
	}

}