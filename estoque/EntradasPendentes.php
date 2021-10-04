<?php
include_once("Head.php");

?>

<?php 
include_once "../dao/conexao.php";
$result_consultaFiscal="SELECT N.idNotaFiscal,N.numeroNota,N.quantidade,N.comprovanteFiscal,P.descricaoProduto, P.idProduto, L.nomeLocal FROM notafiscal N 
INNER JOIN produto P ON N.idProduto = P.idProduto INNER JOIN local L ON L.idLocal = P.idLocal 
where N.status = 0 ";
$resultado_consultaFiscal = mysqli_query($con, $result_consultaFiscal);
?>
 <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
 <div class="card shadow mb-4">
 
            <div class="card-header py-3">
            <center>  <h3 class="m-0 font-weight-bold text-primary">Entradas Pendentes</h3><center>
            </div>
            <div class="card-body">
            <form action="FinalizarEntradas.php" method="POST" enctype="multipart/form-data">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nota fiscal</th>
                      <th>Local</th>
                      <th>Produto</th>
                      <th>Ações</th>
                      <th><input type="checkBox" onclick="selecionar()" class="form-control"  name="" id="adi"></th>
                    </tr>
                  </thead>
                
                  <tbody>
                  <?php 
                   $cont = 1;
                  while($rows_consultaFiscal = mysqli_fetch_assoc($resultado_consultaFiscal)){ 
                   
        ?>
                    <tr>
                    <td><?php echo $rows_consultaFiscal['numeroNota']; ?></td>
                    <td><?php echo $rows_consultaFiscal['nomeLocal']; ?></td>
                    <td><?php echo $rows_consultaFiscal['descricaoProduto']; ?></td>
	
<td>
<?php echo "<a class='btn btn-primary' title='Finalizar' href='EntradasPendentes.php?idNotaFiscal=".$rows_consultaFiscal['idNotaFiscal'] ."' data-toggle='modal' data-target='#finalizar".$rows_consultaFiscal['idNotaFiscal']."'>" ?>Visualizar<?php echo "</a>"; ?>
     <?php  echo "<a class='btn btn-success'  href='DadosNotaFiscal.php?idNotaFiscal=" .$rows_consultaFiscal['idNotaFiscal'] .  "'>Editar</a>";  ?>
   
   
    <?php  
    
    if($_SESSION['nomeUsuario'] != 'Financeiro' && $_SESSION['idLocal'] == 0){
    echo "<a class='btn btn-danger' href='ExcluirNotaFiscal.php?idNotaFiscal=" .$rows_consultaFiscal['idNotaFiscal']. "'onclick=\"return confirm('Tem certeza que deseja deletar essa nota fiscal?');\"> Excluir</a>"; }  ?>
	</td>

 
  <td><input type="checkBox" class="form-control" id="<?php echo $cont; ?>"   name="entrada[]" value="<?php echo $rows_consultaFiscal['idNotaFiscal'];?>" ></td>
  

  

  
    
    <div class="modal fade" id="finalizar<?php echo $rows_consultaFiscal['idNotaFiscal']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Visualizar entrada desse produto</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="FinalizarEntradas.php" method="POST">

        <input type="text" hidden name="idProduto"  class="form-control" value="<?php echo $rows_consultaFiscal['idProduto'];?>">
        <input type="text" hidden name="idNotaFiscal"  class="form-control" value="<?php echo $rows_consultaFiscal['idNotaFiscal'];?>">            
        <label>Descrição do Produto</label>
       <input type="text" readOnly name="descricaoProduto" class="form-control"  value="<?php echo $rows_consultaFiscal['descricaoProduto'] ?>">
       <label for="">Quantidade</label>
       <input type="text" readOnly name="quantidade" class="form-control"  value="<?php echo $rows_consultaFiscal['quantidade'] ?>">
       <a href="../nota_fiscal/<?php echo $rows_consultaFiscal['comprovanteFiscal']; ?>" target="_blank" rel="noopener noreferrer">Visualizar comprovante</a><br>
      
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
         
          </form>

        </div>
      </div>
    </div>
  </div>
</td>
	
    </tr>
                  <?php 
                
                $cont += 1; 
                
                }
                $cont -= 1;
                ?>
                  </tbody>
                </table>
                <center>
               <label for="">Senha de validação</label> 
               <input type="password" name="senha_validacao" required="required" class="form-control  col-md-5 col-xs-12" id=""></center> <br>
                <center> <input type='submit' name='button' value='Finalizar requisição' class="btn btn-success" ></center>  
              </form>
              </div>
            </div>
</div>


<script>

function selecionar() {
  
  if(document.getElementById("adi").checked == true){
    var cont2 = 1;
    var cont = <?php echo $cont; ?>;
    for(cont2; cont2 <= cont; cont2++){
  document.getElementById(cont2).checked = true;
  document.getElementById(cont2).checked = true;
    }
  }
  if(document.getElementById("adi").checked == false){
    var cont2 = 1;
    var cont = <?php echo $cont; ?>;
    for(cont2; cont2 <= cont; cont2++){
  document.getElementById(cont2).checked = false;
  document.getElementById(cont2).checked = false;
    }
  }
  
}

</script>

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


