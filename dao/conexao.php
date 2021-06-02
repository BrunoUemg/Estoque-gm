<?php 
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "estoquegm";

$con = new mysqli($servidor, $usuario, $senha, $banco);

if($con->connect_error)
{
	die("Erro de conexao " . $con->connect_error);
}

?>