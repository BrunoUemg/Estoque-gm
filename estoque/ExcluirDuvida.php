<?php

include_once "../dao/conexao.php";
session_start();
$idPergunta = $_GET['idPergunta'];

$con->query("DELETE FROM duvidas where idPergunta = '$idPergunta'");

$_SESSION['msg'] = ' <div class="alert alert-success" role="alert"> <p> Excluido com sucesso! </div> </p> ';
echo "<script>window.location='ConsultarDuvidas.php'</script>";
exit();
