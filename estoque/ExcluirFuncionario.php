<?php

include_once "../dao/conexao.php";
$idUsuario=$_GET['idUsuario'];

$sql = "DELETE FROM usuario where idUsuario = '$idUsuario' "; 



if($con->query($sql)=== true){
echo "<script>alert('Cadastro excluido com sucesso!');window.location='ConsultarFuncionario.php'</script>";
} else {
	echo "Erro para excluir: " . $con->error; 
	
}
$con->close();
?>