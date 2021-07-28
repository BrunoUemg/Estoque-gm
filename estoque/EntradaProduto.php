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
                 
                <form action="EnvioEntradaProduto.php" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">

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
            <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12">Fornecedor
              </label>
           <div class="col-md-10 col-sm-6 col-xs-12">
                <select name="idFornecedor" required class="form-control col-md-10 col-xs-12" id="">
                  <?php $select_fornecedor = mysqli_query($con, "SELECT * FROM fornecedor"); ?>
                  <option value="">Selecione</option>
                 <?php while($rows_fornecedor = mysqli_fetch_assoc($select_fornecedor)){ ?>
                  <option value="<?php echo $rows_fornecedor['idFornecedor']; ?>"><?php echo $rows_fornecedor['nomeFantasia'] ?></option>
                  <?php } ?>
                </select>
  </div>
            </div> 
            <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12">Valor da Entrada
              </label>
           <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-10 col-xs-12" maxlength="100" name="valor" required="required" onKeyPress="return(moeda(this,'','.',event))" type="text">
  </div>
            </div>

            <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12">Comprovante em pdf
              </label>
           <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-10 col-xs-12" maxlength="100" name="comprovanteFiscal" required="required" type="file">
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

<script>
   function moeda(a, e, r, t) {
        let n = ""
          , h = j = 0
          , u = tamanho2 = 0
          , l = ajd2 = ""
          , o = window.Event ? t.which : t.keyCode;
        if (13 == o || 8 == o)
            return !0;
        if (n = String.fromCharCode(o),
        -1 == "0123456789".indexOf(n))
            return !1;
        for (u = a.value.length,
        h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
            ;
        for (l = ""; h < u; h++)
            -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
        if (l += n,
        0 == (u = l.length) && (a.value = ""),
        1 == u && (a.value = "0" + r + "0" + l),
        2 == u && (a.value = "0" + r + l),
        u > 2) {
            for (ajd2 = "",
            j = 0,
            h = u - 3; h >= 0; h--)
                3 == j && (ajd2 += e,
                j = 0),
                ajd2 += l.charAt(h),
                j++;
            for (a.value = "",
            tamanho2 = ajd2.length,
            h = tamanho2 - 1; h >= 0; h--)
                a.value += ajd2.charAt(h);
            a.value += r + l.substr(u - 2, u)
        }
        return !1
    }
 
</script>

<?php
include_once("Footer.php");

?>