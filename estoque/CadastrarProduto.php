<?php
include_once("Head.php");
include_once("../dao/conexao.php");

$result_local = "SELECT * FROM local";
$resultado_local = mysqli_query($con, $result_local);

$sql = "SELECT * FROM local WHERE idLocal = '$_SESSION[idLocal]' ";

$res = $con->query($sql);
$linha = $res->fetch_assoc();
?>


<div class="col-lg-6 mb-4">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold text-primary">Cadastro de Produto</h4>
    </div>
    <div class="card-body">

      <form action="EnvioCadastroProduto.php" method="POST" class="form-horizontal form-label-left">

        <div class="item form-group">
          <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Descrição do Produto
          </label>
          <div class="col-md-10 col-sm-6 col-xs-12">
            <input class="form-control col-md-10 col-xs-12" maxlength="50" name="descricaoProduto" required="required" type="text">
          </div>
        </div>
        <div class="item form-group">

          </label>
          <div class="col-md-10 col-sm-6 col-xs-12">
            <input class="form-control col-md-10 col-xs-12" maxlength="100" hidden name="quantidadeProduto" value="0" type="number">
          </div>
        </div>

        <div class="item form-group">
          <label class="control-label col-md-6 col-sm-3 col-xs-12">Quantidade Minima
          </label>
          <div class="col-md-10 col-sm-6 col-xs-12">
            <input class="form-control col-md-10 col-xs-12" maxlength="100" name="quantidadeMin" required="required" type="number">
          </div>
        </div>
        <div class="item form-group">
          <label class="control-label col-md-6 col-sm-3 col-xs-12">Quantidade Minima
          </label>
          <div class="col-md-10 col-sm-6 col-xs-12">
           
            <select name="tipoEstoque" required class="form-control col-md-10 col-xs-12">
              <option value="">Selecione</option>
              <option value="0">Possui quantidade minima</option>
              <option value="1">Não possui quantidade minima</option>
              
              
            </select>
          </div>
        </div>



        <div class="item form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="local">Local
          </label>
          <div class="col-md-8 col-sm-6 col-xs-12">
            <select class="form-control" id=selectTipoPerfil name="local" required="required">

              <option>Selecione o local</option>
              <?php while ($rows_local = mysqli_fetch_assoc($resultado_local)) {
                $select_localusu = mysqli_query($con, "SELECT * FROM local_usuario where idUsuario = '$_SESSION[idUsuario]' and idLocal = '$rows_local[idLocal]'");

                if (mysqli_num_rows($select_localusu) > 0 || $_SESSION['idLocal'] == null) {
              ?>

                  <option value="<?php echo $rows_local['idLocal']; ?>"><?php echo ($rows_local['nomeLocal']); ?></option>

              <?php }
              } ?>

            </select>
          </div>
        </div>








        <div class="ln_solid"></div>
        <div class="form-group">
          <div class="col-md-6 col-md-offset-3">
            <input type="button" name="cancelar" class="btn btn-primary" onClick="window.location.href='MenuPrincipal.php'" value="Cancelar">
            <input type="submit" name="enviar" class="btn btn-success" value="Salvar">
          </div>
        </div>
      </form>




    </div>
  </div>
</div>







<?php
include_once("Footer.php");

?>