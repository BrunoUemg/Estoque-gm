<?php

include_once "../dao/conexao.php";
$idUsuario=$_GET['idUsuario'];

$sql = "UPDATE usuario set status = 0 where idUsuario = $idUsuario "; 



if($con->query($sql)=== true){
echo "<script>alert('Cadastro desligado com sucesso!');window.location='ConsultarFuncionario.php'</script>";
} else {
	echo "Erro para excluir: " . $con->error; 
	
}
$con->close();
?>