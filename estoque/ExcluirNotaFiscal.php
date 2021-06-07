<?php

include_once "../dao/conexao.php";
$idNotaFiscal = $_GET['idNotaFiscal'];

$sql = "DELETE FROM notafiscal where idNotaFiscal = '$idNotaFiscal' "; 
$data = date("Y-m-d");


if($con->query($sql)=== true){
	session_start();
        $con->query("INSERT INTO historico (dataHistorico,descricaoHistorico,idUsuario)VALUES('$data','Excluiu entrada', '$_SESSION[idUsuario]')");
echo "<script>alert('Cadastro excluido com sucesso!');window.location='EntradasPendentes.php'</script>";
} else {
	echo "Erro para excluir: " . $con->error; 
}
$con->close();
?>