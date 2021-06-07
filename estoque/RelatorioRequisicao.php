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

$result_consultaRequisicaoFuncionario="SELECT L.idProduto,L.quantidade,R.codigo,L.idLocal, N.nomeLocal, P.descricaoProduto,R.data,R.solicitante,R.justificativa,U.nomeUsuario from listarequisicao L, requisicao R, produto P, local N, usuario U 
WHERE R.idRequisicao = L.idRequisicao and L.idLocal = N.idLocal and P.idProduto = L.idProduto 
and N.idLocal = '$_SESSION[idLocal]' and U.idUsuario = R.idUsuario";
$resultado_consultaRequisicaoFuncionario= mysqli_query($con, $result_consultaRequisicaoFuncionario);

$result_consultaRequisicao="SELECT L.idProduto,L.quantidade,L.idLocal, N.nomeLocal, P.descricaoProduto,R.codigo,R.data,R.solicitante,R.justificativa,U.nomeUsuario from listarequisicao L, requisicao R, produto P, local N,usuario U 
WHERE R.idRequisicao = L.idRequisicao and L.idLocal = N.idLocal and P.idProduto = L.idProduto 
and U.idUsuario = R.idUsuario";
$resultado_consultaRequisicao = mysqli_query($con, $result_consultaRequisicao);
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
    <center><h3 class="m-0 font-weight-bold text-primary">Relatório de Requisição</h3></center>
        
    <form action="RelatorioRequisicao.php" class="row g-3" method="POST" onsubmit="return(verifica())" class="form-horizontal form-label-left">


  <div class="col-md-4">
    <label  class="form-label">Data Início</label>
    <input type="date" required="required" id="dataInicio" class="form-control" name="dataInicio" value="<?php echo $dataInicio;?>">
  </div>
  <div class="col-md-4">
    <label  class="form-label">Data Final</label>
    <input type="date" required="required" id="dataFinal" class="form-control" name="dataFinal" value="<?php echo $dataFinal;?>" >
  </div>
<?php if($_SESSION['idLocal'] == 0) { ?>
  <div class="col-md-4">
    <label for="inputPassword4" class="form-label">Local</label>
    <select name="local" id="" class="form-control">
<option value="Todos">Todos</option>
<?php while($rows_local = mysqli_fetch_assoc($resultado_local)){ ?>

<option value="<?php echo $rows_local['idLocal'];?>"><?php echo ($rows_local['nomeLocal']);?></option>

<?php } ?>	
</select>
  </div>
 <?php } ?>
  <div class="col-12">
  <label for="">Dados a mostrar na busca</label>
    <div class="form-check">
      <input class="form-check-input" id="myRadio"  name="justificativa" type="checkbox" id="gridCheck">
      <label class="form-check-label"  for="gridCheck">
        Justificativa
      </label>
    </div>
  </div>
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" id="myRadio1"  name="retirante" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Retirante
      </label>
    </div>
  </div>
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" id="myRadio2"  name="localFiltro" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
       Local
      </label>
    </div>
  </div>
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" id="myRadio3"  name="solicitante" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
       Solicitante
      </label>
    </div>
  </div>

  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" id="myRadio4"  name="solicitante"  onclick="selecionar()"  type="checkBox" >
      <label class="form-check-label" for="gridCheck">
       Selecionar Todos
      </label>
    </div>
  </div>
 
  
 <script>
 function selecionar() {
  
  if(document.getElementById("myRadio4").checked == true){
  document.getElementById("myRadio").checked = true;
  document.getElementById("myRadio1").checked = true;
  document.getElementById("myRadio2").checked = true;
  document.getElementById("myRadio3").checked = true;
  }else{
    document.getElementById("myRadio").checked = false; 
  document.getElementById("myRadio1").checked = false; 
  document.getElementById("myRadio2").checked = false; 
  document.getElementById("myRadio3").checked = false; 
  }
  
}


 </script>


  
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Buscar</button>
  </div>
</form>
<br>
<form action="">
<button type="submit" class="btn btn-primary">Geral</button>
</form>
  </div>
  <?php if(!isset($_POST['dataInicio'])) { ?>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="lista-produto" width="100%" cellspacing="0">
        <thead>
          <tr>
          <th>Codigo</th>
            <th>Justificativa</th>
            <th>Produto</th>
            <th>Solicitante</th>
            <th>Local</th>
            <th>Retirante</th>
            <th>Data</th>
            <th>Quantidade</th>
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
          <td><?php echo $rows_consultaRequisicaoFuncionario['descricaoProduto'];?></td>
          <td><?php echo $rows_consultaRequisicaoFuncionario['solicitante'];?></td>  
          <td><?php echo $rows_consultaRequisicaoFuncionario['nomeLocal'];?></td>
          <td><?php echo $rows_consultaRequisicaoFuncionario['nomeUsuario'];?></td>
          <td><?php 
          $dataBanco = $rows_consultaRequisicaoFuncionario['data'];
          $data = date("d/m/Y", strtotime($dataBanco));
          echo $data;?></td>
          <td><?php echo $rows_consultaRequisicaoFuncionario['quantidade'];?></td>
      
            
          </tr>
          <?php } } 
          else {
            while($rows_consultaRequisicao = mysqli_fetch_assoc($resultado_consultaRequisicao)){ 
              ?>
      
      <tr>
          <td><?php echo $rows_consultaRequisicao['codigo'];?></td>
          <td><?php echo $rows_consultaRequisicao['justificativa'];?></td>
          <td><?php echo $rows_consultaRequisicao['descricaoProduto'];?></td>
          <td><?php echo $rows_consultaRequisicao['solicitante'];?></td>
          <td><?php echo $rows_consultaRequisicao['nomeLocal'];?></td>
          <td><?php echo $rows_consultaRequisicao['nomeUsuario'];?></td>
          <td><?php 
          $dataBanco = $rows_consultaRequisicao['data'];
          $data = date("d/m/Y", strtotime($dataBanco));
          echo $data;?></td>
          <td><?php echo $rows_consultaRequisicao['quantidade'];?></td>  
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
   
        
   
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="lista-produto" width="100%" cellspacing="0">
        <thead>
          <tr>
          <th>Código</th>
            <?php if(isset($_POST['justificativa'])){ ?>
            <th>Justificativa</th>
            <?php } ?>
            <th>Produto</th>
            <?php if(isset($_POST['solicitante'])){ ?>
            <th>Solicitante</th>
            <?php } if(isset($_POST['localFiltro'])){ ?>  
            <th>Local</th>
            <?php } if(isset($_POST['retirante'])){ ?>
            <th>Retirante</th>
            <?php } ?>
            <th>Data</th>
            <th>Quantidade</th>

          </tr>
        </thead>
        
        <tbody>

        <?php 
        
        if ($_SESSION['idLocal']!=0) {
        while($rows_RequisicaoFuncionario = mysqli_fetch_assoc($resultado_RequisicaoPeriodoFun)){ 
        ?>

          <tr>
          <td><?php echo $rows_RequisicaoFuncionario['codigo'];?></td>
          <?php if(isset($_POST['justificativa'])) { ?>
          <td><?php echo $rows_RequisicaoFuncionario['justificativa'];?></td>
          <?php } ?>
          <td><?php echo $rows_RequisicaoFuncionario['descricaoProduto'];?></td>
          <?php if(isset($_POST['solicitante'])) { ?>
          <td><?php echo $rows_RequisicaoFuncionario['solicitante'];?></td>
          <?php } if(isset($_POST['localFiltro'])) { ?>
          <td><?php echo $rows_RequisicaoFuncionario['nomeLocal'];?></td>
          <?php } if(isset($_POST['retirante'])) { ?>
          <td><?php echo $rows_RequisicaoFuncionario['nomeUsuario'];?></td>
          <?php } ?>
          <td><?php 
          $dataBanco = $rows_RequisicaoFuncionario['data'];
          $data = date("d/m/Y", strtotime($dataBanco));
          echo $data;?></td>
           <td><?php echo $rows_RequisicaoFuncionario['quantidade'];?></td>
      
            
          </tr>
          <?php } } 
          else {
            while($rows_Requisicao = mysqli_fetch_assoc($resultado_RequisicaoPeriodo)){ 
              ?>
      
      <tr>    
          <td><?php echo $rows_Requisicao['codigo'];?></td>
          <?php if(isset($_POST['justificativa'])) { ?>
          <td><?php echo $rows_Requisicao['justificativa'];?></td>
          <?php } ?>
          <td><?php echo $rows_Requisicao['descricaoProduto'];?></td>
          <?php if(isset($_POST['solicitante'])) { ?>
          <td><?php echo $rows_Requisicao['solicitante'];?></td>
          <?php } if(isset($_POST['localFiltro'])) { ?>
          <td><?php echo $rows_Requisicao['nomeLocal'];?></td>
          <?php } if(isset($_POST['retirante'])) { ?>
          <td><?php echo $rows_Requisicao['nomeUsuario'];?></td>
          <?php } ?>
          <td><?php 
          $dataBanco = $rows_Requisicao['data'];
          $data = date("d/m/Y", strtotime($dataBanco));
          echo $data;?></td>
          <td><?php echo $rows_Requisicao['quantidade'];?></td>
            
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


