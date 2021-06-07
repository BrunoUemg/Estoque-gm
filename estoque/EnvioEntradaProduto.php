<?php
include_once "../dao/conexao.php";

$idProduto = $_POST["idProduto"];
$numeroNota = $_POST["numeroNota"];
$quantidadeEntrada = $_POST["quantidadeEntrada"];
$data = date ("Y-m-d");



$sql = "INSERT INTO notafiscal (idProduto,numeroNota,quantidade,dataEntrada,status) VALUES ($idProduto, '$numeroNota','$quantidadeEntrada','$data', 0)";

if ($con->query($sql) === TRUE){
   

      $query = mysqli_query($con, "SELECT Max(idNotaFiscal)  AS codigo FROM notafiscal");
      $result = mysqli_fetch_array($query);
  
      $idNotaFiscal = $result['codigo'];

      if (isset($_FILES['comprovanteFiscal'] )){

        
    
        $extensao1 = strtolower(substr($_FILES['comprovanteFiscal']['name'], -4));
        
    
        $novo_nome1 = "comprovanteFiscal-".$idNotaFiscal.$extensao1; //define o nome do arquivo
     
    
        $diretorio ="../nota_fiscal/"; 
        
        move_uploaded_file($_FILES['comprovanteFiscal']['tmp_name'], $diretorio.$novo_nome1);
        
    
    
    $sql3 = "UPDATE notafiscal SET comprovanteFiscal = '$novo_nome1' where idNotaFiscal ='$idNotaFiscal'"; 
    
    }
    if($con->query($sql3) === TRUE){ 
    echo "<script>alert('Produto adicionado com sucesso!');window.location='ConsultarProduto.php'</script>";
    }
    
} else {
	echo "Erro para inserir: " . $con->error;
}
$con->close();
?>