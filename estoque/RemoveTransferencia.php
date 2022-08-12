<?php

$idProduto = $_GET['idProduto'] . " ";
session_start();

foreach ($_SESSION['transferencia'] as $key => $value) {
    if (in_array("$idProduto", $_SESSION['transferencia'][$key])) {
        // echo "Key exists!";
        $valorAtual = $key;
    } else {
        //   echo "Key does not exist!";
    }
}

unset($_SESSION['transferencia'][$valorAtual]);
echo "<script>alert('Item excluido com sucesso!');window.location='FinalizarTransferencia.php'</script>";
