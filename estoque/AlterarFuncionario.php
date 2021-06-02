<?php 
include_once "../dao/conexao.php";


$idUsuario = $_POST["idUsuario"];
$nomeUsuario = $_POST["nomeUsuario"];
$usuario = $_POST["user"];
$senha = $_POST["senha"];
$idLocal = $_POST["idLocal"];


$sql = "UPDATE  usuario SET nomeUsuario = '$nomeUsuario', userAcesso = '$usuario', senha = '$senha', idLocal = '$idLocal' where idUsuario ='$idUsuario' "; 

if($con->query($sql)=== true){
echo "<script>alert('Cadastro alterado com sucesso!');window.location='ConsultarFuncionario.php'</script>";
} else {
	echo "Erro para inserir: " . $con->error; 
}
$con->close();

   
?>