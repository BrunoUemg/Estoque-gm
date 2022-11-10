<?php

include_once "../dao/conexao.php";
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$hora = date("H:i");
$data = date("Y-m-d");
session_start();
// Select para Informações do Usuário
$select_usuario = mysqli_query($con, "SELECT * FROM usuario where idUsuario = '$_SESSION[idUsuario]'");
$linha_usuario = mysqli_fetch_array($select_usuario);
$senha_db = $linha_usuario['senha'];
$senha_validacao = $_POST['senha_validacao'];
// Verificação da Senha
if (password_verify($senha_validacao, $senha_db)) {
     // POST REFERENTE A LISTA DE PRODUTO 
        $descricaoProduto = $_POST['descricaoProduto'];
        $quantidade = $_POST['quantidade'];
        $idProduto = $_POST['idProduto'];
        $countProduto = count($_POST['descricaoProduto']);
        $idTransferencia = $_POST['idTransferencia'];
        $idLocal_destino = $_POST['idLocal_destino'];
    if ($_POST['salvar'] == "Aprovar") {
        // Realizando a subtração e atualizando no Produto a quantidade
        for ($i = 0; $i < $countProduto; $i++) {
            $select_produtoOriginal = mysqli_query($con, "SELECT * FROM produto WHERE idProduto = '$idProduto[$i]'");
            $linha_produto = mysqli_fetch_array($select_produtoOriginal);
            $quantOriginalProduto = $linha_produto['quantidadeProduto'];

            $quantidadeFinal = $quantOriginalProduto - $quantidade[$i];
            $con->query("UPDATE produto SET quantidadeProduto = '$quantidadeFinal' WHERE idProduto = '$idProduto[$i]'");
            

            $select_prodDestino = mysqli_query($con,"SELECT * FROM produto where descricaoProduto = '$linha_produto[descricaoProduto]' and idLocal = '$idLocal_destino'");
            if(mysqli_num_rows($select_prodDestino) > 0){
                $linha_prodDestino = mysqli_fetch_array($select_prodDestino);
                $quantidadeProduto = $linha_prodDestino['quantidadeProduto'];
                $quantidadeProdutoFinal = $quantidadeProduto + $quantidade[$i];
                $con->query("UPDATE produto SET quantidadeProduto = '$quantidadeProdutoFinal' where idProduto = $linha_prodDestino[idProduto]");
                
            }else{
                $con->query("INSERT INTO produto (descricaoProduto,quantidadeProduto,quantidadeMin,idLocal, status)VALUES
                ('$linha_produto[descricaoProduto]','$quantidade[$i]','$linha_produto[quantidadeMin]','$idLocal_destino', 1)");
            }
           
        
        }
        // Atualizando para Finalizado os Itens Solicitados
        $con->query("UPDATE transferencia  SET status = 1, situacao = 'Finalizado' WHERE idTransferencia = '$idTransferencia'");
        // Criando histórico para visualização
        $con->query("INSERT INTO historico_transferencia (data, hora, idTransferencia, acao, idUsuario ) VALUES ('$data', '$hora', '$idTransferencia', 'Transferência Aprovada', '$_SESSION[idUsuario]')");
        // Retornando o usuário para a página principal para receber outros produtos
        $_SESSION['msg'] = ' <div class="alert alert-success" role="alert"> <p> Aprovado com sucesso! </div> </p> ';
        echo "<script>window.location='ReceberProduto.php'</script>";
        exit();
    } else {
        $con->query("UPDATE transferencia  SET status = 1, situacao = 'Recusada' WHERE idTransferencia = '$idTransferencia'");
        // Criando histórico para visualização
        $con->query("INSERT INTO historico_transferencia (data, hora, idTransferencia, acao, idUsuario ) VALUES ('$data', '$hora', '$idTransferencia', 'Transferência Recusada', '$_SESSION[idUsuario]')");

        $_SESSION['msg'] = ' <div class="alert alert-success" role="alert"> <p> Recusado com sucesso! </div> </p> ';
        echo "<script>window.location='ReceberProduto.php'</script>";
        exit();
    }
} else {
    $_SESSION['msg'] = ' <div class="alert alert-danger" role="alert"> <p> Senha inválida! </div> </p> ';
    echo "<script>window.location='ReceberProduto.php'</script>";
    exit();
}
