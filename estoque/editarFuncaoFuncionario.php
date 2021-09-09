<?php
include_once("Head.php");
include_once("../dao/conexao.php");
$idUsuario = $_GET['idUsuario'];
$result_acesso ="SELECT * FROM nivel_acesso where idUsuario = $idUsuario";
$resultado_acesso = mysqli_query($con, $result_acesso);
$linha2 = mysqli_fetch_array($resultado_acesso);



?>
 <script>
function validaSenha (input){ 
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
                          if(!empty($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
				             } ?>
                <form action="alterarFuncaoFuncionario.php" method="POST" class="form-horizontal form-label-left">

             

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
                   
                      <input type="checkbox" name="cadFornecedor" <?php if($linha2['cadFornecedor'] == 1) echo 'checked' ?> value="1" id="">
                      <input type="text" name="idUsuario" hidden value="<?php echo $idUsuario ?>" id="">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="">Consultar fornecedor</label>
                    </td>
                    <td>
                      <input type="checkbox" name="consulFornecedor" <?php if($linha2['consulFornecedor'] == 1) echo 'checked' ?> value="1" id="">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="">Cadastrar produto</label>
                    </td>
                    <td>
                      <input type="checkbox" name="cadProduto"<?php if($linha2['cadProduto'] == 1) echo 'checked' ?> value="1" id="">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="">Consultar produto</label>
                    </td>
                    <td>
                      <input type="checkbox" name="consulProduto" <?php if($linha2['consulProduto'] == 1) echo 'checked' ?> value="1" id="">
                    </td>
                  </tr>
                 
                  <tr>
                    <td>
                      <label for="">Relatório fiscal</label>
                    </td>
                    <td>
                      <input type="checkbox" name="relaFiscal"<?php if($linha2['relaFiscal'] == 1) echo 'checked' ?> value="1" id="">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="">Relatório no limite</label>
                    </td>
                    <td>
                      <input type="checkbox" name="relaLimite" <?php if($linha2['relaLimite'] == 1) echo 'checked' ?> value="1" id="">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="">Relatório produtos em estoque</label>
                    </td>
                    <td>
                      <input type="checkbox" name="relaProEstoque" <?php if($linha2['relaProEstoque'] == 1) echo 'checked' ?> value="1" id="">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="">Relatório requisição</label>
                    </td>
                    <td>
                      <input type="checkbox" name="relaRequisicao" <?php if($linha2['relaRequisicao'] == 1) echo 'checked' ?> value="1" id="">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="">Comprovantes Fiscal</label>
                    </td>
                    <td>
                      <input type="checkbox" name="compFiscal" <?php if($linha2['compFiscal'] == 1) echo 'checked' ?> value="1" id="">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="">Comprovantes Requisição</label>
                    </td>
                    <td>
                      <input type="checkbox" name="compRequi" <?php if($linha2['compRequi'] == 1) echo 'checked' ?> value="1" id="">
                    </td>
                  </tr>
                  <tbody>
            
                
                  </tbody>
                </table>
              </div>
               
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <input type="button" name="cancelar" class="btn btn-primary" onClick="window.location.href='ConsultarFuncionario.php'" value="Cancelar">
                <input type="submit" name="enviar" class="btn btn-success"  value="Alterar">
              </div>
            </div>
</form>




                </div>
              </div>
</div> 


    




<?php
include_once("Footer.php");

?>