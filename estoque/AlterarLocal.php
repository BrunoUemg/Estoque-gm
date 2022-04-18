<?php

include_once "../dao/conexao.php";
$idLocal=$_POST["idLocal"];
$nomeLocal = $_POST["nomeLocal"];
$idCidade = $_POST["idCidade"];

$sql = $con->query("SELECT * FROM local WHERE nomeLocal='$nomeLocal' and idLocal != '$idLocal'");

if(mysqli_num_rows($sql) > 0){
	echo "<script>alert('Local já existente! ');window.location='ConsultarLocal.php'</script>";
exit();
}
else {
    !$con->query("UPDATE  local SET nomeLocal = '$nomeLocal', idCidade = '$idCidade' where idLocal ='$idLocal'");
    echo "<script>alert('Local alterado com sucesso!');window.location='ConsultarLocal.php'</script>";
   }
   
   $con->close();



?>