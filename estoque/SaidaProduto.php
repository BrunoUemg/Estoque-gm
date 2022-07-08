<?php

include_once "../dao/conexao.php";
session_start();
$justificativa = $_POST["justificativa"];
$solicitante = $_POST["solicitante"];
$data = $_POST["data"];
$idUsuario = $_POST['idUsuario'];

require_once('FPDF/fpdf.php');
require_once('FPDI/src/autoload.php');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$data_criacao = date("Y-m-d");
$data_hoje = date("d/m/Y");
$hora_gerada = date("H:i:s");

use setasign\Fpdi\Fpdi;

$sql2 = "SELECT * FROM usuario where idUsuario = $_SESSION[idUsuario]";
$sql2Final = mysqli_query($con, $sql2);
$res = $con->query($sql2);
$linha_usuario = $res->fetch_assoc();

$query = mysqli_query($con, "SELECT Max(idRequisicao) AS MaiorId FROM requisicao");
$result = mysqli_fetch_array($query);


if ($result['MaiorId'] == NULL) {

    $result['MaiorId'] = 1;
} else {
    $query = mysqli_query($con, "SELECT Max(idRequisicao) + 1 AS MaiorId FROM requisicao");

    $result = mysqli_fetch_array($query);
}

$ano = date("Y");

$codigo = $ano . "-" . $result['MaiorId'];

$sql = "INSERT INTO requisicao (justificativa,solicitante,data,codigo,idUsuario, status)
    values ('$justificativa','$solicitante','$data','$codigo',$idUsuario, 0)";

if ($con->query($sql) === TRUE) {

    $idRequisicao = mysqli_insert_id($con);

    foreach ($_SESSION['carrinho'] as $lista) {

        $idProduto = $lista['idProduto'];
        $idLocal =  $lista['idLocal'];
        $quantidade = $lista['quantidade'];
        $quantidadeMax = $lista['quantidadeMax'];

        $sql2 = "INSERT INTO listarequisicao (idRequisicao,idProduto,idLocal,quantidade,status)
    values ($idRequisicao,$idProduto,$idLocal,'$quantidade', 0)";

        $qtdFinal = $quantidadeMax - $quantidade;






        if ($con->query($sql2) === TRUE) {

            unset($_SESSION['carrinho'][$idProduto]);

            $query = mysqli_query($con, "SELECT Max(idRequisicao)  AS codigo FROM requisicao");
            $result = mysqli_fetch_array($query);

            $idRequisicao = $result['codigo'];

            if (isset($_FILES['comprovanteRequisicao'])) {



                $extensao1 = strtolower(substr($_FILES['comprovanteRequisicao']['name'], -4));


                $novo_nome1 = "comprovanteRequisicao-" . $idRequisicao . $extensao1; //define o nome do arquivo


                $diretorio = "../requisicao/";

                move_uploaded_file($_FILES['comprovanteRequisicao']['tmp_name'], $diretorio . $novo_nome1);
                $pdf = new FPDI();
                // Setando Destino do PDF Principal
                $pagecount = $pdf->setSourceFile("../requisicao/$novo_nome1");
                for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {
                    /* Pegando Total de Páginas */
                    $tplIdx = $pdf->importPage($pageNo);
                    // Adicionando Todas as Páginas
                    $pdf->AddPage('P', 'A4'); // Se for Imprimir em Paisagem Deixar em L caso for Retrato deixa P
                    // Utilizando as Páginas
                    $pdf->useTemplate($tplIdx);
                    //Decidindo a Fonte
                    $pdf->SetFont('Arial', '', 10);
                }
                /* Assinatura 1 e Continuidade */
                $assinatura = "Documento assinado e inserido por: " . $linha_usuario['nomeUsuario'] . "";
                $assinaturaCont = "User acesso: " . $linha_usuario['userAcesso'] .  " em "  . $data_hoje . " as " . $hora_gerada . "";
                /* Adicionando Assinatura e Quebrando a Linha*/
                $pdf->Text(65, 285, $assinatura);
                $pdf->Text(65, 290, $assinaturaCont);
                /* Setando o nome + extensão */
                unlink("../requisicao/$novo_nome1");
                $doc1 = "comprovanteRequisicao-" . $idRequisicao . $extensao1;
                /* Salvando a junção dos PDF */
                $output = $pdf->Output("../requisicao/$doc1", "F");
                /* Destruindo o PDF Antigo que foi utilizado para juntar com a Assinatura */

                $sql4 = "UPDATE requisicao SET comprovanteRequisicao = '$novo_nome1' where idRequisicao ='$idRequisicao'";
            }





            if ($con->query($sql4) === TRUE) {

                $con->query("INSERT INTO historico (dataHistorico,descricaoHistorico,idUsuario)VALUES('$data','Fez requisição de produto(s)', '$idUsuario')");
                echo "<script>alert('Retirada realizada com sucesso!');window.location='Carrinho.php'</script>";
            }


            echo "<script>alert('Retirada realizada com sucesso!');window.location='Carrinho.php'</script>";
        } else {
            echo "Erro para inserir: " . $con->error;
        }
    }
} else
    echo "Erro para inserir: " . $con->error;

$con->close();
