<?php
include_once("Head.php");
include_once("../dao/conexao.php");


$idProduto=$_GET['idProduto'];
$sql = "SELECT * FROM produto WHERE idProduto = '$idProduto' " ;


$res = $con-> query($sql);
$linha = $res->fetch_assoc();

$result_local ="SELECT * FROM local";
$resultado_local= mysqli_query($con, $result_local);
?>

         
         <div class="col-lg-6 mb-4">
          <div class="card shadow mb-4">
                <div class="card-header py-3">
              <h4 class="m-0 font-weight-bold text-primary">Alterar Produto</h4>
                </div>
                <div class="card-body">
                 
                <form action="AlterarProduto.php" method="POST" class="form-horizontal form-label-left">

                <input type="hidden" readonly class="form-control col-md-7 col-xs-12" name="idProduto" value="<?php echo $linha['idProduto']; ?>">

                <div class="item form-group">
           <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Descrição do Produto
              </label>
               <div class="col-md-10 col-sm-6 col-xs-12">
             <input class="form-control col-md-10 col-xs-12" maxlength="50" name="descricaoProduto" required="required" value="<?php echo $linha['descricaoProduto']; ?>" type="text">
  </div>
            </div>

            <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12">Quantidade Mínima
              </label>
           <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-10 col-xs-12"  maxlength="11" name="quantidadeMin" required="required" value="<?php echo $linha['quantidadeMin']; ?>" type="number">
  </div>
            </div>

            <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12">Quantidade
              </label>
           <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-10 col-xs-12"  disabled maxlength="11" name="quantidade" required="required" value="<?php echo $linha['quantidadeProduto']; ?>" type="number">
  </div>
            </div>


            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="local">Local
              </label>
               <div class="col-md-8 col-sm-6 col-xs-12">
                <select class="form-control" id=selectTipoPerfil disabled name="local">
        
                <option>Selecione o local</option>
  <?php while($rows_local = mysqli_fetch_assoc($resultado_local)){ ?>

<option value="<?php echo $rows_local['idLocal'];?>"
<?php if ($linha['idLocal']==$rows_local['idLocal']){ echo "selected";}?>><?php echo ($rows_local['nomeLocal']);?></option>

<?php } ?>	

</select>
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