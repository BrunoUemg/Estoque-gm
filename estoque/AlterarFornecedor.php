<?php 

include_once "../dao/conexao.php";

$razaoSocial = $con->escape_string($_POST['razaoSocial']);
$nomeFantasia = $con->escape_string($_POST['nomeFantasia']);
$telefone = $con->escape_string($_POST['telefone']);
$celular = $con->escape_string($_POST['celular']);
$email = $con->escape_string($_POST['email']);
$idFornecedor = $con->escape_string($_POST['idFornecedor']);
$doc = $con->escape_string($_POST['doc']);
$observacao = $con->escape_string($_POST['observacao']);

$select_fornecedor = mysqli_query($con,"SELECT * FROM fornecedor where nomeFantasia = '$nomeFantasia'");
$result = mysqli_fetch_array($select_fornecedor);

if(mysqli_num_rows($select_fornecedor) > 0 && $result['idFornecedor'] != $idFornecedor ){
    echo "<script>alert('Fornecedor já foi cadastrado');window.location='ConsultarFornecedor.php'</script>";
    exit();
}else{
$con->query("UPDATE fornecedor set razaoSocial = '$razaoSocial', nomeFantasia = '$nomeFantasia', 
telefone = '$telefone', celular = '$celular', email = '$email', doc = '$doc', observacao = '$observacao' where idFornecedor = '$idFornecedor'");
echo "<script>alert('Alterado com sucesso!');window.location='ConsultarFornecedor.php'</script>";
exit();
}




?>