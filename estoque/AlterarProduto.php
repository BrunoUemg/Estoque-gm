<?php

include_once "../dao/conexao.php";

$idProduto=$_POST["idProduto"];
$descricao = $_POST["descricaoProduto"];
$quantidadeMin = $_POST["quantidadeMin"];

$sql = "UPDATE produto set descricaoProduto ='$descricao', quantidadeMin='$quantidadeMin' where idProduto= '$idProduto' "; 

if($con->query($sql)=== true){
echo "<script>alert('Cadastro alterado com sucesso!');window.location='ConsultarProduto.php'</script>";
} else {
	echo "Erro para inserir: " . $con->error; 
}
$con->close();
?>