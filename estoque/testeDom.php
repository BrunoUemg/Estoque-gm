<?php

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
<p><h3> &nbsp;Transferidor:</h3>
<div align="justify">
<strong><p></p></div>
<br>
<p><h3> &nbsp;Receptor:</h3>
<div align="justify">
<strong><p><u></u> </p></div>
<br>
<br>
<br>

<div align="justify">
<strong><p>Solicitante:</p></div>
<br>


<img style="position:fixed; top:-50px; left:-48px; width: 95.00%;" src="../img/header.png">
		
	

');
// $dompdf->render();
// $nomeCapaFrente = uniqid() . ".pdf";
// $output = $dompdf->output();
// file_put_contents('../termo_transferencia/' . $nomeCapaFrente . '', $output);
$dompdf->setPaper('A4', 'portrait');
ob_clean();
// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream(
    'teste.pdf',
    array(
        "Attachment" => false //para realizar o download somente alterar para true
    )
);
