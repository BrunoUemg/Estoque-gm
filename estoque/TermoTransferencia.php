<?php

include_once "../dao/conexao.php";

require_once('libmergepdf/autoload.php');

$pdf = new \Jurosh\PDFMerge\PDFMerger;

$idTransferencia = $_GET['idTransferencia'];

$select_itens = mysqli_query($con,"SELECT * FROM itens_transferencia where idTransferencia = '$idTransferencia'");

while($rows_itens = mysqli_fetch_assoc($select_itens)){
    if($rows_itens['nf_especifica']){
        $pdf->addPDF('../nota_fiscal/' . $rows_itens['nf_especifica'] . '', 'all');
    }else{
        $row_last_nf_produto = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM notafiscal where idProduto = '$rows_itens[idProduto]' order by idNotaFiscal desc limit 1"));
        $pdf->addPDF('../nota_fiscal/' . $row_last_nf_produto['comprovanteFiscal'] . '', 'all');
    }
}
ob_end_clean();

$pdf->merge('browser', uniqid() . '_Relatorio_termo_nfs.pdf');