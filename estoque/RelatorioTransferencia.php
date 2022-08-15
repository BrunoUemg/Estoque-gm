<?php
include_once("../dao/conexao.php");

include_once("Head.php");


if (!empty($_POST['pesquisar'])) {
    $dataInicio = $_POST['dataInicio'];
    $dataFinal = $_POST['dataFinal'];
    if (!empty($_POST['local'])) {
        $idLocal = $_POST['idLocal'];
        $result_consultaProduto = "SELECT  * FROM transferencia T 
        INNER JOIN itens_transferencia I ON I.idTransferencia = T.idTransferencia 
        INNER JOIN produto P ON P.idProduto = I.idProduto
        INNER JOIN local L ON L.idLocal = T.idLocal_destino
        INNER JOIN usuario U ON U.idUsuario = T.idUsuario 
        WHERE T.status = 1 and T.dataTransferencia >= '$dataInicio' and T.dataTransferencia <= '$dataFinal' and
        T.idLocal_destino = '$idLocal' group by T.idTransferencia";
        $resultado_Produto = mysqli_query($con, $result_consultaProduto);
    } else {
        
        $result_consultaProduto = "SELECT  * FROM transferencia T 
        INNER JOIN itens_transferencia I ON I.idTransferencia = T.idTransferencia 
        INNER JOIN produto P ON P.idProduto = I.idProduto
        INNER JOIN local L ON L.idLocal = T.idLocal_destino
        INNER JOIN usuario U ON U.idUsuario = T.idUsuario 
        WHERE T.status = 1 and T.dataTransferencia >= '$dataInicio' and T.dataTransferencia <= '$dataFinal' group by T.idTransferencia";
        $resultado_Produto = mysqli_query($con, $result_consultaProduto);
    }
}


setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$select_local = mysqli_query($con, "SELECT * FROM local order by nomeLocal asc");

?>

<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <center>
                    <h3 class="m-0 font-weight-bold text-primary">Relatório Transferências dos Produtos</h3>
                </center>
            </div>
            <div class="card-body">
                <form action="" method="post" name="formulario">
                    <div class="row">
                        <div class="col">
                            <?php
                            $data_incioInp = mktime(0, 0, 0, date('m'), 1, date('Y'));

                            $data_incioInpF = date('Y-m-d', $data_incioInp);

                            ?>
                            <label for="">Data início</label>
                            <input type="date" class="form-control" required name="dataInicio" value="<?php echo $data_incioInpF ?>" id="">
                        </div>
                        <div class="col">
                            <label for="">Data final</label>
                            <input type="date" class="form-control" required name="dataFinal" value="<?php echo date("Y-m-d") ?>" id="">
                        </div>

                        <div class="col">
                            <label for="">Filtrar por local destino(não obrigatório)</label>
                            <select name="idLocal" class="selectFiltro form-control" id="">
                                <option disabled selected value="">Selecione</option>
                                <?php while ($rows_local = mysqli_fetch_assoc($select_local)) { 
                                    $select_localusu = mysqli_query($con,"SELECT * FROM local_usuario where idUsuario = '$_SESSION[idUsuario]' and idLocal = '$rows_local[idLocal]'");

                                    if(mysqli_num_rows($select_localusu) > 0 || $_SESSION['idLocal'] == null){
                                    ?>

                                    <option value="<?php echo $rows_local['idLocal'] ?>"><?php echo $rows_local['nomeLocal']; ?></option>

                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <input type="submit" class="btn btn-primary mb-3" name="pesquisar" value="Pesquisar" id="">
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered" id="lista-produto" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Cod. Transferência</th>
                                <th>Data</th>
                                <th>Horário</th>
                                <th>Situação</th>
                                <th>Cedente</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (!empty($_POST['pesquisar'])) {
                                while ($rows_consultaProduto = mysqli_fetch_assoc($resultado_Produto)) {
                            ?>
                                    <tr>
                                        <td><?php echo $rows_consultaProduto['idTransferencia']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($rows_consultaProduto['dataTransferencia'])); ?></td>
                                        <td><?php echo date('H:i', strtotime($rows_consultaProduto['horaTransferencia'])); ?></td>
                                        <td><?php echo $rows_consultaProduto['situacao']; ?></td>
                                        <td><?php echo $rows_consultaProduto['nomeUsuario']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visualizarTransferencia<?php echo $rows_consultaProduto['idProduto'] ?>">Visualizar Itens</button>
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#visualizarHistorico<?php echo $rows_consultaProduto['idProduto'] ?>">Visualizar Histórico</button>
                                            <a href="TermoTransferencia.php?idTransferencia=<?php echo $rows_consultaProduto['idTransferencia'] ?>" class="btn btn-primary" target="_blank" title="Relatório de termos e nfs" rel="noopener noreferrer">Rela Termo</a>
                                        </td>
                                    </tr>

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
                                                        <!-- ITENS DA LISTA  -->
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
                                                            <?php } ?>
                                                            <li class="d-flex justify-content-center align-items-center list-group-item active">Solicitante: <?php echo $rows_consultaProduto['solicitante'] ?></li>
                                                        </ul>
                                                        <!-- OUTRAS INFORMAÇÕES  -->
                                                        <ul class="list-group mt-3">
                                                            <li class="d-flex justify-content-center align-items-center list-group-item active">Outras Informações</li>
                                                            <li class="list-group-item">Destino: <?php echo $rows_consultaProduto['nomeLocal'] ?></li>
                                                            <li class="list-group-item">Justificativa: <?php echo $rows_consultaProduto['justificativa'] ?></li>
                                                            <li class="d-flex justify-content-center align-items-center list-group-item active"></li>
                                                        </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MODAL PARA VISUALIZAR HISTÓRICO --->
                                    <div class="modal fade" id="visualizarHistorico<?php echo $rows_consultaProduto['idProduto'] ?>" tabindex="-1" role="dialog" aria-labelledby="visualizarTransferencia" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Informações do Histórico</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="EnvioFinalizarTransferencia.php" method="POST" enctype="multipart/form-data">
                                                        <!-- ITENS DA LISTA  -->
                                                        <ul class="list-group">
                                                            <li class="d-flex justify-content-center align-items-center list-group-item active"><?php echo strftime('%d de %B de %Y', strtotime($rows_consultaProduto['dataTransferencia']))   ?> - <?php echo date('H:i', strtotime($rows_consultaProduto['horaTransferencia'])) ?></li>
                                                            <?php
                                                            $selectHistorico = mysqli_query($con, "SELECT * FROM historico_transferencia H
                                                            INNER JOIN transferencia T ON T.idTransferencia = H.idTransferencia INNER JOIN usuario U
                                                            ON U.idUsuario = H.idUsuario 
                                                            WHERE T.idTransferencia = '$rows_consultaProduto[idTransferencia]'");

                                                            while ($rows_historico = mysqli_fetch_assoc($selectHistorico)) { ?>
                                                                <li class="list-group-item"><?php echo $rows_historico['acao'] ?>
                                                                    <span class="badge badge-primary badge-pill"><?php echo date("d/m/Y", strtotime($rows_historico['data'])) ?></span>
                                                                    <span class="badge badge-primary badge-pill"><?php echo $rows_historico['hora'] ?></span>
                                                                    <span class="badge badge-primary badge-pill"><?php echo $rows_historico['nomeUsuario'] ?></span>
                                                                </li>
                                                            <?php } ?>
                                                            <li class="d-flex justify-content-center align-items-center list-group-item active">Solicitante: <?php echo $rows_consultaProduto['solicitante'] ?></li>
                                                        </ul>                                                       
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">


<script type="text/javascript">
    $(document).ready(function() {
        $('#lista-produto').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'pdf', {
                    extend: 'print',
                    text: 'Imprimir',
                    key: {
                        key: 'p',
                        altkey: true
                    }
                },
                'pageLength'

            ],

            lengthMenu: [
                [10, 25, 50, -1],
                ['10 linhas', '25 linhas', '50 linhas', 'Mostrar tudo']
            ],


            "language": {
                "emptyTable": "Nenhum registro encontrado",
                "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 até 0 de 0 registros",
                "infoFiltered": "(Filtrados de _MAX_ registros)",
                "infoThousands": ".",
                "loadingRecords": "Carregando...",
                "processing": "Processando...",
                "zeroRecords": "Nenhum registro encontrado",
                "search": "Pesquisar",
                "paginate": {
                    "next": "Próximo",
                    "previous": "Anterior",
                    "first": "Primeiro",
                    "last": "Último"
                },
                "aria": {
                    "sortAscending": ": Ordenar colunas de forma ascendente",
                    "sortDescending": ": Ordenar colunas de forma descendente"
                },
                "select": {
                    "rows": {
                        "_": "Selecionado %d linhas",
                        "1": "Selecionado 1 linha"
                    },
                    "cells": {
                        "1": "1 célula selecionada",
                        "_": "%d células selecionadas"
                    },
                    "columns": {
                        "1": "1 coluna selecionada",
                        "_": "%d colunas selecionadas"
                    }
                },
                "buttons": {
                    "copySuccess": {
                        "1": "Uma linha copiada com sucesso",
                        "_": "%d linhas copiadas com sucesso"
                    },
                    "collection": "Coleção  <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                    "colvis": "Visibilidade da Coluna",
                    "colvisRestore": "Restaurar Visibilidade",
                    "copy": "Copiar",
                    "copyKeys": "Pressione ctrl ou u2318 + C para copiar os dados da tabela para a área de transferência do sistema. Para cancelar, clique nesta mensagem ou pressione Esc..",
                    "copyTitle": "Copiar para a Área de Transferência",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pageLength": {
                        "-1": "Mostrar todos os registros",
                        "_": "Mostrar %d registros"
                    },
                    "pdf": "PDF",
                    "print": "Imprimir"
                },
                "autoFill": {
                    "cancel": "Cancelar",
                    "fill": "Preencher todas as células com",
                    "fillHorizontal": "Preencher células horizontalmente",
                    "fillVertical": "Preencher células verticalmente"
                },
                "lengthMenu": "Exibir _MENU_ resultados por página",
                "searchBuilder": {
                    "add": "Adicionar Condição",
                    "button": {
                        "0": "Construtor de Pesquisa",
                        "_": "Construtor de Pesquisa (%d)"
                    },
                    "clearAll": "Limpar Tudo",
                    "condition": "Condição",
                    "conditions": {
                        "date": {
                            "after": "Depois",
                            "before": "Antes",
                            "between": "Entre",
                            "empty": "Vazio",
                            "equals": "Igual",
                            "not": "Não",
                            "notBetween": "Não Entre",
                            "notEmpty": "Não Vazio"
                        },
                        "number": {
                            "between": "Entre",
                            "empty": "Vazio",
                            "equals": "Igual",
                            "gt": "Maior Que",
                            "gte": "Maior ou Igual a",
                            "lt": "Menor Que",
                            "lte": "Menor ou Igual a",
                            "not": "Não",
                            "notBetween": "Não Entre",
                            "notEmpty": "Não Vazio"
                        },
                        "string": {
                            "contains": "Contém",
                            "empty": "Vazio",
                            "endsWith": "Termina Com",
                            "equals": "Igual",
                            "not": "Não",
                            "notEmpty": "Não Vazio",
                            "startsWith": "Começa Com"
                        },
                        "array": {
                            "contains": "Contém",
                            "empty": "Vazio",
                            "equals": "Igual à",
                            "not": "Não",
                            "notEmpty": "Não vazio",
                            "without": "Não possui"
                        }
                    },
                    "data": "Data",
                    "deleteTitle": "Excluir regra de filtragem",
                    "logicAnd": "E",
                    "logicOr": "Ou",
                    "title": {
                        "0": "Construtor de Pesquisa",
                        "_": "Construtor de Pesquisa (%d)"
                    },
                    "value": "Valor",
                    "leftTitle": "Critérios Externos",
                    "rightTitle": "Critérios Internos"
                },
                "searchPanes": {
                    "clearMessage": "Limpar Tudo",
                    "collapse": {
                        "0": "Painéis de Pesquisa",
                        "_": "Painéis de Pesquisa (%d)"
                    },
                    "count": "{total}",
                    "countFiltered": "{shown} ({total})",
                    "emptyPanes": "Nenhum Painel de Pesquisa",
                    "loadMessage": "Carregando Painéis de Pesquisa...",
                    "title": "Filtros Ativos"
                },
                "thousands": ".",
                "datetime": {
                    "previous": "Anterior",
                    "next": "Próximo",
                    "hours": "Hora",
                    "minutes": "Minuto",
                    "seconds": "Segundo",
                    "amPm": [
                        "am",
                        "pm"
                    ],
                    "unknown": "-",
                    "months": {
                        "0": "Janeiro",
                        "1": "Fevereiro",
                        "10": "Novembro",
                        "11": "Dezembro",
                        "2": "Março",
                        "3": "Abril",
                        "4": "Maio",
                        "5": "Junho",
                        "6": "Julho",
                        "7": "Agosto",
                        "8": "Setembro",
                        "9": "Outubro"
                    },
                    "weekdays": [
                        "Domingo",
                        "Segunda-feira",
                        "Terça-feira",
                        "Quarta-feira",
                        "Quinte-feira",
                        "Sexta-feira",
                        "Sábado"
                    ]
                },
                "editor": {
                    "close": "Fechar",
                    "create": {
                        "button": "Novo",
                        "submit": "Criar",
                        "title": "Criar novo registro"
                    },
                    "edit": {
                        "button": "Editar",
                        "submit": "Atualizar",
                        "title": "Editar registro"
                    },
                    "error": {
                        "system": "Ocorreu um erro no sistema (<a target=\"\\\" rel=\"nofollow\" href=\"\\\">Mais informações<\/a>)."
                    },
                    "multi": {
                        "noMulti": "Essa entrada pode ser editada individualmente, mas não como parte do grupo",
                        "restore": "Desfazer alterações",
                        "title": "Multiplos valores",
                        "info": "Os itens selecionados contêm valores diferentes para esta entrada. Para editar e definir todos os itens para esta entrada com o mesmo valor, clique ou toque aqui, caso contrário, eles manterão seus valores individuais."
                    },
                    "remove": {
                        "button": "Remover",
                        "confirm": {
                            "_": "Tem certeza que quer deletar %d linhas?",
                            "1": "Tem certeza que quer deletar 1 linha?"
                        },
                        "submit": "Remover",
                        "title": "Remover registro"
                    }
                },
                "decimal": ","
            }
        });
    });
</script>


</body>

</html>