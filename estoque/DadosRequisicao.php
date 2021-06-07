<?php
include_once("Head.php");

?>

<?php
include "../dao/conexao.php";

$idRequisicao=$_GET['idRequisicao'];

$result_consultaRequisicao = "SELECT * FROM requisicao where idRequisicao = '$idRequisicao' ";
$res = $con-> query($result_consultaRequisicao);
$linha = $res->fetch_assoc();




?>
  <div class="col-lg-6 mb-4">
          <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h4 class="m-0 font-weight-bold text-primary">Alterar Requisição</h4>
                </div>
                <div class="card-body">
                 
                <form action="AlterarRequisicao.php" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
                <input type="hidden" readonly class="form-control col-md-7 col-xs-12" id="staticEmail" name="idRequisicao" value="<?php echo $linha['idRequisicao']; ?>">
                <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Justificativa
              </label>
              <div class="col-md-10 col-sm-6 col-xs-12">
                <textarea  id="" cols="20" class="form-control" name="justificativa" rows="5"><?php echo $linha['justificativa']; ?></textarea>
              </div>
              <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Solicitante
              </label>
              <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-7 col-xs-12" maxlength="100" name="solicitante" required="required" type="text" value="<?php echo $linha['solicitante']; ?>">
              </div>
              <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Alterar comprovante
              </label>
              <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-7 col-xs-12" maxlength="100" name="comprovanteRequisicao"  type="file" >
              </div>
             <br>
              <div class="col-md-10 col-sm-6 col-xs-12">
                <a  class="btn btn-primary"  href="../requisicao/<?php echo $linha['comprovanteRequisicao'] ?>" target="_blank" rel="noopener noreferrer">Visulizar comprovante</a>
              </div>
            </div>
    
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <input type="button" name="cancelar" class="btn btn-primary" onClick="window.location.href='SaidasPendentes.php'" value="Cancelar">
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