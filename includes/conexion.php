<?php

	class Conexion {

	  protected $usuario ="archa_odin";
	  protected $password="root";
	  protected $servidor="localhost";
	  protected $basededatos="archa_user_ehl_sgi";
	  
	  protected $conexion;

	  protected function conectar (){
		  $this->conexion=mysqli_connect(
			  $this->servidor,
			  $this->usuario,
			  $this->password,
			  $this->basededatos);

		  if (!$this->conexion) {
			  die("conexion erronea" . mysqli_connect_error());
		  }
	  }

	  protected function desconectar (){
		  mysqli_close($this->conexion);
	  }

	  public function ejecutar($query){
		  $this->conectar();
		  $data = mysqli_query($this->conexion, $query);
		  $this->desconectar();
		  return $data;
	  }
}
?>