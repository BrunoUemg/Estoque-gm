<?php 

include_once "../dao/conexao.php";
session_start();
$result_senha = "SELECT * FROM usuario where idUsuario = '$_SESSION[idUsuario]' ";
$res = $con->query($result_senha);
$linha = $res->fetch_assoc();

$idNotaFiscal = $_POST['idNotaFiscal'];
$idProduto = $_POST['idProduto'];
$quantidadeEntrada = $_POST['quantidade'];
$senha_validacao = $_POST['senha_validacao'];
$senha_db = $linha['senha'];
$data = date("Y-m-d");


if(password_verify($senha_validacao,$senha_db) && $senha_validacao != null){
    $update_fiscal = "UPDATE notafiscal set status = 1 where idNotaFiscal = '$idNotaFiscal'";

    if($con->query($update_fiscal) === TRUE){

        $sql = "SELECT * FROM produto WHERE idProduto = '$idProduto' " ;
        $res = $con-> query($sql);
        $linha = $res->fetch_assoc();
        $quantidade_db = $linha['quantidadeProduto'];

        $quantidadeTotal = ($quantidade_db + $quantidadeEntrada);

        $update_produto = "UPDATE produto set quantidadeProduto = '$quantidadeTotal' where idProduto = '$idProduto'";

            if($con->query($update_produto) === TRUE){
                $con->query("INSERT INTO historico (dataHistorico,descricaoHistorico,idUsuario)VALUES('$data','Finalizou entrada de $linha[descricaoProduto]', '$_SESSION[idUsuario]')");
                echo "<script>alert('Finalizado com sucesso!');window.location='EntradasPendentes.php'</script>";
            }
    }
}else{
    echo "<script>alert('Senha invalida!');window.location='EntradasPendentes.php'</script>";
}

?>