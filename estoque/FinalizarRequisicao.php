<?php 

include_once "../dao/conexao.php";
session_start();
$result_senha = "SELECT * FROM usuario where idUsuario = '$_SESSION[idUsuario]' ";
$res = $con->query($result_senha);
$linha = $res->fetch_assoc();

$idRequisicao = $_POST['idRequisicao'];
$senha_validacao = $_POST['senha_validacao'];
$senha_db = $linha['senha'];
$data = date("Y-m-d");
if(password_verify($senha_validacao,$senha_db) && $senha_validacao != null){
    $update_Requisicao = "UPDATE requisicao set status = 1 where idRequisicao = '$idRequisicao'";

    if($con->query($update_Requisicao) === TRUE){

        $update_ListaRequisicao = "UPDATE  listarequisicao set status = 1 where idRequisicao = '$idRequisicao'";
       
            if($con->query($update_ListaRequisicao) === TRUE){
                $con->query("INSERT INTO historico (dataHistorico,descricaoHistorico,idUsuario)VALUES('$data','Finalizou requisição do(s) produto(s)', '$_SESSION[idUsuario]')");
                echo "<script>alert('Finalizado com sucesso!');window.location='SaidasPendentes.php'</script>";
            }
    }
}else{
    echo "<script>alert('Senha invalida!');window.location='SaidasPendentes.php'</script>";
}

?>