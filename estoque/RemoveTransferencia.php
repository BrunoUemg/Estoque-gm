<?php

$idProduto =$_GET['idProduto'];

session_start();

unset($_SESSION['transferencia'][$idProduto]);

echo "<script>alert('Item excluido com sucesso!');window.location='FinalizarTransferencia.php'</script>";

?>
