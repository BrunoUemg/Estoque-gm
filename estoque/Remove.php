<?php

// $idProduto =$_GET['idProduto'];

// session_start();

// unset($_SESSION['carrinho'][$idProduto]);

// echo "<script>alert('Item excluido com sucesso!');window.location='Carrinho.php'</script>";

$idProduto = $_GET['idProduto'] . " ";
session_start();

foreach ($_SESSION['carrinho'] as $key => $value) {
    if (in_array("$idProduto", $_SESSION['carrinho'][$key])) {
        // echo "Key exists!";
        $valorAtual = $key;
    } else {
        //   echo "Key does not exist!";
    }
}

unset($_SESSION['carrinho'][$valorAtual]);
echo "<script>alert('Item excluido com sucesso!');window.location='Carrinho.php'</script>";


?>
