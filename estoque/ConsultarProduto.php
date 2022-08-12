<?php
include_once("../dao/conexao.php");

include_once("Head.php");




$resultado_consultaProduto = mysqli_query($con, "SELECT P.idProduto,
P.descricaoProduto, 
P.quantidadeProduto ,
P.quantidadeMin,
P.idLocal,
L.nomeLocal 
FROM produto P, local L 
WHERE P.idLocal = L.idLocal and status = 1  ");



// $result_ProdutoLimite = "SELECT idProduto,
// descricaoProduto, 
// quantidadeProduto,
// idLocal,
// quantidadeMin
// FROM produto  
// WHERE quantidadeProduto <= quantidadeMin and tipoEstoque = 0 and status = 1 ";
// $resultado_ProdutoLimite = mysqli_query($con, $result_ProdutoLimite);




?>



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
              <tr>
                <td><?php echo $rows_consultaProduto['descricaoProduto']; ?></td>
                <td><?php echo $rows_consultaProduto['quantidadeProduto']; ?></td>
                <td><?php echo $rows_consultaProduto['quantidadeMin']; ?></td>
                <td><?php echo $rows_consultaProduto['nomeLocal']; ?></td>
                
              </tr>
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
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax': {
        'url': 'listarProduto.php'
      },
      'columns': [{
          data: 'descricaoProduto'
        },
        {
          data: 'quantidadeProduto'
        },
        {
          data: 'quantidadeMin'
        },
        {
          data: 'nomeLocal'
        },
        {
          data: 'acoes'
        },
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