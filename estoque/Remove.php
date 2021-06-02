<?php

$idProduto =$_GET['idProduto'];

session_start();

unset($_SESSION['carrinho'][$idProduto]);

echo "<script>alert('Item excluido com sucesso!');window.location='Carrinho.php'</script>";

?>
