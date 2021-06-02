<?php
include_once "../dao/conexao.php";

$descricaoProduto = $_POST["descricaoProduto"];
$quantidadeProduto = $_POST["quantidadeProduto"];
$quantidadeMin = $_POST["quantidadeMin"];
$idLocal = $_POST["local"];

$sql = $con->query("SELECT * FROM produto WHERE descricaoProduto='$descricaoProduto' and idLocal='$idLocal'");

if(mysqli_num_rows($sql) > 0){
	echo "<script>alert('Produto já existente nesse local ! Cadastre um Produto novo');window.location='CadastrarProduto.php'</script>";
exit();
} else {
	
 !$con->query("INSERT INTO produto (descricaoProduto,quantidadeProduto,quantidadeMin,idLocal) VALUES ('$descricaoProduto',$quantidadeProduto ,$quantidadeMin ,$idLocal)"); 
 echo "<script>alert('Cadastro realizado com sucesso!');window.location='CadastrarProduto.php'</script>";
 
}
$con->close();
?>
