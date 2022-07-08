<?php

include_once "../dao/conexao.php";
$idProduto=$_GET['idProduto'];

$sql = "UPDATE produto set status = 0 where idProduto = '$idProduto'"; 



if($con->query($sql)=== true){
echo "<script>alert('Cadastro desativado com sucesso!');window.location='ConsultarProduto.php'</script>";
} else {
	echo "Erro para excluir: " . $con->error; 
}
$con->close();
?>