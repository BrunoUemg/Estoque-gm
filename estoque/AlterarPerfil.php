<?php 

include_once("../dao/conexao.php");
session_start();
$sql = "SELECT senha FROM usuario  where idUsuario = '$_SESSION[idUsuario]'  ";
		
$res = $con->query($sql);
$linha = $res->fetch_assoc();
$senha_db = $linha['senha'];

$idUsuario = $_POST["idUsuario"];
$nomeUsuario = $_POST["nomeUsuario"];
$usuario = $_POST["user"];
$senhaAtual = $_POST["senhaAtual"];
$senha = $_POST["senha"];
if(password_verify($senhaAtual,$senha_db))
{
	$senhaSegura = password_hash($senha, PASSWORD_DEFAULT);
$sql = "UPDATE usuario set nomeUsuario ='$nomeUsuario',  userAcesso='$usuario',
senha='$senhaSegura' where idUsuario = '$idUsuario' "; 



if($con->query($sql)=== true){
echo "<script>alert('Cadastro alterado com sucesso!');window.location='MenuPrincipal.php'</script>";
} else {
	echo "Erro para inserir: " . $con->error; 
}
$con->close();
	

}
else {

	echo "<script>alert('Senha atual diferente! Tente novamente');window.location='MenuPrincipal.php'</script>";
}
?>