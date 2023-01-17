<?php 
include_once("Head.php")

?>


<?php 
include_once "../dao/conexao.php";
$result_consultaFuncionario="SELECT U.idUsuario,
U.nomeUsuario,
U.userAcesso,
U.idLocal 
from usuario U
where U.status = 1 and U.idLocal is not null";
$resultado_consultaFuncionario = mysqli_query($con, $result_consultaFuncionario);
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
                      <th>Nome</th>
                      <th>Usuário</th>
                     
                      <th>Ações</th>
                   
                    </tr>
                  </thead>
                
                  <tbody>
                  <?php while($rows_consultaFuncionario = mysqli_fetch_assoc($resultado_consultaFuncionario)){ 
        ?>
                    <tr>
                    <td><?php echo $rows_consultaFuncionario['nomeUsuario']; ?></td>
                    <td><?php echo $rows_consultaFuncionario['userAcesso']; ?></td>
                
	
<td>
    <?php  echo "<a  class='btn btn-primary' title='Resetar ' href='../dao/resetar_senha.php?idUsuario=" . $rows_consultaFuncionario['idUsuario'] . "&userAcesso=".$rows_consultaFuncionario['userAcesso']."' onclick=\"return confirm('Tem certeza que deseja reseta a senha?');\">" ?>Resetar<?php echo "</a>"; ?>
    <?php  echo "<a class='btn btn-danger' href='ExcluirFuncionario.php?idUsuario=" .$rows_consultaFuncionario['idUsuario']. "'onclick=\"return confirm('Tem certeza que deseja desligar esse funcionário?');\"> Desligar</a>";  ?>
    <?php  echo "<a class='btn btn-secondary' href='Historico.php?idUsuario=" .$rows_consultaFuncionario['idUsuario']. "'> Histórico</a>";  ?>
    <?php  echo "<a class='btn btn-secondary' href='editarFuncaoFuncionario.php?idUsuario=" .$rows_consultaFuncionario['idUsuario']. "'> Função</a>";  ?>
    <?php echo "<a class='btn btn-primary' href='ConsultarFuncionario.php?idUsuario=".$rows_consultaFuncionario['idUsuario'] ."' data-toggle='modal' data-target='#FuncionarioModal".$rows_consultaFuncionario['idUsuario']."'>" ?>Alterar<?php echo "</a>"; ?>
   <!-- Modal-->
   <div class="modal fade" id="FuncionarioModal<?php echo $rows_consultaFuncionario['idUsuario']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Alterar Funcionário</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="AlterarFuncionario.php" method="POST">

        <input type="text" hidden name="idUsuario"  class="form-control" value="<?php echo $rows_consultaFuncionario['idUsuario'];?>">
        <input type="text" hidden name="senha"  class="form-control" value="<?php echo $rows_consultaFuncionario['senha'];?>">
        <input type="text" hidden name="idLocal"  class="form-control" value="<?php echo $rows_consultaFuncionario['idLocal'];?>">

        <label>Nome Usuario</label>
        <input type="text" class="form-control" name="nomeUsuario" value="<?php echo $rows_consultaFuncionario['nomeUsuario']; ?>">

        <label>Usuário</label>
        <input type="text" class="form-control" name="user"  value="<?php echo $rows_consultaFuncionario['userAcesso']; ?>">




      
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