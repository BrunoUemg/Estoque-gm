<?php 

include_once "../dao/conexao.php";

session_start();


$justificativa = $_POST["justificativa"];
$solicitante = $_POST["solicitante"];
$data = $_POST["data"];
$idUsuario= $_POST['idUsuario'];
$idLocal_destino = $_POST['idLocal_destino'];

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$hora = date("H:i");


$con->query("INSERT INTO transferencia (dataTransferencia, horaTransferencia, status, justificativa,
solicitante,idUsuario, situacao, idLocal_destino)VALUES('$data', '$hora', 0,'$justificativa', '$solicitante',
'$idUsuario', 'Pendente', '$idLocal_destino')");

$idTransferencia = mysqli_insert_id($con);

foreach($_SESSION['transferencia'] as $transferencia)
{
    $idProduto = $transferencia['idProduto'];
    $idLocal_origem = $transferencia['idLocal'];
    $quantidade = $transferencia['quantidade'];
    if($idLocal_destino != $idLocal_origem){
    $con->query("INSERT INTO itens_transferencia (idProduto, idTransferencia, idLocal_origem, quantidade)VALUES('$idProduto',
    '$idTransferencia','$idLocal_origem', '$quantidade')");
    }
    unset($_SESSION['transferencia'][$idProduto]);
}

$con->query("INSERT INTO historico_transferencia (data, hora, idTransferencia, acao, idUsuario)VALUES('$data','$hora', '$idTransferencia', 'Encaminhou a transferência','$idUsuario')");

echo "<script>alert('Transferência realizada com sucesso!');window.location='Carrinho.php'</script>";
exit();