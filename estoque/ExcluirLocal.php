<?php

include_once "../dao/conexao.php";
$idLocal=$_GET['idLocal'];

$sql = "DELETE FROM local where idLocal = '$idLocal' "; 



if($con->query($sql)=== true){
echo "<script>alert('Local excluido com sucesso!');window.location='ConsultarLocal.php'</script>";
} else {
//	echo "Erro para excluir: " . $con->error; 
	echo "<script>alert('Local Não pode ser escluido excluido, pois irá comprometer seus produtos !');window.location='ConsultarLocal.php'</script>";
}
$con->close();
?>