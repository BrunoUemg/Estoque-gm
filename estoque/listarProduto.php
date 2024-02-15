<?php

include_once "../dao/conexao.php";
session_start();
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if ($searchValue != '') {
    $searchQuery = "and (descricaoProduto like '%" . $searchValue . "%' or 
    nomeLocal like '%" . $searchValue . "%' or 
    quantidadeMin like '%" . $searchValue . "%' or 
    quantidadeProduto like'%" . $searchValue . "%' ) ";
    // $searchQuery = "SELECT P.idProduto,P.descricaoProduto, P.quantidadeProduto ,P.quantidadeMin,P.idLocal, L.nomeLocal FROM produto P, local L WHERE P.idLocal = L.idLocal and status = 1 like '%" . $searchValue . "%'";
}
// select count(*) as allcount from employee
## Total number of records without filtering

if ($_SESSION['idLocal'] == null) {
    $sel = mysqli_query($con, "SELECT count(*) as allcount FROM produto P, local L WHERE P.idLocal = L.idLocal and status = 1");
    $records = mysqli_fetch_assoc($sel);

    ## Total number of record with filtering
    $sel = mysqli_query($con, "SELECT count(*) as allcount FROM produto P, local L WHERE P.idLocal = L.idLocal and status = 1 and 1 " . $searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "SELECT P.idProduto,P.descricaoProduto, P.quantidadeProduto ,P.quantidadeMin,P.idLocal, L.nomeLocal FROM produto P, local L WHERE P.idLocal = L.idLocal and status = 1 and  1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

    $totalRecords = $records['allcount'];
} else {
    $sel = mysqli_query($con, "SELECT count(*) as allcount FROM produto P, local L, local_usuario LU WHERE P.idLocal = L.idLocal and status = 1 and LU.idUsuario = '$_SESSION[idUsuario]' and LU.idLocal = L.idLocal");
    $records = mysqli_fetch_assoc($sel);

    ## Total number of record with filtering
    $sel = mysqli_query($con, "SELECT count(*) as allcount FROM produto P, local L, local_usuario LU WHERE LU.idUsuario = '$_SESSION[idUsuario]' and LU.idLocal = L.idLocal AND P.idLocal = L.idLocal and status = 1 and 1 " . $searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "SELECT P.idProduto,P.descricaoProduto, P.quantidadeProduto ,P.quantidadeMin,P.idLocal, L.nomeLocal FROM produto P, local L, local_usuario LU WHERE LU.idUsuario = '$_SESSION[idUsuario]' and LU.idLocal = L.idLocal and P.idLocal = L.idLocal and status = 1 and  1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();
}


while ($rows_consultaProduto = mysqli_fetch_assoc($empRecords)) {

    $select_localusu = mysqli_query($con, "SELECT * FROM local_usuario where idUsuario = '$_SESSION[idUsuario]' and idLocal = '$rows_consultaProduto[idLocal]'");
    if (mysqli_num_rows($select_localusu) > 0 || $_SESSION['idLocal'] == null) {

        if ($_SESSION["idLocal"] == NULL) {
            $excluir = '<a  class="btn btn-danger" title="Desativar Produto" href="ExcluirProduto.php?idProduto=' . $rows_consultaProduto["idProduto"] . '" onclick="return confirm(\'Tem certeza que deseja desativar esse registro?\')"><i class="fas fa-arrow-down"></i></a>';
            $modal = '<a class="btn btn-secondary" title="Informação do produto" href="RelacaoProduto.php?idProduto=' . $rows_consultaProduto["idProduto"] .  '"><i class="fas fa-chart-bar"></i></a>
       
        
        ';
        }
        $acoes = '
    <script src="../js/mascaras.js"></script>
    <a class="btn btn-success" title="Adicionar Produto " href="ConsultarProduto.php?idProduto=' . $rows_consultaProduto["idProduto"] . '" data-toggle="modal" data-target="#entradaModal' . $rows_consultaProduto["idProduto"] . '"><i class="fas fa-cart-plus"></i></a> 
    <a class="btn btn-primary" title="Editar Produto" href="DadosProduto.php?idProduto=' . $rows_consultaProduto["idProduto"] .  '"> <i class="fas fa-edit"></i></a>
    <a class="btn btn-warning" title="Adicionar Produto no Carrinho" href="ConsultarProduto.php?idProduto=' . $rows_consultaProduto["idProduto"] . '" data-toggle="modal" data-target="#carrinhoModal' . $rows_consultaProduto["idProduto"] . '"><i class="fas fa-cart-arrow-down"></i></a>
    ' . $excluir . '
    ' . $modal . '
    <a class="btn btn-secondary" title="Relatório do produto" href="RelatorioProdutoUnico.php?idProduto=' . $rows_consultaProduto["idProduto"] .  '"><i class="fa-solid fa-file-arrow-down"></i></a>
       <a class="btn btn-dark" title="Transferir" href="ConsultarProduto.php?idProduto=' . $rows_consultaProduto["idProduto"] . '" data-toggle="modal" data-target="#carrinhoTransferencia' . $rows_consultaProduto["idProduto"] . '"><i class="fa-solid fa-arrow-right-arrow-left"></i></a>
       
       <!-- Modal-->
        <div class="modal fade" id="carrinhoModal' . $rows_consultaProduto["idProduto"] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input type="text" hidden name="idProduto" class="form-control" value=" ' . $rows_consultaProduto["idProduto"] . ' ">
                            <label>Descrição do Produto</label>
                            <input type="text" class="form-control" disabled value=" ' . $rows_consultaProduto["descricaoProduto"] . ' ">
                            <input type="hidden" class="form-control" name="descricao" value=" ' . $rows_consultaProduto["descricaoProduto"] . ' ">
                            <input type="hidden" class="form-control" name="quantidadeMax" value=" ' . $rows_consultaProduto["quantidadeProduto"] . ' ">
                            <input type="hidden" class="form-control" name="idLocal" value=" ' . $rows_consultaProduto["idLocal"] . '">
                            <input type="hidden" class="form-control" name="nomeLocal" value=" ' . $rows_consultaProduto["nomeLocal"] . '">
                            <label>Quantidade Maxíma</label>
                            <input type="text" disabled class="form-control" name="quantidadeproduto" value=" ' . $rows_consultaProduto["quantidadeProduto"] . ' ">
                            <label>Quantidade</label>
                            <input type="number" class="form-control" name="quantidade" min="1" max="' . $rows_consultaProduto["quantidadeProduto"] . ' ">
                            <div class="modal-footer">
                            <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary" value="Adicionar">
                            </form>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    
        <div class="modal fade" id="carrinhoTransferencia' . $rows_consultaProduto["idProduto"] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input type="text" hidden name="idProduto" class="form-control" value="' . $rows_consultaProduto["idProduto"] . ' ">
                            <label>Descrição do Produto</label>
                            <input type="text" class="form-control" disabled value="' . $rows_consultaProduto["descricaoProduto"] . '">
                            <input type="hidden" class="form-control" name="descricao" value="' . $rows_consultaProduto["descricaoProduto"] . '">
                            <input type="hidden" class="form-control" name="quantidadeMax" value="' . $rows_consultaProduto["quantidadeProduto"] . '">
                            <input type="hidden" class="form-control" name="idLocal" value="' . $rows_consultaProduto["idLocal"] . '">
                            <label>Quantidade Maxíma</label>
                            <input type="text" disabled class="form-control" name="quantidadeproduto" value="' . $rows_consultaProduto["quantidadeProduto"] . '">
                            <label>Quantidade</label>
                            <input required  type="number" class="form-control" name="quantidade" min="1" max="' . $rows_consultaProduto["quantidadeProduto"] . '">
                            <div class="modal-footer">
                            <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary" value="Adicionar">
                            </form>
                            </div>
                            </div>
                    
                </div>
            </div>
        </div>
    
        <div class="modal fade" id="entradaModal' . $rows_consultaProduto["idProduto"] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar produto</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="EntradaProduto.php" method="POST">
                            <input type="text" hidden name="idProduto" class="form-control" value="' . $rows_consultaProduto["idProduto"] . ' ">
                            <label>Descrição do Produto</label>
                            <input type="text" class="form-control" disabled value="' . $rows_consultaProduto["descricaoProduto"] . ' ">
                            <input type="hidden" class="form-control" name="descricao" value="' . $rows_consultaProduto["descricaoProduto"] . ' ">
                            <input type="hidden" class="form-control" name="quantidadeMax" value="' . $rows_consultaProduto["quantidadeProduto"] . ' ">
                            <input type="hidden" class="form-control" name="idLocal" value="' . $rows_consultaProduto["idLocal"] . ' ">
                            <label>Quantidade</label>
                            <input required type="number" class="form-control" name="quantidadeEntrada" min="1">
                            <label for="">Valor unitário</label>
                            <input required  onKeyPress=return(moeda(this,"",".",event)) type="text" class="form-control" name="valor" min="1">
                            <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Adicionar">
                        </form>
                    </div>
                    </div>                    
                </div>
            </div>
        </div>
       
       
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
       
';
        $data[] = array(
            "descricaoProduto" => $rows_consultaProduto['descricaoProduto'],
            "quantidadeProduto" => $rows_consultaProduto['quantidadeProduto'],
            "quantidadeMin" => $rows_consultaProduto['quantidadeMin'],
            "nomeLocal" => $rows_consultaProduto['nomeLocal'],
            "acoes" => $acoes,
        );
    }
}


## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
