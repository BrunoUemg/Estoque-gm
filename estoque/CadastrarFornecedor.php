<?php
include_once("Head.php");
include_once("../dao/conexao.php");




?>

         
         <div class="col-lg-6 mb-4">
          <div class="card shadow mb-4">
                <div class="card-header py-3">
              <h4 class="m-0 font-weight-bold text-primary">Cadastro de Fornecedor</h4>
                </div>
                <div class="card-body">
                 
                <form action="EnvioCadastroFornecedor.php" method="POST" class="form-horizontal form-label-left">

                <div class="item form-group">
           <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Razão social
              </label>
               <div class="col-md-10 col-sm-6 col-xs-12">
             <input class="form-control col-md-10 col-xs-12" maxlength="50" name="razaoSocial" required="required" type="text">
  </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12">Nome fantasia 
              </label>
           <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-10 col-xs-12" maxlength="100" name="nomeFantasia" required="required" type="text">
  </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12">CNPJ/CPF
              </label>
           <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-10 col-xs-12" maxlength="100" onKeyPress="MascaraGenerica(this, 'CPFCNPJ');" name="doc" required="required" type="text">
  </div>
            </div>

            <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12">Telefone
              </label>
           <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-10 col-xs-12" maxlength="100" name="telefone"  type="text" onkeyup="mascara('(##) ####-####',this,event,true)">
  </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12">Celular
              </label>
           <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-10 col-xs-12" maxlength="100" name="celular" required="required" type="text" onkeyup="mascara('(##) #####-####',this,event,true)">
  </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12">E-mail
              </label>
           <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-10 col-xs-12" maxlength="100" name="email"  type="email">
  </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12">Observação
              </label>
           <div class="col-md-10 col-sm-6 col-xs-12">
               <textarea name="observacao" class="form-control col-md-10 col-xs-12" id="" cols="30" rows="5"></textarea>
  </div>
            </div>
          
       


       
               
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <input type="button" name="cancelar" class="btn btn-primary" onClick="window.location.href='MenuPrincipal.php'" value="Cancelar">
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