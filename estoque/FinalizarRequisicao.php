<?php 

include_once "../dao/conexao.php";
session_start();
$result_senha = "SELECT * FROM usuario where idUsuario = '$_SESSION[idUsuario]' ";
$res = $con->query($result_senha);
$linha = $res->fetch_assoc();


$senha_validacao = $_POST['senha_validacao'];
$senha_db = $linha['senha'];
$data = date("Y-m-d");
if(password_verify($senha_validacao,$senha_db) && $senha_validacao != null){

    if(!empty($_POST['requi'])){
        $re['requi'] = $_POST['requi'];

    foreach($re['requi'] as $idRequisicao ){
       
            $update_Requisicao = "UPDATE requisicao set status = 1 where idRequisicao = '$idRequisicao'";

        if($con->query($update_Requisicao) === TRUE){

            $update_ListaRequisicao = $con->query("UPDATE  listarequisicao set status = 1 where idRequisicao = '$idRequisicao'");
                }
            }

    foreach($re['requi'] as $idRequisicao ){
   
        $result_lista = "SELECT * FROM listarequisicao where idRequisicao = '$idRequisicao'";
        $resultado_lista = mysqli_query($con, $result_lista);

        while($rows_lista = mysqli_fetch_assoc($resultado_lista)){
            $select_produto = "SELECT * FROM produto where idProduto = '$rows_lista[idProduto]'";
            $res = $con->query($select_produto);
            $linha = $res->fetch_assoc();

            $quantidadeProduto = $linha['quantidadeProduto'];
            $quantidadeSaida = $rows_lista['quantidade'];
            $quantidadeFinal = ($quantidadeProduto - $quantidadeSaida);

            $con->query("UPDATE produto set quantidadeProduto = '$quantidadeFinal' where idProduto = '$rows_lista[idProduto]'");
            } 
        } 

        $con->query("INSERT INTO historico (dataHistorico,descricaoHistorico,idUsuario)VALUES('$data','Finalizou requisição do(s) produto(s)', '$_SESSION[idUsuario]')");
        echo "<script>alert('Finalizado com sucesso!');window.location='SaidasPendentes.php'</script>";
    }else{
        echo "<script>alert('Nenhuma requisição foi selecionada!');window.location='SaidasPendentes.php'</script>";
    }

    }
    else{
        echo "<script>alert('Senha invalida!');window.location='SaidasPendentes.php'</script>";
         }

?>