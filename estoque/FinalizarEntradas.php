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
    if(!empty($_POST['entrada'])){
        $re['entrada'] = $_POST['entrada'];

        foreach($re['entrada'] as $idnotafiscal ){
           
                $con->query("UPDATE notafiscal set status = 1 where idnotafiscal = '$idnotafiscal'");

                $select_nota = "SELECT * FROM notafiscal where idnotafiscal = '$idnotafiscal'";
                $res = $con->query($select_nota);
                $linha_nota = $res->fetch_assoc();
                $quantidadeEntrada = $linha_nota['quantidade'];

                $select_produto = "SELECT * FROM produto where idProduto = '$linha_nota[idProduto]'";
                $res = $con->query($select_produto);
                $linha_produto = $res->fetch_assoc();

                $quantidade_db = $linha_produto['quantidadeProduto'];

                $quantidadeTotal = ($quantidade_db + $quantidadeEntrada);
                $update_produto = "UPDATE produto set quantidadeProduto = '$quantidadeTotal' where idProduto = '$linha_nota[idProduto]'";
                if($con->query($update_produto) === TRUE){
                    $con->query("INSERT INTO historico (dataHistorico,descricaoHistorico,idUsuario)VALUES('$data','Finalizou entrada de $linha_produto[descricaoProduto]', '$_SESSION[idUsuario]')");
                    echo "<script>alert('Finalizado com sucesso!');window.location='EntradasPendentes.php'</script>";
                }
                }

    }else{
        echo "<script>alert('Nenhuma nota fiscal foi selecionada!');window.location='EntradasPendentes.php'</script>";
    }
   
}else{
    echo "<script>alert('Senha invalida!');window.location='EntradasPendentes.php'</script>";
}

?>

