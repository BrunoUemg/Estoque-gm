<?php
include_once("../dao/conexao.php");

include_once("Head.php");

// Filtro por datas
if (isset($_POST['dataInicio'])) {
  $dataInicio = $_POST['dataInicio'];
  $dataFinal = $_POST['dataFinal'];



  //Adm
  $idLocal = $_POST['idLocal'];

  $result_FiscalPeriodo = "SELECT N.numeroNota, N.quantidade, N.dataEntrada, P.descricaoProduto, L.nomeLocal, L.idLocal 
    FROM notafiscal N INNER JOIN produto P ON N.idProduto = P.idProduto INNER JOIN local L ON L.idLocal = P.idLocal
    INNER JOIN cidade C ON C.idCidade = L.idCidade
    where N.dataEntrada >= '$dataInicio' and N.dataEntrada <= '$dataFinal' and P.idLocal = '$idLocal'  ";
  $resultado_Fiscal = mysqli_query($con, $result_FiscalPeriodo);
}




$result_consultaProduto = "SELECT N.idNotaFiscal,
N.numeroNota, 
N.quantidade,
N.dataEntrada,
P.descricaoProduto,
L.nomeLocal, 
L.idLocal
FROM produto P, local L, notafiscal N  
WHERE P.idLocal = L.idLocal  and N.idProduto = P.idProduto ";
$resultado_consultaProduto = mysqli_query($con, $result_consultaProduto);
$result_local = "SELECT * FROM local";
$resultado_local = mysqli_query($con, $result_local);
?>

<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <center>
          <h3 class="m-0 font-weight-bold text-primary">Relatório de Nota Fiscal</h3>
        </center>
        <form action="" method="POST" onsubmit="return(verifica())" class="form-horizontal form-label-left">
          <?php
          $data_incioInp = mktime(0, 0, 0, date('m'), 1, date('Y'));

          $data_incioInpF = date('Y-m-d', $data_incioInp);

          ?>
          <div class="item form-group">
            <h5>Filtro por período </h5>
            <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Data início
            </label>
            <div class="col-md-10 col-sm-6 col-xs-12">
              <input type="date" class="form-control col-md-3 col-xs-8" required="required" value="<?php echo $data_incioInpF ?>" name="dataInicio">
              <br>
            </div>
            <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Data final
            </label>
            <div class="col-md-10 col-sm-6 col-xs-12">
              <input type="date" class="form-control col-md-3 col-xs-8" required="required" value="<?php echo date('Y-m-d'); ?>" name="dataFinal">
              <br>
            </div>

            <label class="control-label col-md-6 col-sm-3 col-xs-12" for="nome">Local
            </label>

            <div class="col-md-10 col-sm-6 col-xs-12">
              <select name="idLocal" id="" class="form-control col-md-3 col-xs-8">
                <option value="">Selecione</option>
                <?php while ($rows_local = mysqli_fetch_assoc($resultado_local)) {

                  $select_localusu = mysqli_query($con, "SELECT * FROM local_usuario where idUsuario = '$_SESSION[idUsuario]' and idLocal = '$rows_local[idLocal]'");

                  if (mysqli_num_rows($select_localusu) > 0 || $_SESSION['idLocal'] == null) {
                ?>

                    <option value="<?php echo $rows_local['idLocal']; ?>"><?php echo ($rows_local['nomeLocal']); ?></option>

                <?php }
                } ?>
              </select>
              <br>
            </div>

            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">

                <input type="submit" name="enviar" class="btn btn-success" value="Consultar">
              </div>
            </div>
        </form>
      </div>
      <?php if (!isset($_POST['dataInicio'])) { ?>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="lista-produto" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Número</th>
                  <th>Quantidade Entrada</th>

                  <th>Produto</th>
                  <th>Data Entrada</th>
                </tr>
              </thead>

              <tbody>

                <?php

                while ($rows_consultaProduto = mysqli_fetch_assoc($resultado_consultaProduto)) {

                  $select_localusu = mysqli_query($con, "SELECT * FROM local_usuario where idUsuario = '$_SESSION[idUsuario]' and idLocal = '$rows_consultaProduto[idLocal]'");

                  if (mysqli_num_rows($select_localusu) > 0 || $_SESSION['idLocal'] == null) {
                ?>

                    <tr>
                      <td><?php echo $rows_consultaProduto['numeroNota']; ?></td>
                      <td><?php echo $rows_consultaProduto['quantidade']; ?></td>

                      <td><?php echo $rows_consultaProduto['descricaoProduto']; ?></td>
                      <td><?php $dataBanco = $rows_consultaProduto['dataEntrada'];
                          $dataBr = date("d/m/Y", strtotime($dataBanco));
                          echo $dataBr; ?></td>

                    </tr>
              <?php }
                }
              }   ?>
              </tbody>
            </table>
          </div>
        </div>
    </div>

  </div>

  <?php if (isset($_POST['dataInicio'])) { ?>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="lista-produto" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Número</th>
              <th>Quantidade Entrada</th>
              <th>Cidade</th>
              <th>Produto</th>
              <th>Local</th>
              <th>Data Entrada</th>
            </tr>
          </thead>

          <tbody>

            <?php


            while ($rows_consultaProduto = mysqli_fetch_assoc($resultado_Fiscal)) {
              $select_localusu = mysqli_query($con, "SELECT * FROM local_usuario where idUsuario = '$_SESSION[idUsuario]' and idLocal = '$rows_consultaProduto[idLocal]'");

              if (mysqli_num_rows($select_localusu) > 0 || $_SESSION['idLocal'] == null) {
            ?>

                <tr>
                  <td><?php echo $rows_consultaProduto['numeroNota']; ?></td>
                  <td><?php echo $rows_consultaProduto['quantidade']; ?></td>
                  <td><?php echo $rows_consultaProduto['nomeCidade']; ?></td>
                  <td><?php echo $rows_consultaProduto['descricaoProduto']; ?></td>
                  <td><?php echo $rows_consultaProduto['nomeLocal']; ?></td>
                  <td><?php $dataBanco = $rows_consultaProduto['dataEntrada'];
                      $dataBr = date("d/m/Y", strtotime($dataBanco));
                      echo $dataBr; ?></td>

                </tr>
          <?php }
            }
          }   ?>
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