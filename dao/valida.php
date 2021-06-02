<?php 
include_once "conexao.php";

session_start();
$usuario = $_POST['user'];
$senha = $_POST['senha'];



$sql = "SELECT * FROM usuario WHERE userAcesso = '$usuario'  ";
		
$res = $con->query($sql);
$linha = $res->fetch_assoc();

$id = $linha['idUsuario'];
	$nome = $linha['nomeUsuario'];
    $user = $linha['userAcesso'];
    $senha_db = $linha['senha'];
    $idLocal = $linha['idLocal'];	
    

    if ($usuario == $user && password_verify($senha,$senha_db) )
    {
        session_start();
        $_SESSION['idUsuario'] = $id;
        $_SESSION['nomeUsuario'] = $nome;
        $_SESSION['idLocal'] = $idLocal;
		$_SESSION['userAcesso'] = $user;
	header('location: ../estoque/MenuPrincipal.php');
    }
else 
{
    echo "<script>alert('Usuário ou senha incorreta !');window.location='../Index.html'</script>";
   
}

?>