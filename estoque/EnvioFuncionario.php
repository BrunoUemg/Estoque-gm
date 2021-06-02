<?php 

include_once ("../dao/conexao.php");

$nomeUsuario = $_POST["nomeUsuario"];
$usuario = $_POST["user"];
$senha = $_POST["senha"];
$local = $_POST["idLocal"];

$senhaSegura = password_hash($senha, PASSWORD_DEFAULT);
$sql = $con->query("SELECT * FROM usuario WHERE userAcesso='$usuario' ");

if(mysqli_num_rows($sql) > 0){
	echo "<script>alert('Usuário já existente! Cadastre um usuário novo.');window.location='CadastrarFuncionario.php'</script>";
exit();
} else if ($local !=0) {

 !$con->query("INSERT INTO usuario (nomeUsuario,userAcesso,senha,idLocal) VALUES ('$nomeUsuario','$usuario' ,'$senhaSegura' ,$local)");
 
 echo "<script>alert('Cadastro realizado com sucesso!');window.location='CadastrarFuncionario.php'</script>";
 
}
else
echo "<script>alert('Local não selecionado!');window.location='CadastrarFuncionario.php'</script>";
$con->close();





?>