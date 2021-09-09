<?php 

include_once ("../dao/conexao.php");
session_start();
$idUsuario = $_POST['idUsuario'];
$cadFornecedor = $_POST['cadFornecedor'];
$consulFornecedor = $_POST['consulFornecedor'];
$cadProduto = $_POST['cadProduto'];
$consulProduto = $_POST['consulProduto'];
$relaFiscal = $_POST['relaFiscal'];
$relaLimite = $_POST['relaLimite'];
$relaProEstoque = $_POST['relaProEstoque'];
$relaRequisicao = $_POST['relaRequisicao'];
$compFiscal = $_POST['compFiscal'];
$compRequi = $_POST['compRequi'];

$con->query("UPDATE `nivel_acesso` SET `cadFornecedor`= '$cadFornecedor',`consulFornecedor`='$consulFornecedor',
`cadProduto`= '$cadProduto',`consulProduto`= '$consulProduto',`relaFiscal`='$relaFiscal',`relaLimite`='$relaLimite',
`relaProEstoque`='$relaProEstoque',`relaRequisicao`='$relaRequisicao',`compFiscal`='$compFiscal',`compRequi`='$compRequi'
 WHERE idUsuario = $idUsuario ");

 
$_SESSION['msg'] = ' <div class="alert alert-success" role="alert"> <p> Alterado com sucesso! </div> </p> ';
echo "<script>window.location='editarFuncaoFuncionario.php?idUsuario=$idUsuario'</script>";
exit();