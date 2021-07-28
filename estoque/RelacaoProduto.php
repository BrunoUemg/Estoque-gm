<?php
include_once("Head.php");

?>

<?php
include "../dao/conexao.php";

$idProduto=$_GET['idProduto'];

if(isset($_POST['dataInicio']))
{
    $result_produto = "SELECT * FROM produto where idProduto = '$idProduto'";
    $res = $con->query($result_produto);
    $linha3 = $res->fetch_assoc();

    $dataInicio = $_POST['dataInicio'];
    $dataFinal = $_POST['dataFinal'];
    $result_consultaFiscal = "SELECT SUM(quantidade) as total FROM notafiscal 
    WHERE idProduto = '$idProduto' and dataEntrada >= '$dataInicio' and dataEntrada <= '$dataFinal' and status = 1 ";
    $res = $con-> query($result_consultaFiscal);
    $linha = $res->fetch_assoc();

    $resul_requisicao = "SELECT SUM(listarequisicao.quantidade) AS total FROM listarequisicao INNER JOIN requisicao 
    ON requisicao.idRequisicao = listarequisicao.idRequisicao where idProduto = '$idProduto' and requisicao.data >= '$dataInicio' and requisicao.data <= '$dataFinal' and requisicao.status = 1";
    $res = $con->query($resul_requisicao);
    $linha2 = $res->fetch_assoc();
    
    $totalSaida = $linha2['total'];
    $totalEntrada = $linha['total'];
    $totalDiferenca = ($totalEntrada - $totalSaida);

}







?>
  <div class="col-lg-12 mb-12">
          <div class="card shadow mb-12">
                <div class="card-header py-3">
                  <h4 class="m-0 font-weight-bold text-primary">Relação do Produto </h4>
                </div>
                <div class="card-body">
                 
                <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
                <div class="row g-3">
  <div class="col">
      <label for="">Data início</label>
    <input type="date" class="form-control" required="required" value="<?php echo $dataInicio ?>" name="dataInicio">
  </div>
  <div class="col">
      <label for="">Data Final</label>
    <input type="date" class="form-control" required="required" value="<?php echo $dataFinal; ?>" name="dataFinal">
  </div>
</div>
    <br>
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <input type="button" name="cancelar" class="btn btn-primary" onClick="window.location.href='ConsultarProduto.php'" value="Cancelar">
                <input type="submit" name="enviar" class="btn btn-success"  value="Buscar">
              </div>
            </div>
</form>

<?php if(isset($result_consultaFiscal)){ ?>
 <!-- Content Row -->
 <div class="row">

<!-- Content Column -->
<div class="col-lg-12 mb-4">

  <!-- Project Card Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Total de saídas e entradas de <?php echo $linha3['descricaoProduto']; ?> por data</h6>
    </div>
    <div class="card-body">
      <h4 class="small font-weight-bold">Saída <span class="float-right">-<?php echo $linha2['total'];?></span></h4>
      <div class="progress mb-4">
        <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $totalSaida;?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <h4 class="small font-weight-bold">Entrada <span class="float-right">+<?php echo $linha['total']; ?></span></h4>
      <div class="progress mb-4">
        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $linha['total']; ?>%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <h4 class="small font-weight-bold">Total do Produto <span class="float-right"><?php echo $totalDiferenca;?></span></h4>
      <div class="progress mb-4">
        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $totalDiferenca;?>%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
     
     
    </div>
  </div>
  <?php } ?>



                </div>
              </div>
</div> 


<?php
include_once("Footer.php");

?>