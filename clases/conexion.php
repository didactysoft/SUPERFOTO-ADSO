

<?php 

class conectar{
	public function conexion(){
		$conexion=mysqli_connect('localhost',
			'root',
			'',
			'arqui');
		$conexion->set_charset('utf8');
		return $conexion;
	}
}


?>