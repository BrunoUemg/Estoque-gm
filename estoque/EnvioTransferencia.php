<?php 

include_once "../dao/conexao.php";

session_start();


$justificativa = $_POST["justificativa"];
$solicitante = $_POST["solicitante"];
$data = $_POST["data"];
$idUsuario= $_POST['idUsuario'];
$idLocal_destino = $_POST['idLocal_destino'];

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$hora = date("H:i");


$con->query("INSERT INTO transferencia (dataTransferencia, horaTransferencia, status, justificativa,
solicitante,idUsuario, situacao, idLocal_destino)VALUES('$data', '$hora', 0,'$justificativa', '$solicitante',
'$idUsuario', 'Pendente', '$idLocal_destino')");

$idTransferencia = mysqli_insert_id($con);


use Dompdf\Dompdf;

require_once 'dompdf/autoload.inc.php';
$dompdf = new Dompdf();
$dompdf->loadHtml(' 
<div  style="position:absolute; bottom: 0px; right:5px;">  Página 1 de 1 </div>

<br>
<br>
<br>
<br>
<center><h2><u>Termo de Transferência </u></h2></center>  

<div align="justify">
<strong><p>Advertimos, por escrito, V. Senhoria pela falta disciplinar praticada descrita a seguir: ' . $descricao2 . ' </p></div>
<br>
<div align="justify">
<strong><p><u>Esperamos que a falta não ocorra novamente, sob pena de demissão por justa causa, nos termos da Consolidação das Leis do Trabalho.</u> </p></div>
<br>





	<br>
	<br>
	<br>
	<table style="width: 100%;">
	  <tbody>
	  <tr>
	  <td style="width: 50.0000%;"></td>
	  <td style="width: 50.0000%;">______________________________________ </td>
	  <td style="width: 50.0000%;"> </td>
	</tr>
	<tr>
  
	<td style="width: 50.0000%;"></td>
	  <td style="width: 50.0000%;"><center><strong>' . $linha['vinculo'] . ' <br> ' . $linha2['cnpj'] . '</strong></center></td>
	  <td style="width: 50.0000%;"><br>
	  </td>
	  
	  
	</tr>
  
	
	
		</tbody>
		</table>

	  <br>

	  <br>	




	  <center><h4><u>Orientação/acompanhamento </u></h4></center> 
	  <table border=1 style="width: 100%;">
<tbody>
<tr>
<td><br></td>
</tr>
<tr>
<td><br></td>
</tr>
<br>

</tbody>
</table>




	
<p>Documento gerado por ' . $linha_usuario['nomeUsuario'] . ' em ' . $data_hoje . ' às ' . $hora_gerada . '.</p>
   

   

<img style="position:fixed; top:-50px; left:-48px; width: 95.00%;" src="img/header.png">
		
	

');
$dompdf->render();
$nomeCapaFrente = uniqid() . ".pdf";
$output = $dompdf->output();
file_put_contents('../termo_transferencia/' . $nomeCapaFrente . '', $output);



foreach($_SESSION['transferencia'] as $transferencia)
{
    $idProduto = $transferencia['idProduto'];
    $idLocal_origem = $transferencia['idLocal'];
    $quantidade = $transferencia['quantidade'];
    $nf_especifica = $transferencia['comprovanteFiscal'];
    $valorUnitario = $transferencia['valorUnitario'];
    if($idLocal_destino != $idLocal_origem){
    $con->query("INSERT INTO itens_transferencia (idProduto, idTransferencia, idLocal_origem, quantidade, nf_especifica, valorUnitario)VALUES('$idProduto',
    '$idTransferencia','$idLocal_origem', '$quantidade', '$nf_especifica', '$valorUnitario')");
    }
    unset($_SESSION['transferencia'][$idProduto]);
}

$con->query("INSERT INTO historico_transferencia (data, hora, idTransferencia, acao, idUsuario)VALUES('$data','$hora', '$idTransferencia', 'Encaminhou a transferência','$idUsuario')");

echo "<script>alert('Transferência realizada com sucesso!');window.location='ConsultarProduto.php'</script>";
exit();