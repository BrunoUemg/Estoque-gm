<?php 

include_once "../dao/conexao.php";

$idRequisicao = $_POST['idRequisicao'];
$justificativa = $_POST['justificativa'];
$solicitante = $_POST['solicitante'];

$update_requisicao = "UPDATE requisicao set justificativa = '$justificativa', solicitante = '$solicitante' 
where idRequisicao = '$idRequisicao'";

if($con->query($update_requisicao) === TRUE){
    if(!empty($_FILES["comprovanteRequisicao"]["name"])){
        $pasta_arquivo = "../requisicao/";
        
      
        $formatos = array("png","jpeg","jpg","pdf","PNG","JPEG","JPG");
        $extensao = pathinfo($_FILES['comprovanteRequisicao']['name'], PATHINFO_EXTENSION);
      
        if(in_array($extensao, $formatos)){
          $pasta = "../requisicao/";
          $temporario = $_FILES['comprovanteRequisicao']['tmp_name'];
          $arquivo = "comprovanteRequisicao-".$idRequisicao.$extensao;
      
          if(move_uploaded_file($temporario, $pasta.$arquivo)){
            $sql = "UPDATE requisicao SET comprovanteRequisicao = '$arquivo' where idRequisicao = '$idRequisicao'"; 
          }
        }
        if($con->query($sql)=== true){ 
          echo "<script>alert('Documento alterado com sucesso!');window.location='DadosRequisicao.php?idRequisicao=$idRequisicao'</script>";
        } else {
             echo "Erro para inserir: " . $con->error; }
      }
      echo "<script>alert('Cadastro alterado com sucesso!');window.location='DadosRequisicao.php?idRequisicao=$idRequisicao'</script>";
}

?>