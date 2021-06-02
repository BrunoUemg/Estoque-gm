<?php
include_once("Head.php");
include_once("../dao/conexao.php");
$result_local ="SELECT * FROM local";
$resultado_local= mysqli_query($con, $result_local);
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
         


            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="acesso">Local
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" id=idLocal name="idLocal" required="required">
        
  <option>Selecione o Local</option>
              
  <?php while($rows_local = mysqli_fetch_assoc($resultado_local)){ ?>

<option value="<?php echo $rows_local['idLocal'];?>"><?php echo ($rows_local['nomeLocal']);?></option>

<?php } ?>	

</select>
                  </div>
            </div>


               
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <input type="button" name="cancelar" class="btn btn-primary" onClick="window.location.href='CadastrarProduto.php'" value="Cancelar">
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