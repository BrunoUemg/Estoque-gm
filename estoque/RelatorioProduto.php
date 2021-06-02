<?php
include_once("../dao/conexao.php");

include_once("Head.php");

$result_consultaProduto="SELECT P.idProduto,
P.descricaoProduto, 
P.quantidadeProduto ,
L.nomeLocal 
FROM produto P, local L 
WHERE P.idLocal = L.idLocal  ";
$resultado_consultaProduto = mysqli_query($con, $result_consultaProduto);


$result_consultaProdutoFuncionario="SELECT P.idProduto,
P.descricaoProduto, 
P.quantidadeProduto ,
P.quantidadeMin,
L.nomeLocal 
FROM produto P, local L 
WHERE P.idLocal = '$_SESSION[idLocal]' and P.idLocal = L.idLocal ";
$resultado_consultaProdutoFuncionario = mysqli_query($con, $result_consultaProdutoFuncionario);

?>

<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

        <!-- Begin Page Content -->
        <div class="container-fluid">

  <div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <center><h3 class="m-0 font-weight-bold text-primary">Relatório de Produtos</h3></center>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="lista-produto" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Descrição</th>
            <th>Quantidade</th>
            <th>Local</th>
          </tr>
        </thead>
        
        <tbody>
        <?php if ($_SESSION['idLocal']==0) {
       while($rows_consultaProduto = mysqli_fetch_assoc($resultado_consultaProduto)){ 
        ?>
          <tr>
          <td><?php echo $rows_consultaProduto['descricaoProduto'];?></td>
          <td><?php echo $rows_consultaProduto['quantidadeProduto'];?></td>
          <td><?php echo $rows_consultaProduto['nomeLocal'];?></td>
          </tr>
          <?php } 
        } else if ($_SESSION['idLocal']!=0) {
          while($rows_consultaProdutoFuncionario = mysqli_fetch_assoc($resultado_consultaProdutoFuncionario)){ 
            ?>
    
              <tr>
              <td><?php echo $rows_consultaProdutoFuncionario['descricaoProduto'];?></td>
              <td><?php echo $rows_consultaProdutoFuncionario['quantidadeProduto'];?></td>
              <td><?php echo $rows_consultaProdutoFuncionario['nomeLocal'];?></td>
           </tr>
           <?php } 
        } ?> 
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


