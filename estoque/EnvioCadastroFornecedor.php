<?php 

include_once "../dao/conexao.php";

$razaoSocial = $con->escape_string($_POST['razaoSocial']);
$nomeFantasia = $con->escape_string($_POST['nomeFantasia']);
$telefone = $con->escape_string($_POST['telefone']);
$celular = $con->escape_string($_POST['celular']);
$email = $con->escape_string($_POST['email']);
$doc = $con->escape_string($_POST['doc']);
$observacao = $con->escape_string($_POST['observacao']);

$select_fornecedor = mysqli_query($con,"SELECT * FROM fornecedor where nomeFantasia = '$nomeFantasia'");

if(mysqli_num_rows($select_fornecedor) > 0){
    echo "<script>alert('Fornecedor já foi cadastrado');window.location='CadastrarFornecedor.php'</script>";
    exit();
}else{
$con->query("INSERT INTO fornecedor (razaoSocial, nomeFantasia, telefone, celular, email, doc, observacao)VALUES('$razaoSocial', '$nomeFantasia', '$telefone', '$celular', '$email', '$doc', '$observacao')");
echo "<script>alert('Cadastro realizado com sucesso!');window.location='CadastrarFornecedor.php'</script>";
exit();
}

?>