<?php 

include_once ("../dao/conexao.php");
session_start();
$nomeUsuario = $_POST["nomeUsuario"];
$usuario = $_POST["user"];
$senha = $_POST["senha"];
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



$senhaSegura = password_hash($senha, PASSWORD_DEFAULT);
$sql = $con->query("SELECT * FROM usuario WHERE userAcesso='$usuario' ");



if(mysqli_num_rows($sql) > 0){
	echo "<script>alert('Usuário já existente! Cadastre um usuário novo.');window.location='CadastrarFuncionario.php'</script>";
exit();
}else{

 !$con->query("INSERT INTO usuario (nomeUsuario,userAcesso,senha, status, idLocal) VALUES ('$nomeUsuario','$usuario' ,'$senhaSegura', 1, 1)");
 
 $select_id = mysqli_query($con, "SELECT max(idUsuario) as 'codigo' FROM usuario");
 $result = mysqli_fetch_assoc($select_id);

 $idUsuario = $result['codigo'];

 $con->query("INSERT INTO `nivel_acesso` (`idNivel`, `cadFornecedor`, `consulFornecedor`, 
 `cadProduto`, `consulProduto`, `entPendente`, `saidaPendente`, `relaFiscal`, `relaLimite`,
  `relaProEstoque`, `relaRequisicao`, `relaFun`, `compFiscal`, `compRequi`, `idUsuario`, `master`, relatorioTransferencia)
   VALUES (NULL, '$cadFornecedor', '$consulFornecedor', '$cadProduto', '$consulProduto', '$entPendente',
	'$saidaPendente', '$relaFiscal', '$relaLimite', '$relaProEstoque', '$relaRequisicao', '$relaFun', 
	'$compFiscal', '$compRequi', '$idUsuario', '0', '$relatorioTransferencia')");



if(!empty($_POST['idLocal']))
{
	$idLocal['idLocal'] = $_POST['idLocal'];

	foreach($idLocal['idLocal'] as $idLocal)
	{
		$con->query("INSERT INTO local_usuario(idLocal,idUsuario)VALUES('$idLocal','$idUsuario')");
	}
}


$_SESSION['msg'] = ' <div class="alert alert-success" role="alert"> <p> Cadastrado com sucesso! </div> </p> ';
echo "<script>window.location='cadastrarFuncionario.php'</script>";
exit();
 
}

