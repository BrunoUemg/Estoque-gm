<?php 

include_once "../dao/conexao.php";

$idNotaFiscal = $_POST['idNotaFiscal'];
$quantidade = $_POST['quantidade'];
$numeroNota = $_POST['numeroNota'];
$idFornecedor = $_POST['idFornecedor'];
$valor = $_POST['valor'];

$update_nota = "UPDATE notafiscal set quantidade = '$quantidade', numeroNota = '$numeroNota', idFornecedor = '$idFornecedor', valor = '$valor'
where idNotaFiscal = '$idNotaFiscal'";

if($con->query($update_nota) === TRUE){
    if(!empty($_FILES["comprovanteFiscal"]["name"])){
        $pasta_arquivo = "../nota_fiscal/";
        
      
        $formatos = array("png","jpeg","jpg","pdf","PNG","JPEG","JPG");
        $extensao = pathinfo($_FILES['comprovanteFiscal']['name'], PATHINFO_EXTENSION);
      
        if(in_array($extensao, $formatos)){
          $pasta = "../nota_fiscal/";
          $temporario = $_FILES['comprovanteFiscal']['tmp_name'];
          $arquivo = "ComprovanteFiscal-".$idNotaFiscal.$extensao;
      
          if(move_uploaded_file($temporario, $pasta.$arquivo)){
            $sql = "UPDATE notafiscal SET comprovanteFiscal = '$arquivo' where idNotaFiscal = '$idNotaFiscal'"; 
          }
        }
        if($con->query($sql)=== true){ 
          echo "<script>alert('Documento alterado com sucesso!');window.location='DadosNotaFiscal.php?idNotaFiscal=$idNotaFiscal'</script>";
        } else {
             echo "Erro para inserir: " . $con->error; }
      }
      echo "<script>alert('Cadastro alterado com sucesso!');window.location='DadosNotaFiscal.php?idNotaFiscal=$idNotaFiscal'</script>";
}

?>