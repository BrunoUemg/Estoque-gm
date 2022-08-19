<?php

include_once "../dao/conexao.php";
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$hora = date("H:i");
$data = date("Y-m-d");
session_start();

use Dompdf\Dompdf;
// Select para Informações do Usuário
$select_usuario = mysqli_query($con, "SELECT * FROM usuario where idUsuario = '$_SESSION[idUsuario]'");
$linha_usuario = mysqli_fetch_array($select_usuario);
$senha_db = $linha_usuario['senha'];
$senha_validacao = $_POST['senha_validacao'];
// Verificação da Senha
if (password_verify($senha_validacao, $senha_db)) {
    if ($_POST['salvar'] == "Aprovar") {
        // POST REFERENTE A LISTA DE PRODUTO 
        $descricaoProduto = $_POST['descricaoProduto'];
        $quantidade = $_POST['quantidade'];
        $idProduto = $_POST['idProduto'];
        $countProduto = count($_POST['descricaoProduto']);
        $idTransferencia = $_POST['idTransferencia'];
        $idLocal_destino = $_POST['idLocal_destino'];
        // Realizando a subtração e atualizando no Produto a quantidade
        for ($i = 0; $i < $countProduto; $i++) {
            $select_produtoOriginal = mysqli_query($con, "SELECT * FROM produto WHERE idProduto = '$idProduto[$i]'");
            $linha_produto = mysqli_fetch_array($select_produtoOriginal);
            $quantOriginalProduto = $linha_produto['quantidadeProduto'];

            $quantidadeFinal = $quantOriginalProduto - $quantidade[$i];
            $con->query("UPDATE produto SET quantidadeProduto = '$quantidadeFinal' WHERE idProduto = '$idProduto[$i]'");


            $select_prodDestino = mysqli_query($con, "SELECT * FROM produto where descricaoProduto = '$linha_produto[descricaoProduto]' and idLocal = '$idLocal_destino'");
            if (mysqli_num_rows($select_prodDestino) > 0) {
                $linha_prodDestino = mysqli_fetch_array($select_prodDestino);
                $quantidadeProduto = $linha_prodDestino['quantidadeProduto'];
                $quantidadeProdutoFinal = $quantidadeProduto + $quantidade[$i];
                $con->query("UPDATE produto SET quantidadeProduto = '$quantidadeProdutoFinal' where idProduto = $linha_prodDestino[idProduto]");
            } else {
                $con->query("INSERT INTO produto (descricaoProduto,quantidadeProduto,quantidadeMin,idLocal)VALUES
                ('$linha_produto[descricaoProduto]','$quantidade[$i]','$linha_produto[quantidadeMin]','$idLocal_destino')");
            }
        }
        $rows_transferencia = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM transferencia T INNER JOIN local L ON T.idLocal_destino = L.idLocal INNER JOIN usuario U ON U.idUsuario = T.idUsuario  where T.idTransferencia = '$idTransferencia'"));
        $select_item = mysqli_query($con, "SELECT I.quantidade, P.descricaoProduto, P.idProduto, I.nf_especifica, I.valorUnitario FROM itens_transferencia I INNER JOIN produto P ON P.idProduto = I.idProduto where idTransferencia = '$idTransferencia'");
        $rows_historico = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM historico_transferencia H INNER JOIN usuario U ON U.idUsuario = H.idUsuario where H.idTransferencia = '$idTransferencia' and H.acao = 'Transferência Aprovada'"));
        $cont = 0;
        $html .= '<table border="1">';
        $html .= '<tr>';
        $html .= '<td>Quantidade</td>';
        $html .= '<td>Item</td>';
        $html .= '<td>NF</td>';
        $html .= '<td>Unitário</td>';
        $html .= '<td>Total</td>';
        $html .= '</tr>';
        while ($rows_itens = mysqli_fetch_assoc($select_item)) {
            if ($rows_itens['nf_especifica'] == null) {
                $row_last_nf_produto = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM notafiscal where idProduto = '$rows_itens[idProduto]' order by idNotaFiscal desc limit 1"));
                $valorUnitario = $row_last_nf_produto['valor'];
                $nf = $row_last_nf_produto['NumeroNota'];
            } else {
                $valorUnitario = $rows_itens['valorUnitario'];
            }
            if ($cont == 15) {
                $html .= '<div style="page-break-after: always;"></div>';
                $html .= '<img style="position:fixed; top:-50px; left:-48px; width: 95.00%;" src="../img/header.png">';
                $html .= '<div></div><br><br><br><br><br>';
            }

            $total = $valorUnitario * $rows_itens['quantidade'];

            $html .= '<tbody>';
            $html .=  '<tr> <td>' . $rows_itens['quantidade'] . '</td>';
            $html .= ' <td>'  . $rows_itens['descricaoProduto'] . '</td>';
            $html .= ' <td>'  . $nf . '</td>';
            $html .=  ' <td>' . $valorUnitario . '</td>';
            $html .=  ' <td>' . $total . '</td></tr>';
            $html .= '</tbody>';
            $cont += 1;
        }

        $html .= '</table>';



        require_once 'dompdf/autoload.inc.php';
        $dompdf = new Dompdf();
        $dompdf->loadHtml(' 
            <div  style="position:absolute; bottom: 0px; right:5px;"></div>

            <br>
            <br>
            <br>
            <br>
            <center><h2><u>Termo de Transferência </u></h2></center>  
            <p><h3> &nbsp;Transferidor:</h3>
            <div align="justify">
            <strong><p></p></div>
            <br>
            <p><h3> &nbsp;Receptor:</h3>
            <div align="justify">
            <strong><p><u>' . $rows_transferencia['nomeLocal'] . '</u> </p></div>
            <br>
            <br>

            <div align="justify">
            <strong><p>Solicitante:' . $rows_transferencia['solicitante'] . '</p></div>
            <br>
            ' . $html . '
            <div align="justify">
            <strong><p>Realizador da transferência:' . $rows_transferencia['nomeUsuario'] . '</p></div>
            <br>
            <div align="justify">
            <strong><p>Receptor: ' . $linha_usuario['nomeUsuario'] . '</p></div>
            <br>


            <img style="position:fixed; top:-50px; left:-48px; width: 95.00%;" src="../img/header.png">
		
	

');
        $dompdf->render();
        $termoTransferencia = uniqid() . ".pdf";
        $output = $dompdf->output();
        file_put_contents('../termo_transferencia/' . $termoTransferencia . '', $output);
        // $dompdf->setPaper('A4', 'portrait');
        // ob_clean();
        // // Render the HTML as PDF
        // $dompdf->render();

        // // Output the generated PDF to Browser
        // $dompdf->stream(
        //     'teste.pdf',
        //     array(
        //         "Attachment" => false //para realizar o download somente alterar para true
        //     )
        // );


        // Atualizando para Finalizado os Itens Solicitados
        $con->query("UPDATE transferencia  SET status = 1, situacao = 'Finalizado', comprovanteTransferencia = '$termoTransferencia' WHERE idTransferencia = '$idTransferencia'");
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
