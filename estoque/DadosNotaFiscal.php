<?php
include_once("Head.php");

?>

<?php
include "../dao/conexao.php";

$idNotaFiscal=$_GET['idNotaFiscal'];

$result_consultaFiscal = "SELECT N.idNotaFiscal,N.quantidade,P.descricaoProduto, N.numeroNota, N.comprovanteFiscal, N.idFornecedor, N.valor, P.idProduto, L.nomeLocal FROM notafiscal N 
INNER JOIN produto P ON N.idProduto = P.idProduto INNER JOIN local L ON L.idLocal = P.idLocal
where N.status = 0 and idNotaFiscal = $idNotaFiscal ";
$res = $con-> query($result_consultaFiscal);
$linha = $res->fetch_assoc();




?>
  <div class="col-lg-6 mb-4">
          <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h4 class="m-0 font-weight-bold text-primary">Alterar Nota Fiscal de <?php echo $linha['descricaoProduto']; ?></h4>
                </div>
                <div class="card-body">
                 
                <form action="AlterarNotaFiscal.php" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
                <input type="hidden" readonly class="form-control col-md-7 col-xs-12" id="staticEmail" name="idNotaFiscal" value="<?php echo $linha['idNotaFiscal']; ?>">
                <div class="item form-group">
              <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Número nota
              </label>
              <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-7 col-xs-12" maxlength="100" name="numeroNota" required="required" type="text" value="<?php echo $linha['numeroNota']; ?>">
              </div>
              <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Quantidade Entrada
              </label>
              <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-7 col-xs-12" maxlength="100" name="quantidade" required="required" type="text" value="<?php echo $linha['quantidade']; ?>">
              </div>
              <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Fornecedor
              </label>
              <div class="col-md-10 col-sm-6 col-xs-12">
               <select name="idFornecedor" class="form-control col-md-7 col-xs-12" id="">
                <?php $select_forncedor = mysqli_query($con,"SELECT * FROM fornecedor"); ?>
                <option value="">Selecione</option>
                <?php while($rows_fornecedor = mysqli_fetch_assoc($select_forncedor)){ ?>
                  <option value="<?php echo $rows_fornecedor['idFornecedor']; ?>" <?php if($rows_fornecedor['idFornecedor'] == $linha['idFornecedor']) echo 'selected'; ?>><?php echo $rows_fornecedor['nomeFantasia']; ?></option>
                  <?php }?>
               </select>
              </div>
              <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Valor
              </label>
              <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-7 col-xs-12" maxlength="100" name="valor" required="required" onKeyPress="return(moeda(this,'','.',event))" type="text" value="<?php echo $linha['valor']; ?>">
              </div>
              <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Alterar comprovante
              </label>
              <div class="col-md-10 col-sm-6 col-xs-12">
                <input class="form-control col-md-7 col-xs-12" maxlength="100" name="comprovanteFiscal"  type="file" >
              </div>
             <br>
              <div class="col-md-10 col-sm-6 col-xs-12">
                <a  class="btn btn-primary"  href="../nota_fiscal/<?php echo $linha['comprovanteFiscal'] ?>" target="_blank" rel="noopener noreferrer">Visulizar comprovante</a>
              </div>
            </div>
    
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <input type="button" name="cancelar" class="btn btn-primary" onClick="window.location.href='EntradasPendentes.php'" value="Cancelar">
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