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
    $sel = mysqli_query($con, "SELECT count(*) as allcount FROM produto P, local L WHERE P.idLocal = L.idLocal and status = 0");
    $records = mysqli_fetch_assoc($sel);

    ## Total number of record with filtering
    $sel = mysqli_query($con, "SELECT count(*) as allcount FROM produto P, local L WHERE P.idLocal = L.idLocal and status = 0 and 1 " . $searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "SELECT P.idProduto,P.descricaoProduto, P.quantidadeProduto ,P.quantidadeMin,P.idLocal, L.nomeLocal FROM produto P, local L WHERE P.idLocal = L.idLocal and status = 0 and  1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

    $totalRecords = $records['allcount'];
} else {
    $sel = mysqli_query($con, "SELECT count(*) as allcount FROM produto P, local L, local_usuario LU WHERE P.idLocal = L.idLocal and status = 0 and LU.idUsuario = '$_SESSION[idUsuario]' and LU.idLocal = L.idLocal");
    $records = mysqli_fetch_assoc($sel);

    ## Total number of record with filtering
    $sel = mysqli_query($con, "SELECT count(*) as allcount FROM produto P, local L, local_usuario LU WHERE LU.idUsuario = '$_SESSION[idUsuario]' and LU.idLocal = L.idLocal AND P.idLocal = L.idLocal and status = 0 and 1 " . $searchQuery);
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

        $acoes = '
    <script src="../js/mascaras.js"></script>
    <a class="btn btn-success" title="Ativar Produto" href="AtivarProduto.php?idProduto=' . $rows_consultaProduto["idProduto"] . '"><i class="fa-solid fa-arrow-up" style="color: #ffffff;"></i></a>
       
       
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
?>