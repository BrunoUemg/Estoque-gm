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
$relatorioTransferencia = $_POST['relatorioTransferencia'];
$receberTransferencia = $_POST['receberTransferencia'];

$con->query("UPDATE `nivel_acesso` SET `cadFornecedor`= '$cadFornecedor',`consulFornecedor`='$consulFornecedor',
`cadProduto`= '$cadProduto',`consulProduto`= '$consulProduto',`relaFiscal`='$relaFiscal',`relaLimite`='$relaLimite',
`relaProEstoque`='$relaProEstoque',`relaRequisicao`='$relaRequisicao',`compFiscal`='$compFiscal',`compRequi`='$compRequi',
relatorioTransferencia = '$relatorioTransferencia', receberTransferencia = '$receberTransferencia' WHERE idUsuario = $idUsuario ");

 
$idLocal['idLocal'] = $_POST['idLocal'];

$con->query("DELETE FROM local_usuario where idUsuario = '$idUsuario'");

foreach($idLocal['idLocal'] as $idLocal)
{
    $con->query("INSERT INTO local_usuario (idLocal,idUsuario)VALUES('$idLocal','$idUsuario')");
}


$_SESSION['msg'] = ' <div class="alert alert-success" role="alert"> <p> Alterado com sucesso! </div> </p> ';
echo "<script>window.location='editarFuncaoFuncionario.php?idUsuario=$idUsuario'</script>";
exit();