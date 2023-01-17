<?php

include_once "conexao.php";

$idUsuario = $_GET['idUsuario'];
$userAcesso = $_GET['userAcesso'];

$senha_nova = password_hash($userAcesso, PASSWORD_DEFAULT);

$con->query("UPDATE usuario SET senha = '$senha_nova' WHERE idUsuario = '$idUsuario'");

echo "<script>alert('Senha resetada com sucesso!');window.location='../estoque/ConsultarFuncionario.php'</script>";