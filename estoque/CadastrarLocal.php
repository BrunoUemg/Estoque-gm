<?php
include_once("Head.php");

include_once "../dao/conexao.php";

$select_cidade = mysqli_query($con, "SELECT * FROM cidade order by nomeCidade asc");

?>


<div class="col-lg-6 mb-4">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold text-primary">Cadastro de Local</h4>
    </div>
    <div class="card-body">

      <form action="EnvioCadastroLocal.php" method="POST" onsubmit="return(verifica())" class="form-horizontal form-label-left">

        <div class="item form-group">
          <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Nome do local
          </label>
          <div class="col-md-10 col-sm-6 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" maxlength="100" name="nomeLocal" required="required" type="text">
          </div>
          <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Cidade
          </label>
          <div class="col-md-10 col-sm-6 col-xs-12">
            <select name="idCidade" required class="form-control col-md-7 col-xs-12" id="">
              <option value="">Selecione</option>
              <?php while($rows_cidade = mysqli_fetch_assoc($select_cidade)){ ?>
                <option value="<?php echo $rows_cidade['idCidade'] ?>"><?php echo $rows_cidade['nomeCidade'] ?></option>
                <?php } ?>
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