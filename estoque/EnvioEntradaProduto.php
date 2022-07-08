<?php
include_once "../dao/conexao.php";

session_start();
$numeroNota = $_POST["numeroNota"];
$idFornecedor = $_POST['idFornecedor'];
$data = date ("Y-m-d");

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




      if (isset($_FILES['comprovanteFiscal'] )){

        
    
        $extensao1 = strtolower(substr($_FILES['comprovanteFiscal']['name'], -4));
        
    
        $novo_nome1 = "comprovanteFiscal-".uniqid().$extensao1; //define o nome do arquivo
     
    
        $diretorio ="../nota_fiscal/"; 
        
        move_uploaded_file($_FILES['comprovanteFiscal']['tmp_name'], $diretorio.$novo_nome1);

        $pdf = new FPDI();
        // Setando Destino do PDF Principal
        $pagecount = $pdf->setSourceFile("../nota_fiscal/$novo_nome1");
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
       
        $doc1 = "comprovanteFiscal_".uniqid().$extensao1;
        /* Salvando a junção dos PDF */
        $output = $pdf->Output("../nota_fiscal/$doc1", "F");
        /* Destruindo o PDF Antigo que foi utilizado para juntar com a Assinatura */
        unlink("../nota_fiscal/$novo_nome1");

        
    
    }


    foreach($_SESSION['carrinho2'] as $lista){

      $idProduto = $lista['idProduto'];
      $quantidadeEntrada = $lista['quantidadeEntrada'];
      $valor = $lista['valor'];

      $con->query("INSERT INTO notafiscal (numeroNota,quantidade,dataEntrada,idProduto,comprovanteFiscal,status,valor,idFornecedor,idUsuario)VALUES
      ('$numeroNota','$quantidadeEntrada','$data','$idProduto','$doc1',0,'$valor','$idFornecedor','$_SESSION[idUsuario]')");

      $select_produto = "SELECT * FROM produto where idProduto = '$idProduto'";
      $res = $con->query($select_produto);
      $linha = $res->fetch_assoc();
      $con->query("INSERT INTO historico (dataHistorico,descricaoHistorico,idUsuario)VALUES('$data','Deu entrada no produto $linha[descricaoProduto]', '$_SESSION[idUsuario]')");

      unset($_SESSION['carrinho2'][$idProduto]);
    
    }



     
     
    echo "<script>alert('Produto adicionado com sucesso!');window.location='ConsultarProduto.php'</script>";
    
    

$con->close();
