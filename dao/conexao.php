<?php 
$servidor = "localhost";
$usuario = "gmfrut15_suporte";
$senha = "gmfrutal@19";
$banco = "gmfrut15_estoquegm";

$con = new mysqli($servidor, $usuario, $senha, $banco);
ob_start();
if($con->connect_error)
{
	die("Erro de conexao " . $con->connect_error);
}
?>