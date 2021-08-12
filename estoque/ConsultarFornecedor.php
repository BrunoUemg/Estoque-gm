<?php 
include_once("Head.php")

?>


<?php 
include_once "../dao/conexao.php";
$result_consultaFornecedor="SELECT * FROM fornecedor";
$resultado_consultaFornecedor = mysqli_query($con, $result_consultaFornecedor);
?>
 <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
 <div class="card shadow mb-4">
 
            <div class="card-header py-3">
            <center>  <h3 class="m-0 font-weight-bold text-primary">Consultar Funcionário</h3><center>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nome fantasia</th>
                      <th>Celular</th>
                      <th>E-mail</th>
                      <th>Observação</th>
                      <th>Ações</th>
                   
                    </tr>
                  </thead>
                
                  <tbody>
                  <?php while($rows_consultaFornecedor = mysqli_fetch_assoc($resultado_consultaFornecedor)){ 
        ?>
                    <tr>
                    <td><?php echo $rows_consultaFornecedor['nomeFantasia']; ?></td>
                    <td><?php echo $rows_consultaFornecedor['celular']; ?></td>
                    <td><?php echo $rows_consultaFornecedor['email']; ?></td>
                    <td><?php echo $rows_consultaFornecedor['observacao']; ?></td>

	
<td>
<?php 
if($_SESSION['idLocal'] == 0){
echo "<a class='btn btn-primary' href='ConsultarFornecedor.php?idFornecedor=".$rows_consultaFornecedor['idFornecedor'] ."' data-toggle='modal' data-target='#FornecedorModal".$rows_consultaFornecedor['idFornecedor']."'>" ?>Alterar<?php echo "</a>"; } ?>
    <?php  echo "<a class='btn btn-danger' href='ExcluirFornecedor.php?idFornecedor=" .$rows_consultaFornecedor['idFornecedor']. "'onclick=\"return confirm('Tem certeza que deseja deletar esse funcionário?');\"> Excluir</a>";  ?>
   
   
   <!-- Modal-->
   <div class="modal fade" id="FornecedorModal<?php echo $rows_consultaFornecedor['idFornecedor']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Alterar Fornecedor</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="AlterarFornecedor.php" method="POST">

        <input type="text" hidden name="idFornecedor"  class="form-control" value="<?php echo $rows_consultaFornecedor['idFornecedor'];?>">
       

        <label>Nome Fantasia</label>
        <input type="text" class="form-control" name="nomeFantasia" value="<?php echo $rows_consultaFornecedor['nomeFantasia']; ?>">

        <label>Razão Social</label>
        <input type="text" class="form-control" name="razaoSocial"  value="<?php echo $rows_consultaFornecedor['razaoSocial']; ?>">
        <label for="">CNPJ/CPF</label>
        <input type="text" class="form-control" name="doc" onKeyPress="MascaraGenerica(this, 'CPFCNPJ');" value="<?php echo $rows_consultaFornecedor['doc']; ?>">
        <label for="">Observação</label>
        <textarea name="observacao" class="form-control" id="" cols="30" rows="10"><?php echo $rows_consultaFornecedor['observacao']; ?></textarea>
        
        <label>Telefone</label>
        <input type="text" class="form-control" name="telefone" onkeyup="mascara('(##) ####-####',this,event,true)" value="<?php echo $rows_consultaFornecedor['telefone']; ?>">

        <label>Celular</label>
        <input type="text" class="form-control" name="celular" onkeyup="mascara('(##) #####-####',this,event,true)"  value="<?php echo $rows_consultaFornecedor['celular']; ?>">
        <label>E-mail</label>
        <input type="email" class="form-control" name="email" value="<?php echo $rows_consultaFornecedor['email']; ?>">

       




      
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
          <input type="submit" name="enviar" class="btn btn-success" value="Salvar" >
          </form>

        </div>
      </div>
    </div>
  </div>
</td>
    
    </td>
   
	
    </tr>
                  <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
</div>


</div>
      </div>        



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
<script src="../js/mascaras.js"></script>

<script type="text/javascript">
        $(document).ready(function() {
    $('#dataTable').DataTable( {
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