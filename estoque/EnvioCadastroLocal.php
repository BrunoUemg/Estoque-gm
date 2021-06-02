<?php 

include_once "../dao/conexao.php";

$nomeLocal = $_POST["nomeLocal"];

$sql = $con->query("SELECT * FROM local WHERE nomeLocal='$nomeLocal'");

if(mysqli_num_rows($sql) > 0){
	echo "<script>alert('Local já existente! Cadastre um local novo');window.location='CadastrarLocal.php'</script>";
exit();
} else {
 !$con->query("INSERT INTO local (nomeLocal) VALUES ('$nomeLocal')");
 echo "<script>alert('Cadastro realizado com sucesso!');window.location='CadastrarLocal.php'</script>";
}
$con->close();

?>