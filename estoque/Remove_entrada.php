<?php

$idProduto =$_GET['idProduto'];

session_start();

unset($_SESSION['carrinho2'][$idProduto]);

echo "<script>alert('Item excluido com sucesso!');window.location='EntradaProduto.php'</script>";

?>
