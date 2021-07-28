<?php
include_once("../dao/conexao.php");

include_once("Head.php");

$result_consultaProduto="SELECT P.idProduto,
P.descricaoProduto, 
P.quantidadeProduto ,
P.quantidadeMin,
P.idLocal,
L.nomeLocal 
FROM produto P, local L 
WHERE P.idLocal = L.idLocal  ";
$resultado_consultaProduto = mysqli_query($con, $result_consultaProduto);

$result_consultaProdutoFuncionario="SELECT P.idProduto,
P.descricaoProduto, 
P.quantidadeProduto ,
P.quantidadeMin,
P.idLocal,
L.nomeLocal 
FROM produto P, local L 
WHERE P.idLocal = '$_SESSION[idLocal]' and P.idLocal = L.idLocal ";
$resultado_consultaProdutoFuncionario = mysqli_query($con, $result_consultaProdutoFuncionario);


$result_ProdutoLimiteFuncionario="SELECT idProduto,
descricaoProduto, 
quantidadeProduto,
quantidadeMin,
idLocal
FROM produto  
WHERE quantidadeProduto <= quantidadeMin and idLocal = '$_SESSION[idLocal]' ";
$resultado_ProdutoLimiteFuncionario = mysqli_query($con, $result_ProdutoLimiteFuncionario);

$result_ProdutoLimite="SELECT idProduto,
descricaoProduto, 
quantidadeProduto,
quantidadeMin
FROM produto  
WHERE quantidadeProduto <= quantidadeMin  ";
$resultado_ProdutoLimite = mysqli_query($con, $result_ProdutoLimite);

?>

<div class="container-fluid">

  <div class="container-fluid">

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <center><h3 class="m-0 font-weight-bold text-dark">Produtos em baixa quantidade</h3></center>
  </div>
  <div class="card-body-warning">
    <div class="table-responsive">
      <table class="table table-warning" id="baixo-produto" width="100%" cellspacing="0">
        <thead>

          <tr>
            <th >Nome</th>
            <th >Quantidade</th>
            <th >Quantidade Mínima</th>

            <th ></th>

</tr>
</thead>

<?php 
if ($_SESSION['idLocal']!=0) {
while($rows_ProdutoLimiteFuncionario = mysqli_fetch_assoc($resultado_ProdutoLimiteFuncionario)){ 
        ?>

          <tr>
          <td> <?php echo $rows_ProdutoLimiteFuncionario['descricaoProduto'];?></td>
          <td><?php echo $rows_ProdutoLimiteFuncionario['quantidadeProduto'];?></td>
          <td><?php echo $rows_ProdutoLimiteFuncionario['quantidadeMin'];?></td>


     <td>   <?php  echo "<a class='btn btn-success'  href='EntradaProduto.php?idProduto=".$rows_ProdutoLimiteFuncionario['idProduto'] .  "'>"?><i class="fas fa-cart-plus"></i><?php "</a>"; ?>
</td>
          </tr>
          <?php } 
          } else { 
            while($rows_ProdutoLimite = mysqli_fetch_assoc($resultado_ProdutoLimite)){ 
              ?>
      
                <tr>
                <td> <?php echo $rows_ProdutoLimite['descricaoProduto'];?></td>
                <td><?php echo $rows_ProdutoLimite['quantidadeProduto'];?></td>
                <td><?php echo $rows_ProdutoLimite['quantidadeMin'];?></td>
      
      
           <td>   <?php  echo "<a class='btn btn-success'  href='EntradaProduto.php?idProduto=".$rows_ProdutoLimite['idProduto'] .  "'>"?><i class="fas fa-cart-plus"></i><?php "</a>"; ?>
      </td>
                </tr>

                <?php } 
          } ?>
        </tbody>   
</table>

</div>
</div>
</div>
</div>
</div>

<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

        <!-- Begin Page Content -->
        <div class="container-fluid">

  <div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <center><h3 class="m-0 font-weight-bold text-primary">Consultar Produtos</h3></center>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="lista-produto" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Qntd Miníma</th>
            <th>Local</th>
            <th>Ações</th>
          </tr>
        </thead>
        
        <tbody>

        <?php if ($_SESSION['idLocal']!=0) {

         while($rows_consultaProdutoFuncionario = mysqli_fetch_assoc($resultado_consultaProdutoFuncionario)){ 
        ?>

          <tr>
          <td><?php echo $rows_consultaProdutoFuncionario['descricaoProduto'];?></td>
          <td><?php echo $rows_consultaProdutoFuncionario['quantidadeProduto'];?></td>
          <td><?php echo $rows_consultaProdutoFuncionario['quantidadeMin'];?></td>
          <td><?php echo $rows_consultaProdutoFuncionario['nomeLocal'];?></td>
           
          <td>
    <?php  echo "<a class='btn btn-success' title='adicionar Produto' href='EntradaProduto.php?idProduto=".$rows_consultaProdutoFuncionario['idProduto'] .  "'>" ?><i class="fas fa-cart-plus"></i><?php echo "</a>"; ?>
    <?php  echo "<a class='btn btn-primary' title='Editar Produto' href='DadosProduto.php?idProduto=".$rows_consultaProdutoFuncionario['idProduto'] .  "'>" ?><i class='fas fa-edit'></i><?php echo "</a>"; ?>
    <?php echo "<a class='btn btn-warning' title='Adicionar Produto no Carrinho' href='ConsultarProduto.php?idProduto=".$rows_consultaProdutoFuncionario['idProduto'] ."' data-toggle='modal' data-target='#carrinhoModal".$rows_consultaProdutoFuncionario['idProduto']."'>" ?><i class='fas fa-cart-arrow-down'></i><?php echo "</a>"; ?>

  </td>
              <!-- Modal-->
   <div class="modal fade" id="carrinhoModal<?php echo $rows_consultaProdutoFuncionario['idProduto']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Adicionar produto ao carrinho</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="Carrinho.php" method="POST">

        <input type="text" hidden name="idProduto"  class="form-control" value="<?php echo $rows_consultaProdutoFuncionario['idProduto'];?>">

        <label>Descrição do Produto</label>
        <input type="text" class="form-control" disabled value="<?php echo $rows_consultaProdutoFuncionario['descricaoProduto']; ?>">


<input type="hidden" class="form-control" name="descricao" value="<?php echo $rows_consultaProdutoFuncionario['descricaoProduto']; ?>">

<input type="hidden" class="form-control" name="quantidadeMax" value="<?php echo $rows_consultaProdutoFuncionario['quantidadeProduto']; ?>">

<input type="hidden" class="form-control" name="idLocal" value="<?php echo $rows_consultaProdutoFuncionario['idLocal']; ?>">
<label>Quantidade Maxíma</label>

<input type="text" disabled class="form-control" name="quantidade" value="<?php echo $rows_consultaProdutoFuncionario['quantidadeProduto']; ?>">
     
      <label>Quantidade</label>

        <input type="number" class="form-control" name="quantidade" min="1" max="<?php echo $rows_consultaProdutoFuncionario['quantidadeProduto']; ?>">
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
          <input type="submit" class="btn btn-primary" value="Adicionar">
          </form>

        </div>
      </div>
    </div>
  </div>
</td>
            </tr>
          <?php } 
        } else if ($_SESSION['idLocal']==0) {

while($rows_consultaProduto = mysqli_fetch_assoc($resultado_consultaProduto)){ 
?>

 <tr>
 <td><?php echo $rows_consultaProduto['descricaoProduto'];?></td>
 <td><?php echo $rows_consultaProduto['quantidadeProduto'];?></td>
 <td><?php echo $rows_consultaProduto['quantidadeMin'];?></td>
 <td><?php echo $rows_consultaProduto['nomeLocal'];?></td>
  
 <td>
<?php  echo "<a class='btn btn-success' title='Adicionar Produto' href='EntradaProduto.php?idProduto=".$rows_consultaProduto['idProduto'] .  "'>" ?><i class="fas fa-cart-plus"></i><?php echo "</a>"; ?>
<?php  echo "<a class='btn btn-primary' title='Editar Produto' href='DadosProduto.php?idProduto=".$rows_consultaProduto['idProduto'] .  "'>" ?><i class='fas fa-edit'></i><?php echo "</a>";?>
<?php  echo "<a  class='btn btn-danger' title='Excluir Produto' href='ExcluirProduto.php?idProduto=" .$rows_consultaProduto['idProduto']. "' onclick=\"return confirm('Tem certeza que deseja deletar esse registro?');\">"?> <i class='fas fa-trash-alt'></i><?php echo "</a>";  ?>
<?php echo "<a class='btn btn-warning' title='Adicionar Produto no Carrinho' href='ConsultarProduto.php?idProduto=".$rows_consultaProduto['idProduto'] ."' data-toggle='modal' data-target='#carrinhoModal".$rows_consultaProduto['idProduto']."'>" ?><i class='fas fa-cart-arrow-down'></i><?php echo "</a>"; ?>
<?php  echo "<a class='btn btn-secondary' title='Informação do produto' href='RelacaoProduto.php?idProduto=".$rows_consultaProduto['idProduto'] .  "'>" ?><i class="fas fa-chart-bar"></i><?php echo "</a>"; ?>  
<?php  echo "<a class='btn btn-secondary' title='Informação do produto' href='RelatorioProdutoUnico.php?idProduto=".$rows_consultaProduto['idProduto'] .  "'>" ?><i class="fas fa-file-pdf"></i><?php echo "</a>"; ?>  
   <!-- Modal-->
   <div class="modal fade" id="carrinhoModal<?php echo $rows_consultaProduto['idProduto']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Adicionar produto ao carrinho</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="Carrinho.php" method="POST">

        <input type="text" hidden name="idProduto"  class="form-control" value="<?php echo $rows_consultaProduto['idProduto'];?>">

        <label>Descrição do Produto</label>
        <input type="text" class="form-control" disabled value="<?php echo $rows_consultaProduto['descricaoProduto']; ?>">


<input type="hidden" class="form-control" name="descricao" value="<?php echo $rows_consultaProduto['descricaoProduto']; ?>">

<input type="hidden" class="form-control" name="quantidadeMax" value="<?php echo $rows_consultaProduto['quantidadeProduto']; ?>">

<input type="hidden" class="form-control" name="idLocal" value="<?php echo $rows_consultaProduto['idLocal']; ?>">
<label>Quantidade Maxíma</label>

<input type="text" disabled class="form-control" name="quantidadeproduto" value="<?php echo $rows_consultaProduto['quantidadeProduto']; ?>">
      <label>Quantidade</label>

        <input type="number" class="form-control" name="quantidade" min="1" max="<?php echo $rows_consultaProduto['quantidadeProduto']; ?>">
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
          <input type="submit" class="btn btn-primary" value="Adicionar">
          </form>

        </div>
      </div>
    </div>
  </div>
</td>
   
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

  <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

  <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"></script>

<!-- Page level plugins -->
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>


<script type="text/javascript">
        $(document).ready(function() {
    $('#lista-produto').DataTable( {
    "language": {
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

<script type="text/javascript">
        $(document).ready(function() {
    $('#baixo-produto').DataTable( {
    "language": {
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



