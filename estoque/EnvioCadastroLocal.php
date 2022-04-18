<?php 

include_once "../dao/conexao.php";

$nomeLocal = $_POST["nomeLocal"];
$idCidade = $_POST["idCidade"];

$sql = $con->query("SELECT * FROM local WHERE nomeLocal='$nomeLocal' and idCidade = '$idCidade'");

if(mysqli_num_rows($sql) > 0){
	echo "<script>alert('Local já existente! Cadastre um local novo');window.location='CadastrarLocal.php'</script>";
exit();
} else {
 !$con->query("INSERT INTO local (nomeLocal,idCidade) VALUES ('$nomeLocal','$idCidade')");
 echo "<script>alert('Cadastro realizado com sucesso!');window.location='CadastrarLocal.php'</script>";
}
$con->close();

?>