<?php

$idProduto = $_GET['idProduto'];

unset($_SESSION['transferencia'][11]);


echo "<script>alert('Item excluido com sucesso!');window.location='FinalizarTransferencia.php'</script>";
