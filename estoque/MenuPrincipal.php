<?php
include_once("Head.php");

$result_consultaRequisicao = "SELECT COUNT(R.idRequisicao) as 'cont' FROM requisicao R where R.status = 0 ";
$resultado_consultaRequisicao = mysqli_query($con, $result_consultaRequisicao);
$linhaSaida = mysqli_fetch_array($resultado_consultaRequisicao);
$result_consultaEntrada = "SELECT COUNT(N.idNotaFiscal) as 'cont' FROM notafiscal N where N.status = 0 ";
$resultado_consultaRequisicao = mysqli_query($con, $result_consultaEntrada);
$linhaEntrada = mysqli_fetch_array($resultado_consultaRequisicao);
$result_consultaTransferencia = "SELECT * FROM transferencia N where N.status = 0 ";
$resultado_consultaTransferencia = mysqli_query($con, $result_consultaTransferencia);

$contador = 0;
while ($rows_transferencia = mysqli_fetch_assoc($resultado_consultaTransferencia)) {
  $select_localusu = mysqli_query($con, "SELECT * FROM local_usuario where idUsuario = '$_SESSION[idUsuario]' and idLocal = '$rows_transferencia[idLocal_destino]'");

  if (mysqli_num_rows($select_localusu) > 0 || $_SESSION['idLocal'] == null) {
    $contador += 1;
  }
}
?>
<?php if ($_SESSION['idLocal'] == null) { ?>
  <?php if ($linhaSaida['cont'] > 0) { ?>
    <div class="alert alert-warning">
      <a href="SaidasPendentes.php">Possui <?php echo $linhaSaida['cont'] ?> saída(s) pendente(s)</a>
    </div>
  <?php } ?>
  <?php if ($linhaEntrada['cont'] > 0) { ?>
    <div class="alert alert-warning">
      <a href="EntradasPendentes.php">Possui <?php echo $linhaEntrada['cont'] ?> entrada(s) pendente(s)</a>
    </div>
  <?php } ?>

<?php } ?>

<?php 
if($linha2['receberTransferencia'] == 1 || $_SESSION['idLocal'] == 0){
if ($contador > 0) { ?>
    <div class="alert alert-warning">
      <a href="ReceberProduto.php">Possui <?php echo $contador ?> transferência(s) pendente(s)</a>
    </div>
  <?php } } ?>


<?php if ($_SESSION['idLocal'] == null) { ?>
  <form action="EnvioCidade.php" method="post">
    <div class="col-lg-6 mb-4">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-0 font-weight-bold text-primary">Cadastro de cidade </h4>
        </div>
        <div class="card-body">
          <div class="item form-group">
            <label class="control-label col-md-6 col-sm-3 col-xs-12">Usuário
            </label>
            <div class="col-md-10 col-sm-6 col-xs-12">
              <input class="form-control col-md-10 col-xs-12" maxlength="100" name="nomeCidade" placeholder="Digite nome da cidade" required="required" type="text">
            </div>
            <br>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">

                <input type="submit" name="enviar" class="btn btn-success" value="Salvar">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


  </form>
<?php } ?>

<?php
include_once("Footer.php");

?>