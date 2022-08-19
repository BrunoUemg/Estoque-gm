<?php

include_once("Head.php");
include_once "../dao/conexao.php";
$idTransferencia = $_GET['idTransferencia'];


$result_consultaProduto = "SELECT  * FROM itens_transferencia I INNER JOIN produto P ON P.idProduto = I.idProduto
INNER JOIN transferencia T ON T.idTransferencia = I.idTransferencia where I.idTransferencia = '$idTransferencia'";
$resultado_Produto = mysqli_query($con, $result_consultaProduto);
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

if(isset($_POST['salvar']))
{
    $valorUnitario = $_POST['valorUnitario'];
    $idItens = $_POST['idItens'];
    $con->query("UPDATE itens_transferencia set valorUnitario = '$valorUnitario' where idItensTransferencia = '$idItens'");
    echo "<script>alert('Cadastro alterado com sucesso!');window.location='EditarItensTransferencia.php?idTransferencia=$idTransferencia'</script>";
    exit();
}

?>
<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <center>
            <h3 class="m-0 font-weight-bold text-primary">Receber Produto</h3>
            <center>
    </div>
    <div class="card-body">
        <?php
        if (!empty($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        } ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="basic-datatables" width="100%" cellspacing="0">
                <thead>
                    <tr>
                     
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor unitário</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    $cont = 1;
                    while ($rows_consultaProduto = mysqli_fetch_assoc($resultado_Produto)) {
                        $select_localusu = mysqli_query($con,"SELECT * FROM local_usuario where idUsuario = '$_SESSION[idUsuario]' and idLocal = '$rows_consultaProduto[idLocal_destino]'");

                        if(mysqli_num_rows($select_localusu) > 0 || $_SESSION['idLocal'] == null){
                            if($rows_consultaProduto['valorUnitario'] == null){
                                $row_last_nf_produto = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM notafiscal where idProduto = '$rows_consultaProduto[idProduto]' order by idNotaFiscal desc limit 1"));
                                $valorUnitario = $row_last_nf_produto['valor'];
                            }else{
                                $valorUnitario = $rows_consultaProduto['valorUnitario'];
                            }   
                    
                    ?>
                        <tr>
                        
                            <td><?php echo $rows_consultaProduto['descricaoProduto']; ?></td>
                            <td><?php echo $rows_consultaProduto['quantidade']; ?></td>
                            <td><?php echo $valorUnitario; ?></td>
                           
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visualizarTransferencia<?php echo $rows_consultaProduto['idProduto'] ?>">Editar</button>
                            </td>
                        </tr>
                        <?php
                        $cont += 1; ?>

                        <!-- MODAL PARA VISUALIZAR LISTA DE PRODUTOS--->
                        <div class="modal fade" id="visualizarTransferencia<?php echo $rows_consultaProduto['idProduto'] ?>" tabindex="-1" role="dialog" aria-labelledby="visualizarTransferencia" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Informações dos Produtos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="POST" enctype="multipart/form-data">
                                          
                            <label for="">Valor unitário</label>
                            <input type="text" class="form-control" value="<?php echo $rows_consultaProduto['valorUnitario'] ?>" name="valorUnitario" onKeyPress="return(moeda(this,'','.',event))">
                            <input type="text" class="form-control" value="<?php echo $rows_consultaProduto['idItensTransferencia'] ?>" name="idItens" >
                                    
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" value="Salvar" name="salvar" class="btn btn-success">
                                      
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    <?php
                    } }
                    $cont -= 1;
                    ?>
                </tbody>
            </table>

        </div>
    </div>

    <script>
        function selecionar() {

            if (document.getElementById("adi").checked == true) {
                var cont2 = 1;
                var cont = <?php echo $cont; ?>;
                for (cont2; cont2 <= cont; cont2++) {
                    document.getElementById(cont2).checked = true;
                    document.getElementById(cont2).checked = true;
                }
            }
            if (document.getElementById("adi").checked == false) {
                var cont2 = 1;
                var cont = <?php echo $cont; ?>;
                for (cont2; cont2 <= cont; cont2++) {
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
<script type="text/javascript" src="../js/mascaras.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"></script>

<!-- Page level plugins -->
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>




<script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable({
            columnDefs: [{
                targets: 3,
                orderable: false
            }],
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 linhas', '25 linhas', '50 linhas', 'Mostrar tudo']
            ],
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
        });
    });
</script>


</body>

</html>