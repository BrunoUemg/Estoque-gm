<?php

include_once "../dao/conexao.php";

session_start();

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$con->query("UPDATE `duvidas` SET `tituloPergunta`= '$dados[titulo]', `respostaPergunta` = '$dados[resposta]' WHERE idPergunta = '$dados[idPergunta]'");
$_SESSION['msg'] = ' <div class="alert alert-success" role="alert"> <p> Alterado com sucesso! </div> </p> ';
echo "<script>window.location='ConsultarDuvidas.php'</script>";
exit();
