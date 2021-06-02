<?php


include_once("Head.php");



if(isset($_POST['dataInicio'])){
  $dataInicio =  $_POST['dataInicio'];
  $dataFinal = $_POST['dataFinal'];
 
if($_SESSION['idLocal'] != 0 ){
$result_listaRequisicaoPeriodoFun = "SELECT L.idProduto,L.quantidade,R.codigo,L.idLocal, N.nomeLocal, P.descricaoProduto,R.data from listarequisicao L, requisicao R, produto P, local N 
  WHERE R.idRequisicao = L.idRequisicao and L.idLocal = N.idLocal and R.data >= '$dataInicio' 
  and R.data <= '$dataFinal' and P.idProduto = L.idProduto and N.idLocal = '$_SESSION[idLocal]'";
$resultado_listaRequisicaoPeriodoFun = mysqli_query($con, $result_listaRequisicaoPeriodoFun);
}else{
  $dataInicio =  $_POST['dataInicio'];
  $dataFinal = $_POST['dataFinal'];
 $result_listaRequisicaoPeriodo = "SELECT L.idProduto,L.quantidade,L.idLocal, N.nomeLocal, P.descricaoProduto,R.codigo,R.data from listarequisicao L, requisicao R, produto P, local N 
  WHERE R.idRequisicao = L.idRequisicao and L.idLocal = N.idLocal and R.data >= '$dataInicio' 
  and R.data <= '$dataFinal' and P.idProduto = L.idProduto";
$resultado_listaRequisicaoPeriodo = mysqli_query($con, $result_listaRequisicaoPeriodo);

}

}

$result_listaRequisicaoFuncionario="SELECT R.codigo,
A.quantidade,
P.descricaoProduto,
L.nomeLocal
FROM requisicao R, local L, produto P, listarequisicao A  
WHERE L.idLocal = '$_SESSION[idLocal]' and A.idLocal = L.idLocal and R.idRequisicao = A.idRequisicao and P.idProduto = A.idProduto";
$resultado_listaRequisicaoFuncionario= mysqli_query($con, $result_listaRequisicaoFuncionario);

$result_listaRequisicao="SELECT R.codigo,
A.quantidade,
P.descricaoProduto,
L.nomeLocal
FROM requisicao R, local L, produto P, listarequisicao A  
WHERE A.idLocal = L.idLocal and R.idRequisicao = A.idRequisicao and P.idProduto = A.idProduto";
$resultado_listaRequisicao = mysqli_query($con, $result_listaRequisicao);
$data = date("Y");
?>



        <!-- Begin Page Content -->
        <?php if(!isset($_POST['dataInicio'])){ ?>
          <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
        <div class="container-fluid">

  <div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <center><h3 class="m-0 font-weight-bold text-primary">Relatório de Lista Requisição</h3></center>
        
    <form action="RelatorioListaRequisicao.php" method="POST" onsubmit="return(verifica())" class="form-horizontal form-label-left">

<div class="item form-group">
<h5>Filtro por período </h5>
<label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Data início
</label>
<div class="col-md-10 col-sm-6 col-xs-12">
<input type="date" class="form-control col-md-3 col-xs-8" name="dataInicio"  >
<br>
</div>
<label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Data final
</label>
<div class="col-md-10 col-sm-6 col-xs-12">
<input type="date" class="form-control col-md-3 col-xs-8" name="dataFinal" >
<br>
</div>

<div class="ln_solid"></div>
<div class="form-group">
<div class="col-md-6 col-md-offset-3">

<input type="submit" name="enviar" class="btn btn-success"  value="Consultar">
</div>
</div>
</form>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="lista-produto" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Local</th>
            <th>Nº Requisição</th>
          </tr>
        </thead>
        
        <tbody>

        <?php 
        
        if ($_SESSION['idLocal']!=0) {
        while($rows_listaRequisicaoFuncionario = mysqli_fetch_assoc($resultado_listaRequisicaoFuncionario)){ 
        ?>

          <tr>
          <td><?php echo $rows_listaRequisicaoFuncionario['descricaoProduto'];?></td>
          <td><?php echo $rows_listaRequisicaoFuncionario['quantidade'];?></td>
          <td><?php echo $rows_listaRequisicaoFuncionario['nomeLocal'];?></td>
          <td><?php echo $rows_listaRequisicaoFuncionario['codigo'];?></td>

      
            
          </tr>
          <?php } } 
          else {
            while($rows_listaRequisicao = mysqli_fetch_assoc($resultado_listaRequisicao)){ 
              ?>
      
      <tr>
          <td><?php echo $rows_listaRequisicao['descricaoProduto'];?></td>
          <td><?php echo $rows_listaRequisicao['quantidade'];?></td>
          <td><?php echo $rows_listaRequisicao['nomeLocal'];?></td>
          <td><?php echo $rows_listaRequisicao['codigo'];?></td>

            
          </tr>
            <?php } }  ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</div>
<?php } ?>
<?php 
if(isset($_POST['dataInicio'])){ 
  
  
  ?>
      <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
   <div class="container-fluid">

  <div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <center><h3 class="m-0 font-weight-bold text-primary">Relatório de Lista Requisição</h3></center>
        
    <form action="RelatorioListaRequisicao.php" method="POST" onsubmit="return(verifica())" class="form-horizontal form-label-left">

<div class="item form-group">
<h5>Filtro por período </h5>
<label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Data início
</label>
<div class="col-md-10 col-sm-6 col-xs-12">
<input type="date" class="form-control col-md-3 col-xs-8" name="dataInicio" maxlength="4" value="<?php echo $dataInicio; ?>" >
<br>
</div>
<label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Data final
</label>
<div class="col-md-10 col-sm-6 col-xs-12">
<input type="date" class="form-control col-md-3 col-xs-8" name="dataFinal" maxlength="4" value="<?php echo $dataFinal; ?>" >
<br>
</div>

<div class="ln_solid"></div>
<div class="form-group">
<div class="col-md-6 col-md-offset-3">

<input type="submit" name="enviar" class="btn btn-success"  value="Consultar">
</div>
</div>
</form>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="lista-produto" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Local</th>
            <th>Nº Requisição</th>
            <th>Data</th>
          </tr>
        </thead>
        
        <tbody>

        <?php 
        
        if ($_SESSION['idLocal']!=0) {
        while($rows_listaRequisicaoFuncionario = mysqli_fetch_assoc($resultado_listaRequisicaoPeriodoFun)){ 
        ?>

          <tr>
          <td><?php echo $rows_listaRequisicaoFuncionario['descricaoProduto'];?></td>
          <td><?php echo $rows_listaRequisicaoFuncionario['quantidade'];?></td>
          <td><?php echo $rows_listaRequisicaoFuncionario['nomeLocal'];?></td>
          <td><?php echo $rows_listaRequisicaoFuncionario['codigo'];?></td>
          <td><?php echo $rows_listaRequisicaoFuncionario['data'];?></td>

      
            
          </tr>
          <?php } } 
          else {
            while($rows_listaRequisicao = mysqli_fetch_assoc($resultado_listaRequisicaoPeriodo)){ 
              ?>
      
      <tr>
          <td><?php echo $rows_listaRequisicao['descricaoProduto'];?></td>
          <td><?php echo $rows_listaRequisicao['quantidade'];?></td>
          <td><?php echo $rows_listaRequisicao['nomeLocal'];?></td>
          <td><?php echo $rows_listaRequisicao['codigo'];?></td>
          <td><?php 
          $dataBanco = $rows_listaRequisicao['data'];
          $data = date("d/m/Y", strtotime($dataBanco));
          echo $data;?></td>

            
          </tr>
            <?php } }    ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</div>
<?php } ?>
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


