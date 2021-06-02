<?php

include_once "../dao/conexao.php";
$idProduto=$_GET['idProduto'];

$sql = "DELETE FROM produto where idProduto = '$idProduto' "; 



if($con->query($sql)=== true){
echo "<script>alert('Cadastro excluido com sucesso!');window.location='ConsultarProduto.php'</script>";
} else {
	echo "Erro para excluir: " . $con->error; 
}
$con->close();
?>