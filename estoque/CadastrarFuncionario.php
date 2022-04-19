<?php
include_once("Head.php");
include_once("../dao/conexao.php");
$result_local = "SELECT * FROM local";
$resultado_local = mysqli_query($con, $result_local);
?>
<script>
  function validaSenha(input) {
    if (input.value != document.getElementById('senha').value) {
      input.setCustomValidity('Repita a senha corretamente');
    } else {
      input.setCustomValidity('');
    }
  }
</script>

<div class="col-lg-6 mb-4">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold text-primary">Cadastro de Funcionario</h4>
    </div>
    <div class="card-body">
      <?php
      if (!empty($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
      } ?>
      <form action="EnvioFuncionario.php" method="POST" class="form-horizontal form-label-left">

        <div class="item form-group">
          <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Nome
          </label>
          <div class="col-md-10 col-sm-6 col-xs-12">
            <input class="form-control col-md-10 col-xs-12" maxlength="100" name="nomeUsuario" required="required" type="text">
          </div>
        </div>
        <div class="item form-group">
          <label class="control-label col-md-6 col-sm-3 col-xs-12">Usuário
          </label>
          <div class="col-md-10 col-sm-6 col-xs-12">
            <input class="form-control col-md-10 col-xs-12" maxlength="255" name="user" required="required" type="text">
          </div>
        </div>

        <div class="item form-group">
          <label class="control-label col-md-6 col-sm-3 col-xs-12">Senha
          </label>
          <div class="col-md-10 col-sm-6 col-xs-12">
            <input class="form-control col-md-10 col-xs-12" maxlength="100" name="senha" required="required" type="password">
          </div>
        </div>



        

        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Função</th>
                <th>Selecionar</th>


              </tr>
            </thead>
            <tr>
              <td>
                <label for="">Cadastrar fornecedor</label>
              </td>
              <td>

                <input type="checkbox" name="cadFornecedor" value="1" id="">
              </td>
            </tr>
            <tr>
              <td>
                <label for="">Consultar fornecedor</label>
              </td>
              <td>
                <input type="checkbox" name="consulFornecedor" value="1" id="">
              </td>
            </tr>
            <tr>
              <td>
                <label for="">Cadastrar produto</label>
              </td>
              <td>
                <input type="checkbox" name="cadProduto" value="1" id="">
              </td>
            </tr>
            <tr>
              <td>
                <label for="">Consultar produto</label>
              </td>
              <td>
                <input type="checkbox" name="consulProduto" value="1" id="">
              </td>
            </tr>

            <tr>
              <td>
                <label for="">Relatório fiscal</label>
              </td>
              <td>
                <input type="checkbox" name="relaFiscal" value="1" id="">
              </td>
            </tr>
            <tr>
              <td>
                <label for="">Relatório no limite</label>
              </td>
              <td>
                <input type="checkbox" name="relaLimite" value="1" id="">
              </td>
            </tr>
            <tr>
              <td>
                <label for="">Relatório produtos em estoque</label>
              </td>
              <td>
                <input type="checkbox" name="relaProEstoque" value="1" id="">
              </td>
            </tr>
            <tr>
              <td>
                <label for="">Relatório requisição</label>
              </td>
              <td>
                <input type="checkbox" name="relaRequisicao" value="1" id="">
              </td>
            </tr>
            <tr>
              <td>
                <label for="">Comprovantes Fiscal</label>
              </td>
              <td>
                <input type="checkbox" name="compFiscal" value="1" id="">
              </td>
            </tr>
            <tr>
              <td>
                <label for="">Comprovantes Requisição</label>
              </td>
              <td>
                <input type="checkbox" name="compRequi" value="1" id="">
              </td>
            </tr>
            <tr>
              <td>
                <label for="">Relatório transferência</label>
              </td>
              <td>
                <input type="checkbox" name="relatorioTransferencia" value="1" id="">
              </td>
            </tr>
            <tr>
              <td>
                <label for="">Receber transferência</label>
              </td>
              <td>
                <input type="checkbox" name="receberTransferencia" value="1" id="">
              </td>
            </tr>
            <tbody>


            </tbody>
          </table>
        </div>
        <div class="table-responsive">
          <?php $select_local = mysqli_query($con, "SELECT * FROM local order by nomeLocal asc") ?>
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Local</th>
                <th>Selecionar</th>

              </tr>
            </thead>
            <tr>
              <?php while ($rows_local = mysqli_fetch_assoc($select_local)) { ?>
                <td>
                  <?php echo $rows_local['nomeLocal']; ?>
                </td>
                <td>
                  <input type="checkbox" name="idLocal[]" value="<?php echo $rows_local['idLocal'] ?>" >
                </td>
            </tr>
          <?php } ?>

          <tbody>


          </tbody>
          </table>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
          <div class="col-md-6 col-md-offset-3">
            <input type="button" name="cancelar" class="btn btn-primary" onClick="window.location.href='CadastrarProduto.php'" value="Cancelar">
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