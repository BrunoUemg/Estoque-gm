<?php
include_once("Head.php");
include_once("../dao/conexao.php");


$idProduto=$_GET['idProduto'];
$sql = "SELECT * FROM produto WHERE idProduto = '$idProduto' " ;


$res = $con-> query($sql);
$linha = $res->fetch_assoc();

?>
         <div class="col-lg-6 mb-4">
          <div class="card shadow mb-4">
                <div class="card-header py-3">
              <h4 class="m-0 font-weight-bold text-primary">Adicionar Produto</h4>
                </div>
                <div class="card-body">
                 
                <form action="EnvioEntradaProduto.php" method="POST" class="form-horizontal form-label-left">

                <input type="hidden" readonly class="form-control col-md-7 col-xs-12" name="idProduto" value="<?php echo $linha['idProduto']; ?>">

                <div class="item form-group">
           <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Descrição do Produto
              </label>
               <div class="col-md-10 col-sm-6 col-xs-12">
             <input class="form-control col-md-10 col-xs-12" disabled maxlength="100" name="descricaoProduto" required="required" value="<?php echo $linha['descricaoProduto']; ?>" type="text">
  </div>
            </div>

            <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12">Número Nota Fiscal
              </label>
           <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-10 col-xs-12"  maxlength="100" name="numeroNota" required="required" type="text">
  </div>
            </div>

            <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12">Quantidade Entrada
              </label>
           <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-10 col-xs-12" maxlength="100" name="quantidadeEntrada" required="required" type="number">
  </div>
            </div>

               
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <input type="button" name="cancelar" class="btn btn-primary" onClick="window.location.href='ConsultarProduto.php'" value="Cancelar">
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