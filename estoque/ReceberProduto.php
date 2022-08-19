<?php

include_once("Head.php");
include_once "../dao/conexao.php";
$result_consultaProduto = "SELECT  * FROM transferencia T 
INNER JOIN itens_transferencia I ON I.idTransferencia = T.idTransferencia 
INNER JOIN produto P ON P.idProduto = I.idProduto
INNER JOIN local L ON L.idLocal = T.idLocal_destino
INNER JOIN usuario U ON U.idUsuario = T.idUsuario 
WHERE T.status = 0 group by T.idTransferencia";
$resultado_Produto = mysqli_query($con, $result_consultaProduto);
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

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
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Situação</th>
                        <th>Destino</th>
                        <th>Cedente</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    $cont = 1;
                    while ($rows_consultaProduto = mysqli_fetch_assoc($resultado_Produto)) {
                        $select_localusu = mysqli_query($con,"SELECT * FROM local_usuario where idUsuario = '$_SESSION[idUsuario]' and idLocal = '$rows_consultaProduto[idLocal_destino]'");

                        if(mysqli_num_rows($select_localusu) > 0 || $_SESSION['idLocal'] == null){
                    ?>
                        <tr>
                            <td><?php echo date("d/m/Y", strtotime($rows_consultaProduto['dataTransferencia'])); ?></td>
                            <td><?php echo $rows_consultaProduto['horaTransferencia']; ?></td>
                            <td><?php echo $rows_consultaProduto['situacao']; ?></td>
                            <td><?php echo $rows_consultaProduto['nomeLocal'] ?></td>
                            <td><?php echo $rows_consultaProduto['nomeUsuario'] ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visualizarTransferencia<?php echo $rows_consultaProduto['idProduto'] ?>">Visualizar</button>
                                <a href="TermoTransferencia.php?idTransferencia=<?php echo $rows_consultaProduto['idTransferencia'] ?>" class="btn btn-primary" target="_blank" title="Relatório de termos e nfs" rel="noopener noreferrer">Rela Termo</a>
                                <a href="EditarItensTransferencia.php?idTransferencia=<?php echo $rows_consultaProduto['idTransferencia'] ?>" class="btn btn-primary" title="Editar itens da transferência" rel="noopener noreferrer">Editar valor itens</a>
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
                                        <form action="EnvioFinalizarTransferencia.php" method="POST" enctype="multipart/form-data">
                                            <ul class="list-group">
                                                <li class="d-flex justify-content-center align-items-center list-group-item active"><?php echo strftime('%d de %B de %Y', strtotime($rows_consultaProduto['dataTransferencia']))   ?> - <?php echo date('H:i', strtotime($rows_consultaProduto['horaTransferencia'])) ?></li>
                                                <?php
                                                $selectItensProduto = mysqli_query($con, "SELECT P.descricaoProduto, I.quantidade, P.idProduto FROM itens_transferencia I 
                                                INNER JOIN produto P ON P.idProduto = I.idProduto  
                                                WHERE I.idTransferencia = '$rows_consultaProduto[idTransferencia]' order by P.descricaoProduto asc");

                                                while ($rowsItensProduto = mysqli_fetch_assoc($selectItensProduto)) { ?>
                                                    <li class="list-group-item"><?php echo $rowsItensProduto['descricaoProduto'] ?>
                                                        <span class="badge badge-primary badge-pill"><?php echo $rowsItensProduto['quantidade'] ?></span>
                                                    </li>
                                                    <!-- INPUTS PARA O POST -->
                                                    <input type="text" hidden readonly name="descricaoProduto[]" value="<?php echo $rowsItensProduto['descricaoProduto'] ?>">
                                                    <input type="text" hidden readonly name="quantidade[]" value="<?php echo $rowsItensProduto['quantidade'] ?>">
                                                    <input type="text" hidden readonly name="idProduto[]" value="<?php echo $rowsItensProduto['idProduto'] ?>">
                                                <?php } ?>
                                                <input type="text" hidden readonly name="idTransferencia" value="<?php echo $rows_consultaProduto['idTransferencia'] ?>">
                                                <input type="text" hidden readonly name="idLocal_destino" value="<?php echo $rows_consultaProduto['idLocal_destino'] ?>">
                                                <li class="d-flex justify-content-center align-items-center list-group-item active">Solicitante: <?php echo $rows_consultaProduto['solicitante'] ?></li>
                                            </ul>

                                            <ul class="list-group mt-3">
                                                <li class="d-flex justify-content-center align-items-center list-group-item active">Outras Informações</li>
                                                <li class="list-group-item">Destino: <?php echo $rows_consultaProduto['nomeLocal'] ?></li>
                                                <li class="list-group-item">Justificativa: <?php echo $rows_consultaProduto['justificativa'] ?></li>
                                                <li class="d-flex justify-content-center align-items-center list-group-item active"></li>
                                            </ul>

                                            <div class="form-group mt-3">
                                                <label for="">Senha de validação</label>
                                                <input type="password" name="senha_validacao" required="required" class="form-control" id="">
                                                </center> <br>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" value="Aprovar" name="salvar" class="btn btn-success">
                                        <input type="submit" value="Recusar" name="salvar" class="btn btn-danger">
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

<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"></script>

<!-- Page level plugins -->
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>




<script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable({
            columnDefs: [{
                targets: 4,
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