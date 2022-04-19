<?php
include_once("../dao/conexao.php");
include_once("Head.php");

$idUsuario = $_SESSION['idUsuario'];

$sql = "SELECT * FROM usuario WHERE idUsuario = '$idUsuario' ";
$res = $con->query($sql);
$linha = $res->fetch_assoc();

$resultado_local = mysqli_query($con, "SELECT * FROM local order by nomeLocal asc");

$data = date("Y-m-d");

if (isset($_POST['idProduto'])) {

    $idProduto = $_POST["idProduto"];
    $descricao = $_POST["descricao"];
    $quantidade = $_POST["quantidade"];
    $quantidadeMax = $_POST["quantidadeMax"];
    $idLocal = $_POST["idLocal"];


    $_SESSION['transferencia'][$idProduto]['idProduto'] = $idProduto;
    $_SESSION['transferencia'][$idProduto]['descricao'] = $descricao;
    $_SESSION['transferencia'][$idProduto]['quantidade'] = $quantidade;
    $_SESSION['transferencia'][$idProduto]['quantidadeMax'] = $quantidadeMax;
    $_SESSION['transferencia'][$idProduto]['idLocal'] = $idLocal;


    echo "<script>window.location='ConsultarProduto.php'</script>";
}


?>
<div class="container-fluid">

    <div class="container-fluid">


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <center>
                    <h3 class="m-0 font-weight-bold text-dark"> Saída de Produtos</h3>
                </center>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Ação</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_SESSION['transferencia'])) {

                                foreach ($_SESSION['transferencia'] as $lista) {
                            ?>
                                    <tr>
                                        <td> <?php echo $lista['descricao'];  ?> </td>
                                        <td> <?php echo $lista['quantidade']; ?> </td>
                                        <td>
                                            <?php echo "<a class='btn btn-danger' href='RemoveTransferencia.php?idProduto=" . $lista['idProduto'] . "' onclick=\"return confirm('Tem certeza que deseja remover esse item do carrrinho?');\">" ?> <i class='fas fa-trash-alt'></i><?php echo "</a>";  ?>
                                            <?php echo "<a class='btn btn-warning' href='FinalizarTransferencia.php?idProduto=" . $lista['idProduto'] . "' data-toggle='modal' data-target='#carrinhoModal" . $lista['idProduto'] . "'>" ?><i class='fas fa-cart-arrow-down'></i><?php echo "</a>"; ?>

                                            <!-- Modal-->
                                            <div class="modal fade" id="carrinhoModal<?php echo $lista['idProduto']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Alterar Quantidade</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="FinalizarTransferencia.php" method="POST">

                                                                <input type="text" hidden name="idProduto" class="form-control" value="<?php echo $lista['idProduto']; ?>">

                                                                <label>Descrição do Produto</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $lista['descricao']; ?>">
                                                                <input type="hidden" class="form-control" name="descricao" value="<?php echo $lista['descricao']; ?>">
                                                                <input type="hidden" class="form-control" name="quantidadeMax" value="<?php echo $lista['quantidadeMax']; ?>">
                                                                <input type="hidden" class="form-control" name="idLocal" value="<?php echo $lista['idLocal']; ?>">


                                                                <label>Quantidade</label>

                                                                <input type="number" class="form-control" name="quantidade" min="1" max="<?php echo $lista['quantidadeMax']; ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                                                            <input type="submit" class="btn btn-primary" value="Alterar">
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </td>

                                    </tr>
                            <?php  }
                            }
                            ?>

                        </tbody>
                    </table>
                    <?php if (empty($_SESSION['transferencia'])) {
                        echo "<center> Vazio !! </center>";
                    } else { ?>

                        <a class="btn btn-info" href="ConsultarProduto.php">Adicionar mais itens</a>
                        <?php echo "<a class='btn btn-primary' href='FinalizarTransferencia.php' data-toggle='modal' data-target='#FinalizarModal'>" ?>Finalizar transferência<?php echo "</a>";
                                                                                                                                                                            }

                                                                                                                                                                                ?>



                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="FinalizarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Finalizar transferência</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="EnvioTransferencia.php" method="POST" enctype="multipart/form-data">

                    <label>Justificativa</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" required="required" rows="2" name="justificativa"></textarea>


                    <label>Solicitante</label>
                    <input type="text" class="form-control" required="required" name="solicitante">


                    <label>Data</label>
                    <input type="date" class="form-control" name="data" value="<?php echo $data ?>">

                    <label for="">Destino</label>
                    <select name="idLocal_destino" id="" class="form-control">
                        <option value="">Selecione</option>
                        <?php while ($rows_local = mysqli_fetch_assoc($resultado_local)) { ?>
                            <option value="<?php echo $rows_local['idLocal'] ?>"><?php echo $rows_local['nomeLocal'] ?></option>
                        <?php } ?>
                    </select>

                    <input type="text" hidden name="idUsuario" id="" value="<?php echo $linha['idUsuario']; ?>">
                    <!-- <label for="">Comprovante transferência</label>
                    <input type="file" class="form-control" name="comprovanteTransferencia" id=""> -->

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                <input type="submit" class="btn btn-primary" value="Salvar">
                </form>

            </div>
        </div>
    </div>
</div>

<?php

include_once("Footer.php");

?>