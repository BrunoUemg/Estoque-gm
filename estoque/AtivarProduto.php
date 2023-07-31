<?php

include_once "../dao/conexao.php";
$idProduto=$_GET['idProduto'];

$sql = "UPDATE produto set status = 1 where idProduto = '$idProduto'"; 



if($con->query($sql)=== true){
echo "<script>alert('Cadastro ativado com sucesso!');window.location='ConsultarProdutoDesativado.php'</script>";
} else {
	echo "Erro para ativar: " . $con->error; 
}
$con->close();
?>