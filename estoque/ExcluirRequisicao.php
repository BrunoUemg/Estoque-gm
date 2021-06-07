<?php

include_once "../dao/conexao.php";
$idRequisiscao = $_GET['idRequisicao'];

$sql = "DELETE FROM listarequisicao where idRequisicao = '$idRequisiscao' "; 
$data = date("Y-m-d");


if($con->query($sql)=== true){
    
    $delete_requisicao = "DELETE FROM requisicao where idRequisicao = '$idRequisiscao' "; 

    if($con->query($delete_requisicao) === TRUE){
        session_start();
        $con->query("INSERT INTO historico (dataHistorico,descricaoHistorico,idUsuario)VALUES('$data','Excluiu requisição', '$_SESSION[idUsuario]')");
    echo "<script>alert('Cadastro excluido com sucesso!');window.location='SaidasPendentes.php'</script>";
    }
} else {
	echo "Erro para excluir: " . $con->error; 
}
$con->close();
?>