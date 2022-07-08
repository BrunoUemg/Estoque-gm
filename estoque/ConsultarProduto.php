<?php
include_once("../dao/conexao.php");

include_once("Head.php");

$time_beg = microtime(true);


$result_consultaProduto = "SELECT P.idProduto,
P.descricaoProduto, 
P.quantidadeProduto ,
P.quantidadeMin,
P.idLocal,
L.nomeLocal 
FROM produto P, local L 
WHERE P.idLocal = L.idLocal and status = 1  ";
$resultado_consultaProduto = mysqli_query($con, $result_consultaProduto);


$result_ProdutoLimite = "SELECT idProduto,
descricaoProduto, 
quantidadeProduto,
idLocal,
quantidadeMin
FROM produto  
WHERE quantidadeProduto <= quantidadeMin and tipoEstoque = 0 and status = 1 ";
$resultado_ProdutoLimite = mysqli_query($con, $result_ProdutoLimite);




?>

<div class="container-fluid">

  <div class="container-fluid">

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <center>
          <h3 class="m-0 font-weight-bold text-dark">Produtos em baixa quantidade</h3>
        </center>
      </div>
      <div class="card-body-warning">
        <div class="table-responsive">
          <table class="table table-warning" id="baixo-produto" width="100%" cellspacing="0">
            <thead>

              <tr>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Quantidade Mínima</th>

                <th></th>

              </tr>
            </thead>

            <?php

            while ($rows_ProdutoLimite = mysqli_fetch_assoc($resultado_ProdutoLimite)) {
              $select_localusu = mysqli_query($con, "SELECT * FROM local_usuario where idUsuario = '$_SESSION[idUsuario]' and idLocal = '$rows_ProdutoLimite[idLocal]'");

              if (mysqli_num_rows($select_localusu) > 0 || $_SESSION['idLocal'] == null) {
            ?>

                <tr>
                  <td> <?php echo $rows_ProdutoLimite['descricaoProduto']; ?></td>
                  <td><?php echo $rows_ProdutoLimite['quantidadeProduto']; ?></td>
                  <td><?php echo $rows_ProdutoLimite['quantidadeMin']; ?></td>


                  <td> <?php echo "<a class='btn btn-success'  href='EntradaProduto.php?idProduto=" . $rows_ProdutoLimite['idProduto'] .  "'>" ?><i class="fas fa-cart-plus"></i><?php "</a>"; ?>
                  </td>
                </tr>

            <?php }
            }
            ?>
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
        <center>
          <h3 class="m-0 font-weight-bold text-primary">Consultar Produtos</h3>
        </center>
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

              <?php

              while ($rows_consultaProduto = mysqli_fetch_assoc($resultado_consultaProduto)) {

                $select_localusu = mysqli_query($con, "SELECT * FROM local_usuario where idUsuario = '$_SESSION[idUsuario]' and idLocal = '$rows_consultaProduto[idLocal]'");

                if (mysqli_num_rows($select_localusu) > 0 || $_SESSION['idLocal'] == null) {



              ?>

                  <tr>
                    <td><?php echo $rows_consultaProduto['descricaoProduto']; ?></td>
                    <td><?php echo $rows_consultaProduto['quantidadeProduto']; ?></td>
                    <td><?php echo $rows_consultaProduto['quantidadeMin']; ?></td>
                    <td><?php echo $rows_consultaProduto['nomeLocal']; ?></td>

                    <td>
                      <?php echo "<a class='btn btn-success' title='Adicionar Produto ' href='ConsultarProduto.php?idProduto=" . $rows_consultaProduto['idProduto'] . "' data-toggle='modal' data-target='#entradaModal" . $rows_consultaProduto['idProduto'] . "'>" ?><i class="fas fa-cart-plus"></i><?php echo "</a>"; ?>
                      <?php echo "<a class='btn btn-primary' title='Editar Produto' href='DadosProduto.php?idProduto=" . $rows_consultaProduto['idProduto'] .  "'>" ?><i class='fas fa-edit'></i><?php echo "</a>"; ?>
                      <?php
                      if ($_SESSION['idLocal'] == null) {
                        echo "<a  class='btn btn-danger' title='Desativar Produto' href='ExcluirProduto.php?idProduto=" . $rows_consultaProduto['idProduto'] . "' onclick=\"return confirm('Tem certeza que deseja desativar esse registro?');\">" ?> <i class='fas fa-arrow-down'></i><?php echo "</a>";
                                                                                                                                                                                                                                                                              } ?>
                      <?php echo "<a class='btn btn-warning' title='Adicionar Produto no Carrinho' href='ConsultarProduto.php?idProduto=" . $rows_consultaProduto['idProduto'] . "' data-toggle='modal' data-target='#carrinhoModal" . $rows_consultaProduto['idProduto'] . "'>" ?><i class='fas fa-cart-arrow-down'></i><?php echo "</a>"; ?>
                      <?php
                      if ($_SESSION['idLocal'] == null) {
                        echo "<a class='btn btn-secondary' title='Informação do produto' href='RelacaoProduto.php?idProduto=" . $rows_consultaProduto['idProduto'] .  "'>" ?><i class="fas fa-chart-bar"></i><?php echo "</a>";
                                                                                                                                                                                                          } ?>
                      <?php echo "<a class='btn btn-secondary' title='Informação do produto' href='RelatorioProdutoUnico.php?idProduto=" . $rows_consultaProduto['idProduto'] .  "'>" ?><i class="fas fa-file-pdf"></i><?php echo "</a>"; ?>
                      <?php echo "<a class='btn btn-dark' title='Transferir' href='ConsultarProduto.php?idProduto=" . $rows_consultaProduto['idProduto'] . "' data-toggle='modal' data-target='#carrinhoTransferencia" . $rows_consultaProduto['idProduto'] . "'>" ?><i class="fa-solid fa-arrow-right-arrow-left"></i><?php echo "</a>"; ?>
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

                                <input type="text" hidden name="idProduto" class="form-control" value="<?php echo $rows_consultaProduto['idProduto']; ?>">

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
                    <div class="modal fade" id="carrinhoTransferencia<?php echo $rows_consultaProduto['idProduto']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Adicionar produto na transferência</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="FinalizarTransferencia.php" method="POST">

                              <input type="text" hidden name="idProduto" class="form-control" value="<?php echo $rows_consultaProduto['idProduto']; ?>">

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
                    <div class="modal fade" id="entradaModal<?php echo $rows_consultaProduto['idProduto']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Adicionar produto ao carrinho</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="EntradaProduto.php" method="POST">

                              <input type="text" hidden name="idProduto" class="form-control" value="<?php echo $rows_consultaProduto['idProduto']; ?>">

                              <label>Descrição do Produto</label>
                              <input type="text" class="form-control" disabled value="<?php echo $rows_consultaProduto['descricaoProduto']; ?>">


                              <input type="hidden" class="form-control" name="descricao" value="<?php echo $rows_consultaProduto['descricaoProduto']; ?>">

                              <input type="hidden" class="form-control" name="quantidadeMax" value="<?php echo $rows_consultaProduto['quantidadeProduto']; ?>">

                              <input type="hidden" class="form-control" name="idLocal" value="<?php echo $rows_consultaProduto['idLocal']; ?>">
                             
                            
                              <label>Quantidade</label>

                              <input type="number" class="form-control" name="quantidadeEntrada" min="1">

                              <label for="">Valor unitário</label>
                              <input onKeyPress="return(moeda(this,'','.',event))" type="text" class="form-control" name="valor" min="1">

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
              }
              ?>
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
    $('#lista-produto').DataTable({
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

<script type="text/javascript">
  $(document).ready(function() {
    $('#baixo-produto').DataTable({
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
<script>
  function moeda(a, e, r, t) {
    let n = "",
      h = j = 0,
      u = tamanho2 = 0,
      l = ajd2 = "",
      o = window.Event ? t.which : t.keyCode;
    if (13 == o || 8 == o)
      return !0;
    if (n = String.fromCharCode(o),
      -1 == "0123456789".indexOf(n))
      return !1;
    for (u = a.value.length,
      h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
    ;
    for (l = ""; h < u; h++)
      -
      1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
    if (l += n,
      0 == (u = l.length) && (a.value = ""),
      1 == u && (a.value = "0" + r + "0" + l),
      2 == u && (a.value = "0" + r + l),
      u > 2) {
      for (ajd2 = "",
        j = 0,
        h = u - 3; h >= 0; h--)
        3 == j && (ajd2 += e,
          j = 0),
        ajd2 += l.charAt(h),
        j++;
      for (a.value = "",
        tamanho2 = ajd2.length,
        h = tamanho2 - 1; h >= 0; h--)
        a.value += ajd2.charAt(h);
      a.value += r + l.substr(u - 2, u)
    }
    return !1
  }
</script>

</body>

</html>