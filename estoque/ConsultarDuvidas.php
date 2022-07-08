<?php
include_once("Head.php");

?>

<?php
include_once "../dao/conexao.php";
$result_consultaDuvidas = "select * from duvidas";
$resultado_consultaDuvidas = mysqli_query($con, $result_consultaDuvidas);
?>
<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <center>
            <h3 class="m-0 font-weight-bold text-primary">Consultar Duvidas</h3>
            <center>
    </div>
    <div class="card-body">
        <?php
        if (!empty($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        } ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Pergunta</th>
                        <th>Resposta</th>
                        <th></th>

                    </tr>
                </thead>

                <tbody>
                    <?php while ($rows_duvidas = mysqli_fetch_assoc($resultado_consultaDuvidas)) {

                    ?>
                        <tr>
                            <td><?php echo $rows_duvidas['tituloPergunta']; ?></td>
                            <td><?php echo $rows_duvidas['respostaPergunta']; ?></td>

                            <td>
                                <?php echo "<a class='btn btn-success' data-toggle='modal' data-target='#Modal" . $rows_duvidas['idPergunta'] . "' >Editar</a>";  ?>
                                <?php echo "<a class='btn btn-danger' href='ExcluirDuvida.php?idPergunta=" . $rows_duvidas['idPergunta'] . "'onclick=\"return confirm('Tem certeza que deseja deletar essa pergunta?');\"> Excluir</a>";  ?>
                            </td>


                        </tr>

                        <div class="modal fade" id="Modal<?php echo $rows_duvidas['idPergunta']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Alterar Duvidas</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="AlterarDuvida.php" method="POST">

                                            <input type="text" hidden name="idPergunta" class="form-control" value="<?php echo $rows_duvidas['idPergunta']; ?>">


                                            <label>Pergunta</label>
                                            <input type="text" class="form-control" name="titulo" value="<?php echo $rows_duvidas['tituloPergunta']; ?>">

                                            <label>Resposta</label>
                                            <textarea rows="15" name="resposta" class="form-control" required id="trumbowyg-editor"><?php echo $rows_duvidas['respostaPergunta'] ?></textarea>





                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                                        <input type="submit" name="enviar" class="btn btn-success" value="Salvar">
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }  ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


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
        $('#dataTable').DataTable({
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