<?php
include_once "../dao/conexao.php";


$numeroNota = $_POST["numeroNota"];
$idFornecedor = $_POST['idFornecedor'];
$data = date ("Y-m-d");

session_start();


      if (isset($_FILES['comprovanteFiscal'] )){

        
    
        $extensao1 = strtolower(substr($_FILES['comprovanteFiscal']['name'], -4));
        
    
        $novo_nome1 = "comprovanteFiscal-".uniqid().$extensao1; //define o nome do arquivo
     
    
        $diretorio ="../nota_fiscal/"; 
        
        move_uploaded_file($_FILES['comprovanteFiscal']['tmp_name'], $diretorio.$novo_nome1);
        
    
    }


    foreach($_SESSION['carrinho2'] as $lista){

      $idProduto = $lista['idProduto'];
      $quantidadeEntrada = $lista['quantidadeEntrada'];
      $valor = $lista['valor'];

      $con->query("INSERT INTO notafiscal (numeroNota,quantidade,dataEntrada,idProduto,comprovanteFiscal,status,valor,idFornecedor,idUsuario)VALUES
      ('$numeroNota','$quantidadeEntrada','$data','$idProduto','$novo_nome1',0,'$valor','$idFornecedor','$_SESSION[idUsuario]')");

      $select_produto = "SELECT * FROM produto where idProduto = '$idProduto'";
      $res = $con->query($select_produto);
      $linha = $res->fetch_assoc();
      $con->query("INSERT INTO historico (dataHistorico,descricaoHistorico,idUsuario)VALUES('$data','Deu entrada no produto $linha[descricaoProduto]', '$_SESSION[idUsuario]')");

      unset($_SESSION['carrinho2'][$idProduto]);
    
    }



     
     
    echo "<script>alert('Produto adicionado com sucesso!');window.location='ConsultarProduto.php'</script>";
    
    

$con->close();
?>