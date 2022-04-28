<?php

include_once "../dao/conexao.php";

$idProduto=$_POST["idProduto"];
$descricao = $_POST["descricaoProduto"];
$quantidadeMin = $_POST["quantidadeMin"];
$tipoEstoque = $_POST["tipoEstoque"];

$sql = "UPDATE produto set descricaoProduto ='$descricao', quantidadeMin='$quantidadeMin', tipoEstoque = '$tipoEstoque' where idProduto= '$idProduto' "; 

if($con->query($sql)=== true){
echo "<script>alert('Cadastro alterado com sucesso!');window.location='ConsultarProduto.php'</script>";
} else {
	echo "Erro para inserir: " . $con->error; 
}
$con->close();
?>