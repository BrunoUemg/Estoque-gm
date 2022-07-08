<?php

include_once "../dao/conexao.php";

session_start();

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$select = mysqli_query($con, "SELECT * FROM duvidas where tituloPergunta = '$dados[titulo]'");

if (mysqli_num_rows($select) < 1) {
    $con->query("INSERT INTO duvidas (tituloPergunta, respostaPergunta) VALUES ('$dados[titulo]', '$dados[resposta]')");
    $_SESSION['msg'] = ' <div class="alert alert-success" role="alert"> <p> Pergunta e Respostas cadastradas com sucesso! </div> </p> ';
    echo "<script>window.location='CadastrarDuvidas.php'</script>";
    exit();
} else {
    $_SESSION['msg'] = ' <div class="alert alert-danger" role="alert"> <p> Essa Pergunta já encontra-se no sistema ! </div> </p> ';
    echo "<script>window.location='CadastrarDuvidas.php'</script>";
    exit();
}
