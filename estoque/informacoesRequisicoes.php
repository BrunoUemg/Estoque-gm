<?php
include_once("Head.php");

?>

<?php
include_once "../dao/conexao.php";
$idRequisicao = $_GET['idRequisicao'];

$result_consultaRequisicao = "SELECT * FROM requisicao where idRequisicao = '$idRequisicao' ";
$res = $con->query($result_consultaRequisicao);
$linha = $res->fetch_assoc();


$result_listaRequisicao = "SELECT P.descricaoProduto,L.quantidade FROM listarequisicao L
INNER JOIN produto P ON P.idProduto = L.idProduto 
INNER JOIN requisicao R ON R.idRequisicao = L.idRequisicao WHERE R.status = 0 and R.idRequisicao = '$idRequisicao' ";
$resultado_listaRequisicao = mysqli_query($con, $result_listaRequisicao);

?>

<div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Informações da Requisição</h4>
        </div>
        <div class="card-body">

            <form action="AlterarRequisicao.php" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
                <input type="hidden" readonly class="form-control col-md-7 col-xs-12" id="staticEmail" name="idRequisicao" value="<?php echo $linha['idRequisicao']; ?>">
                <div class="item form-group">
                    <input type="text" hidden name="idRequisicao" class="form-control" value="<?php echo $linha['idRequisicao']; ?>">
                    <label>Justificativa</label>
                    <input type="text" readOnly name="Justificativa" class="form-control" id="" value="<?php echo $linha['justificativa'] ?>">
                    <label for="">Solicitante</label>
                    <input type="text" readOnly name="quantidade" class="form-control" id="" value="<?php echo $linha['solicitante'] ?>">
                    <label for=""></label>
                    <h3>Produto(s) vinculado a requisição</h3>
                    <div class="row">
                        <?php while ($rows_listarequisicao = mysqli_fetch_assoc($resultado_listaRequisicao)) {
                        ?>
                            <input type="text" readOnly class="form-control col-md-7 col-xs-12" name="descricaoProduto" id="" value=" <?php echo $rows_listarequisicao['descricaoProduto']; ?>">
                            <br>
                            <input type="text" readOnly class="form-control col-md-5 col-xs-12" name="quantidade" id="" value=" <?php echo $rows_listarequisicao['quantidade']; ?>">
                            <br>
                        <?php
                        }
                        ?>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col form-group">
                            <a href="../requisicao/<?php echo $linha['comprovanteRequisicao'] ?>" class='btn btn-block btn-primary' target="_blank" rel="noopener noreferrer">Visualizar comprovante</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <input type="button" name="cancelar" class="btn btn-danger" onClick="window.location.href='SaidasPendentes.php'" value="Cancelar">
                        </div>
                    </div>
                </div>
            </form>
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

<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>





</body>

</html>