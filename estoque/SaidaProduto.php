<?php 

include_once "../dao/conexao.php";
session_start();
$justificativa = $_POST["justificativa"];
$solicitante = $_POST["solicitante"];
$data = $_POST["data"];
$idUsuario= $_POST['idUsuario'];

$query = mysqli_query($con, "SELECT Max(idRequisicao) AS MaiorId FROM requisicao");
$result = mysqli_fetch_array($query);


if ($result['MaiorId'] == NULL ){

    $result['MaiorId'] = 1;


}
else {
    $query = mysqli_query($con, "SELECT Max(idRequisicao) + 1 AS MaiorId FROM requisicao");

    $result = mysqli_fetch_array($query);
}

$ano = date ("Y");

$codigo= $ano."-".$result['MaiorId'];

$sql = "INSERT INTO requisicao (justificativa,solicitante,data,codigo,idUsuario, status)
    values ('$justificativa','$solicitante','$data','$codigo',$idUsuario, 0)";

if ($con->query($sql) === TRUE)
{
   
    $idRequisicao = mysqli_insert_id($con);
   
    foreach($_SESSION['carrinho'] as $lista) {

        $idProduto= $lista['idProduto']; 
        $idLocal =  $lista['idLocal'];
        $quantidade= $lista['quantidade'];
        $quantidadeMax= $lista['quantidadeMax'];

        $sql2 = "INSERT INTO listarequisicao (idRequisicao,idProduto,idLocal,quantidade,status)
    values ($idRequisicao,$idProduto,$idLocal,'$quantidade', 0)";
    
    $qtdFinal= $quantidadeMax - $quantidade;

   
   



	if ($con->query($sql2) === TRUE){

        unset($_SESSION['carrinho'][$idProduto]);

        $query = mysqli_query($con, "SELECT Max(idRequisicao)  AS codigo FROM requisicao");
        $result = mysqli_fetch_array($query);
    
        $idRequisicao = $result['codigo'];
  
        if (isset($_FILES['comprovanteRequisicao'] )){
  
          
      
          $extensao1 = strtolower(substr($_FILES['comprovanteRequisicao']['name'], -4));
          
      
          $novo_nome1 = "comprovanteRequisicao-".$idRequisicao.$extensao1; //define o nome do arquivo
       
      
          $diretorio ="../requisicao/"; 
          
          move_uploaded_file($_FILES['comprovanteRequisicao']['tmp_name'], $diretorio.$novo_nome1);
          
      
      
      $sql4 = "UPDATE requisicao SET comprovanteRequisicao = '$novo_nome1' where idRequisicao ='$idRequisicao'"; 
      
      }
      if($con->query($sql4) === TRUE){ 

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
?>