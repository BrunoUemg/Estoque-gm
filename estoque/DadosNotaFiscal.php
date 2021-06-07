<?php
include_once("Head.php");

?>

<?php
include "../dao/conexao.php";

$idNotaFiscal=$_GET['idNotaFiscal'];

$result_consultaFiscal = "SELECT N.idNotaFiscal,N.quantidade,P.descricaoProduto, N.numeroNota, N.comprovanteFiscal, P.idProduto, L.nomeLocal FROM notaFiscal N 
INNER JOIN produto P ON N.idProduto = P.idProduto INNER JOIN local L ON L.idLocal = P.idLocal 
where N.status = 0 and idNotaFiscal = $idNotaFiscal ";
$res = $con-> query($result_consultaFiscal);
$linha = $res->fetch_assoc();




?>
  <div class="col-lg-6 mb-4">
          <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h4 class="m-0 font-weight-bold text-primary">Alterar Nota Fiscal de <?php echo $linha['descricaoProduto']; ?></h4>
                </div>
                <div class="card-body">
                 
                <form action="AlterarNotaFiscal.php" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
                <input type="hidden" readonly class="form-control col-md-7 col-xs-12" id="staticEmail" name="idNotaFiscal" value="<?php echo $linha['idNotaFiscal']; ?>">
                <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Número nota
              </label>
              <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-7 col-xs-12" maxlength="100" name="numeroNota" required="required" type="text" value="<?php echo $linha['numeroNota']; ?>">
              </div>
              <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Quantidade Entrada
              </label>
              <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-7 col-xs-12" maxlength="100" name="quantidade" required="required" type="text" value="<?php echo $linha['quantidade']; ?>">
              </div>
              <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Alterar comprovante
              </label>
              <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-7 col-xs-12" maxlength="100" name="comprovanteFiscal"  type="file" >
              </div>
             <br>
              <div class="col-md-10 col-sm-6 col-xs-12">
                <a  class="btn btn-primary"  href="../nota_fiscal/<?php echo $linha['comprovanteFiscal'] ?>" target="_blank" rel="noopener noreferrer">Visulizar comprovante</a>
              </div>
            </div>
    
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <input type="button" name="cancelar" class="btn btn-primary" onClick="window.location.href='EntradasPendentes.php'" value="Cancelar">
                <input type="submit" name="enviar" class="btn btn-success"  value="Salvar">
              </div>
            </div>
</form>




                </div>
              </div>
</div> 


<?php
include_once("Footer.php");

?>