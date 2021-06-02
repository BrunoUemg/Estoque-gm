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

$sql = "INSERT INTO requisicao (justificativa,solicitante,data,codigo,idUsuario)
    values ('$justificativa','$solicitante','$data','$codigo',$idUsuario)";

if ($con->query($sql) === TRUE)
{
   
    $idRequisicao = mysqli_insert_id($con);
   
    foreach($_SESSION['carrinho'] as $lista) {

        $idProduto= $lista['idProduto']; 
        $idLocal =  $lista['idLocal'];
        $quantidade= $lista['quantidade'];
$quantidadeMax= $lista['quantidadeMax'];

        $sql2 = "INSERT INTO listarequisicao (idRequisicao,idProduto,idLocal,quantidade)
    values ($idRequisicao,$idProduto,$idLocal,'$quantidade')";
    
    $qtdFinal= $quantidadeMax - $quantidade;

    $sql3="UPDATE produto set quantidadeProduto =$qtdFinal where idProduto= '$idProduto' and idLocal= '$idLocal' ";

    if ($con->query($sql3) === TRUE){

	if ($con->query($sql2) === TRUE){

        unset($_SESSION['carrinho'][$idProduto]);

        echo "<script>alert('Retirada realizada com sucesso!');window.location='Carrinho.php'</script>";
    } else {
            echo "Erro para inserir: " . $con->error; 
            }
        } else { echo "Erro para inserir: " . $con->error; }
    }
} else 
        echo "Erro para inserir: " . $con->error; 
    
   $con->close();
?>