<?php 

include_once "../dao/conexao.php";

$nomeCidade = $_POST['nomeCidade'];

$select_cidade = mysqli_query($con,"SELECT * FROM cidade where nomeCidade = '$nomeCidade'");

if(mysqli_num_rows($select_cidade) > 0){
    echo "<script>alert('Cidade já possui cadastro!');window.location='MenuPrincipal.php'</script>";
    exit();
}else{
    $con->query("INSERT INTO cidade (nomeCidade)VALUES('$nomeCidade')");
    echo "<script>alert('Cadastro realizado com sucesso!');window.location='MenuPrincipal.php'</script>";
    exit();
}