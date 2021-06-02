<?php
include_once "../dao/conexao.php";

$idProduto = $_POST["idProduto"];
$numeroNota = $_POST["numeroNota"];
$quantidadeEntrada = $_POST["quantidadeEntrada"];
$data = date ("Y-m-d");

$sql = "SELECT * FROM produto WHERE idProduto = '$idProduto' " ;
$res = $con-> query($sql);
$linha = $res->fetch_assoc();
$quantidade= $linha['quantidadeProduto'];

$quantidadeTotal = ($quantidade + $quantidadeEntrada);

$sql = "INSERT INTO notafiscal (idProduto,numeroNota,quantidade,dataEntrada) VALUES ($idProduto, '$numeroNota','$quantidadeEntrada','$data')";

if ($con->query($sql) === TRUE){
    $sql2 = "UPDATE produto set quantidadeProduto='$quantidadeTotal' where idProduto= '$idProduto' "; 
    if ($con->query($sql2) === TRUE)
    echo "<script>alert('Produto adicionado com sucesso!');window.location='ConsultarProduto.php'</script>";
    else 
		echo "Erro para inserir: " . $con->error; 
} else {
	echo "Erro para inserir: " . $con->error;
}
$con->close();
?>