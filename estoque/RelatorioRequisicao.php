<?php
include_once("../dao/conexao.php");

include_once("Head.php");

if(isset($_POST['dataInicio'])){

  if($_SESSION['idLocal'] != 0 ){
    $dataInicio = $_POST['dataInicio'];
    $dataFinal = $_POST['dataFinal'];
    $result_RequisicaoPeriodoFun = "SELECT L.idProduto,L.quantidade,R.codigo,L.idLocal, N.nomeLocal, P.descricaoProduto,R.data,R.solicitante,R.justificativa,U.nomeUsuario from listarequisicao L, requisicao R, produto P, local N, usuario U 
  WHERE R.idRequisicao = L.idRequisicao and L.idLocal = N.idLocal and R.data >= '$dataInicio' 
  and R.data <= '$dataFinal' and P.idProduto = L.idProduto and N.idLocal = '$_SESSION[idLocal]' and U.idUsuario = R.idUsuario";
$resultado_RequisicaoPeriodoFun = mysqli_query($con, $result_RequisicaoPeriodoFun);
}else{

  if($_POST['local'] == 'Todos'){
  $dataInicio =  $_POST['dataInicio'];
  $dataFinal = $_POST['dataFinal'];
 
 $result_RequisicaoPeriodo = "SELECT L.idProduto,L.quantidade,L.idLocal, N.nomeLocal, P.descricaoProduto,R.codigo,R.data,R.solicitante,R.justificativa,U.nomeUsuario from listarequisicao L, requisicao R, produto P, local N,usuario U 
  WHERE R.idRequisicao = L.idRequisicao and L.idLocal = N.idLocal and R.data >= '$dataInicio' 
  and R.data <= '$dataFinal' and P.idProduto = L.idProduto and U.idUsuario = R.idUsuario";
$resultado_RequisicaoPeriodo = mysqli_query($con, $result_RequisicaoPeriodo);
  }else{
    $dataInicio =  $_POST['dataInicio'];
    $dataFinal = $_POST['dataFinal'];
    $local = $_POST['local'];
    
    $result_RequisicaoPeriodo = "SELECT L.idProduto,L.quantidade,R.codigo,L.idLocal, N.nomeLocal, P.descricaoProduto,R.data,R.solicitante,R.justificativa,U.nomeUsuario from listarequisicao L, requisicao R, produto P, local N, usuario U 
    WHERE R.idRequisicao = L.idRequisicao and L.idLocal = N.idLocal and R.data >= '$dataInicio' 
    and R.data <= '$dataFinal' and P.idProduto = L.idProduto and N.idLocal = $local and U.idUsuario = R.idUsuario";
  $resultado_RequisicaoPeriodo = mysqli_query($con, $result_RequisicaoPeriodo);
  }

    }
}

$result_consultaRequisicaoFuncionario="SELECT 
R.idRequisicao,
R.justificativa,
R.solicitante,
R.data,
R.codigo,
R.idUsuario,
U.nomeUsuario,
L.idLocal,
L.idRequisicao
FROM listarequisicao L,
requisicao R, usuario U
WHERE L.idRequisicao = R.idRequisicao AND U.idLocal = $_SESSION[idLocal] AND R.idUsuario = U.idUsuario GROUP BY R.codigo";
$resultado_consultaRequisicaoFuncionario= mysqli_query($con, $result_consultaRequisicaoFuncionario);

$result_consultaRequisicao="SELECT R.justificativa,
R.solicitante,
R.data,
R.codigo,
U.nomeUsuario
FROM requisicao R, usuario U 
WHERE R.idUsuario = U.idUsuario";
$resultado_consultaRequisicao = mysqli_query($con, $result_consultaRequisicao);
$result_local ="SELECT * FROM local";
$resultado_local= mysqli_query($con, $result_local);
?>

<?php if(!isset($_POST['dataInicio'])) { ?>
<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

        <!-- Begin Page Content -->
        <div class="container-fluid">

  <div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <center><h3 class="m-0 font-weight-bold text-primary">Relatório de Requisição</h3></center>
        
    <form action="RelatorioRequisicao.php" method="POST" onsubmit="return(verifica())" class="form-horizontal form-label-left">

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
<select name="local" id="" class="form-control col-md-3 col-xs-8">
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
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="lista-produto" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Código</th>
            <th>Justificativa</th>
            <th>Solicitante</th>
            <th>Retirante</th>
            <th>Data</th>

          </tr>
        </thead>
        
        <tbody>

        <?php 
        
        if ($_SESSION['idLocal']!=0) {
        while($rows_consultaRequisicaoFuncionario = mysqli_fetch_assoc($resultado_consultaRequisicaoFuncionario)){ 
        ?>

          <tr>
          <td><?php echo $rows_consultaRequisicaoFuncionario['codigo'];?></td>
          <td><?php echo $rows_consultaRequisicaoFuncionario['justificativa'];?></td>
          <td><?php echo $rows_consultaRequisicaoFuncionario['solicitante'];?></td>
          <td><?php echo $rows_consultaRequisicaoFuncionario['nomeUsuario'];?></td>
          <td><?php echo $rows_consultaRequisicaoFuncionario['data'];?></td>

      
            
          </tr>
          <?php } } 
          else {
            while($rows_consultaRequisicao = mysqli_fetch_assoc($resultado_consultaRequisicao)){ 
              ?>
      
      <tr>
          <td><?php echo $rows_consultaRequisicao['codigo'];?></td>
          <td><?php echo $rows_consultaRequisicao['justificativa'];?></td>
          <td><?php echo $rows_consultaRequisicao['solicitante'];?></td>
          <td><?php echo $rows_consultaRequisicao['nomeUsuario'];?></td>
          <td><?php echo $rows_consultaRequisicao['data'];?></td>
            
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
    <center><h3 class="m-0 font-weight-bold text-primary">Relatório de Requisição</h3></center>
        
    <form action="RelatorioRequisicao.php" method="POST" onsubmit="return(verifica())" class="form-horizontal form-label-left">

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
<?php if($_SESSION['idLocal'] == 0 ){ ?>
<label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Local
</label>

<div class="col-md-10 col-sm-6 col-xs-12">
<select name="local" id="" class="form-control col-md-3 col-xs-8">
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
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="lista-produto" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Codigo</th>
            <th>Justificativa</th>
            <th>Solicitante</th>
            <th>Retirante</th>
            <th>Local</th>
            <th>Data</th>
          </tr>
        </thead>
        
        <tbody>

        <?php 
        
        if ($_SESSION['idLocal']!=0) {
        while($rows_RequisicaoFuncionario = mysqli_fetch_assoc($resultado_RequisicaoPeriodoFun)){ 
        ?>

          <tr>
          <td><?php echo $rows_RequisicaoFuncionario['codigo'];?></td>
          <td><?php echo $rows_RequisicaoFuncionario['justificativa'];?></td>
          <td><?php echo $rows_RequisicaoFuncionario['solicitante'];?></td>
          <td><?php echo $rows_RequisicaoFuncionario['nomeUsuario'];?></td>
          <td><?php echo $rows_RequisicaoFuncionario['nomeLocal'];?></td>
          <td><?php 
          $dataBanco = $rows_RequisicaoFuncionario['data'];
          $data = date("d/m/Y", strtotime($dataBanco));
          echo $data;?></td>

      
            
          </tr>
          <?php } } 
          else {
            while($rows_Requisicao = mysqli_fetch_assoc($resultado_RequisicaoPeriodo)){ 
              ?>
      
      <tr>
          <td><?php echo $rows_Requisicao['codigo'];?></td>
          <td><?php echo $rows_Requisicao['justificativa'];?></td>
          <td><?php echo $rows_Requisicao['solicitante'];?></td>
          <td><?php echo $rows_Requisicao['nomeUsuario'];?></td>
          <td><?php echo $rows_Requisicao['nomeLocal'];?></td>
          <td><?php 
          $dataBanco = $rows_Requisicao['data'];
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


