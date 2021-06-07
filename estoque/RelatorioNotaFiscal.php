<?php
include_once("../dao/conexao.php");

include_once("Head.php");

// Filtro por datas
if(isset($_POST['dataInicio']))
{
  $dataInicio = $_POST['dataInicio'];
  $dataFinal = $_POST['dataFinal'];
  

  //Funcionario
  if($_SESSION['idLocal'] !=0){
    $result_FiscalPeriodoFun = "SELECT N.numeroNota, N.quantidade, N.dataEntrada, P.descricaoProduto 
    FROM notafiscal N INNER JOIN produto P ON N.idProduto = P.idProduto 
    where N.dataEntrada >= '$dataInicio' and N.dataEntrada <= '$dataFinal' and P.idLocal = '$_SESSION[idLocal]' ";
    $resultado_FiscalFun = mysqli_query($con,$result_FiscalPeriodoFun);
  }else{
    //Adm
    $idLocal = $_POST['idLocal'];
    if($idLocal == 'Todos')
    {
    $result_FiscalPeriodo = "SELECT N.numeroNota, N.quantidade, N.dataEntrada, P.descricaoProduto, L.nomeLocal 
    FROM notafiscal N INNER JOIN produto P ON N.idProduto = P.idProduto INNER JOIN local L ON L.idLocal = P.idLocal
    where N.dataEntrada >= '$dataInicio' and N.dataEntrada <= '$dataFinal'  ";
    $resultado_Fiscal = mysqli_query($con,$result_FiscalPeriodo);
    }else{
      $result_FiscalPeriodo = "SELECT N.numeroNota, N.quantidade, N.dataEntrada, P.descricaoProduto, L.nomeLocal 
    FROM notafiscal N INNER JOIN produto P ON N.idProduto = P.idProduto INNER JOIN local L ON L.idLocal = P.idLocal
    where N.dataEntrada >= '$dataInicio' and N.dataEntrada <= '$dataFinal' and P.idLocal = '$idLocal'  ";
    $resultado_Fiscal = mysqli_query($con,$result_FiscalPeriodo);
    }
  }

}


$result_consultaProdutoFuncionario="SELECT N.idNotaFiscal,
N.numeroNota, 
N.quantidade,
N.dataEntrada,
P.descricaoProduto,
L.nomeLocal, 
L.idLocal
FROM produto P, local L, notafiscal N  
WHERE L.idLocal = '$_SESSION[idLocal]' and P.idLocal = L.idLocal  and N.idProduto = P.idProduto ";
$resultado_consultaProdutoFuncionario = mysqli_query($con, $result_consultaProdutoFuncionario);

$result_consultaProduto="SELECT N.idNotaFiscal,
N.numeroNota, 
N.quantidade,
N.dataEntrada,
P.descricaoProduto,
L.nomeLocal, 
L.idLocal
FROM produto P, local L, notafiscal N  
WHERE P.idLocal = L.idLocal  and N.idProduto = P.idProduto ";
$resultado_consultaProduto = mysqli_query($con, $result_consultaProduto);
$result_local ="SELECT * FROM local";
$resultado_local= mysqli_query($con, $result_local);
?>

<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

        <!-- Begin Page Content -->
        <div class="container-fluid">

  <div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <center><h3 class="m-0 font-weight-bold text-primary">Relatório de Nota Fiscal</h3></center>
    <form action="" method="POST" onsubmit="return(verifica())" class="form-horizontal form-label-left">

<div class="item form-group">
<h5>Filtro por período </h5>
<label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Data início
</label>
<div class="col-md-10 col-sm-6 col-xs-12">
<input type="date" class="form-control col-md-3 col-xs-8" required="required" name="dataInicio"  >
<br>
</div>
<label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Data final
</label>
<div class="col-md-10 col-sm-6 col-xs-12">
<input type="date" class="form-control col-md-3 col-xs-8" required="required" name="dataFinal" >
<br>
</div>
<?php if($_SESSION['idLocal'] == 0 ){ ?>
<label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Local
</label>

<div class="col-md-10 col-sm-6 col-xs-12">
<select name="idLocal" id="" class="form-control col-md-3 col-xs-8">
<option value="Todos">Todos</option>
<?php while($rows_local = mysqli_fetch_assoc($resultado_local)){ ?>

<option value="<?php echo $rows_local['idLocal'];?>"><?php echo ($rows_local['nomeLocal']);?></option>

<?php } ?>	
</select>
<br>
</div>
<?php }?>
<div class="ln_solid"></div>
<div class="form-group">
<div class="col-md-6 col-md-offset-3">

<input type="submit" name="enviar" class="btn btn-success"  value="Consultar">
</div>
</div>
</form>
  </div>
  <?php if(!isset($_POST['dataInicio'])){ ?>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="lista-produto" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Número</th>
            <th>Quantidade Entrada</th>
            <th>Produto</th>
            <th>Data Entrada</th>
          </tr>
        </thead>
        
        <tbody>

        <?php 
        
        if ($_SESSION['idLocal']!=0) {
        while($rows_consultaProdutoFuncionario = mysqli_fetch_assoc($resultado_consultaProdutoFuncionario)){ 
        ?>

          <tr>
          <td><?php echo $rows_consultaProdutoFuncionario['numeroNota'];?></td>
          <td><?php echo $rows_consultaProdutoFuncionario['quantidade'];?></td>
          <td><?php echo $rows_consultaProdutoFuncionario['descricaoProduto'];?></td>
          <td><?php $dataBanco = $rows_consultaProdutoFuncionario['dataEntrada'];
                    $dataBr = date("d/m/Y", strtotime($dataBanco)); 
                    echo $dataBr;?></td>
            
          </tr>
          <?php } } 
          else {
            while($rows_consultaProduto = mysqli_fetch_assoc($resultado_consultaProduto)){ 
              ?>
      
      <tr>
          <td><?php echo $rows_consultaProduto['numeroNota'];?></td>
          <td><?php echo $rows_consultaProduto['quantidade'];?></td>
          <td><?php echo $rows_consultaProduto['descricaoProduto'];?></td>
          <td><?php $dataBanco = $rows_consultaProduto['dataEntrada'];
                    $dataBr = date("d/m/Y", strtotime($dataBanco)); 
                    echo $dataBr;?></td>
            
          </tr>
            <?php } } }  ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</div>

<?php if(isset($_POST['dataInicio'])){ ?>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="lista-produto" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Número</th>
            <th>Quantidade Entrada</th>
            <th>Produto</th>
            <th>Local</th>
            <th>Data Entrada</th>
          </tr>
        </thead>
        
        <tbody>

        <?php 
        
        if ($_SESSION['idLocal']!=0) {
        while($rows_consultaProdutoFuncionario = mysqli_fetch_assoc($resultado_FiscalFun)){ 
        ?>

          <tr>
          <td><?php echo $rows_consultaProdutoFuncionario['numeroNota'];?></td>
          <td><?php echo $rows_consultaProdutoFuncionario['quantidade'];?></td>
          <td><?php echo $rows_consultaProdutoFuncionario['descricaoProduto'];?></td>
          <td><?php $dataBanco = $rows_consultaProdutoFuncionario['dataEntrada'];
                    $dataBr = date("d/m/Y", strtotime($dataBanco)); 
                    echo $dataBr;?></td>
            
          </tr>
          <?php } } 
          else {
            while($rows_consultaProduto = mysqli_fetch_assoc($resultado_Fiscal)){ 
              ?>
      
      <tr>
          <td><?php echo $rows_consultaProduto['numeroNota'];?></td>
          <td><?php echo $rows_consultaProduto['quantidade'];?></td>
          <td><?php echo $rows_consultaProduto['descricaoProduto'];?></td>
          <td><?php echo $rows_consultaProduto['nomeLocal'];?></td>
          <td><?php $dataBanco = $rows_consultaProduto['dataEntrada'];
                    $dataBr = date("d/m/Y", strtotime($dataBanco)); 
                    echo $dataBr;?></td>
            
          </tr>
            <?php } } }  ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</div>

  <!-- End of Main Content -->
  </div>
      </div>        

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; NUPSI 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <!-- Bootstrap core JavaScript-->
    <!-- Subitens funcionar-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"></script>

<!-- Page level plugins -->
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>


<script type="text/javascript">
        $(document).ready(function() {
    $('#lista-produto').DataTable( {
        dom: 'Bfrtip',
        buttons: [
        'pdf',{
            extend: 'print',
            text: 'Imprimir',
            key: {
                key: 'p',
                altkey: true
            }
        }],"language": {
    "sEmptyTable": "Nenhum registro encontrado",
    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
    "sInfoPostFix": "",
    "sInfoThousands": ".",
    "sLengthMenu": "_MENU_ resultados por página",
    "sLoadingRecords": "Carregando...",
    "sProcessing": "Processando...",
    "sZeroRecords": "Nenhum registro encontrado",
    "sSearch": "Pesquisar",
    "oPaginate": {
        "sNext": "Próximo",
        "sPrevious": "Anterior",
        "sFirst": "Primeiro",
        "sLast": "Último"
    },
    "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"
    }
}
    } );
} );
</script>


</body>

</html>


