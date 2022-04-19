<?php
include_once("Head.php");

?>
<?php if($_SESSION['idLocal'] == null){ ?>
     <form action="EnvioCidade.php" method="post">
            <div class="col-lg-6 mb-4">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h4 class="m-0 font-weight-bold text-primary">Cadastro de cidade</h4>
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