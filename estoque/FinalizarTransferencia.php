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

    if (!empty($_FILES['comprovanteFiscal']['name'])) {
        $extensao1 = strtolower(substr($_FILES['comprovanteFiscal']['name'], -4));
        $novo_nome1 = uniqid() . $extensao1; //define o nome do arquivo
        $diretorio = "../nota_fiscal/";
        move_uploaded_file($_FILES['comprovanteFiscal']['tmp_name'], $diretorio . $novo_nome1);
        $_SESSION['transferencia'][$idProduto]['comprovanteFiscal'] = $novo_nome1;
    }

    if (isset($_POST['alterarTransferencia'])) {
        echo "<script>window.location='FinalizarTransferencia.php'</script>";
    } else {
       /* echo "<script>window.location='ConsultarProduto.php'</script>";*/
    }
}

?>

<div class="container-fluid">
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <center>
                    <h3 class="m-0 font-weight-bold text-dark">Saída de Produtos</h3>
                </center>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Valor unitário</th>
                                <th>Valor total</th>
                                <th>N° Nota</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if (isset($_SESSION['transferencia'])) {
                                foreach ($_SESSION['transferencia'] as $lista => $value) {


                                    $row_last_nf_produto = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM notafiscal where idProduto = '$value[idProduto]' order by idNotaFiscal desc limit 1"));




                                    $valorUnitario = $row_last_nf_produto['valor'];

                                    $valorTotal = $value['quantidade'] * $valorUnitario;


                                    $idProduto = $value['idProduto'];
                                    $_SESSION['transferencia'][$idProduto]['valorUnitario'] = $valorUnitario;
                                    
                                    if (in_array("$idProduto", $_SESSION['transferencia'][$lista])) {
                                        $nfAlterada = $value['comprovanteFiscal'];
                                    }
                                    $unicoId = uniqid();
                            ?>
                                    <tr>
                                        <td> <?php echo $value['descricao'];  ?> </td>
                                        <td> <?php echo $value['quantidade']; ?> </td>
                                        <td> <?php echo "R$" .  $valorUnitario; ?> </td>
                                        <td> <?php echo "R$" . $valorTotal; ?> </td>
                                        <td>
                                            <?php
                                            if ($nfAlterada) { ?>
                                                <a href="../nota_fiscal/<?php echo $nfAlterada; ?>" title="Visualizar Comprovante" target="_blank" rel="noopener noreferrer">NF alterada</a>
                                            <?php } else { ?>
                                                <a href="../nota_fiscal/<?php echo $row_last_nf_produto['comprovanteFiscal']; ?>" title="Visualizar Comprovante" target="_blank" rel="noopener noreferrer"><?php echo $row_last_nf_produto['NumeroNota'] ?></a>
                                            <?php  } ?>

                                        </td>
                                        <td>
                                            <a class='btn btn-danger' href="RemoveTransferencia.php?idProduto=<?php echo $idProduto ?>" onclick="return confirm('Tem certeza que deseja remover esse item do carrrinho?')"> <i class='fas fa-trash-alt'></i>
                                                <a class="btn btn-warning" href="#" data-toggle="modal" data-target="#carrinhoModal<?php echo $unicoId ?>"><i class='fas fa-cart-arrow-down'></i>
                                        </td>
                                    </tr>

                                    <!-- Modal-->
                                    <div class="modal fade" id="carrinhoModal<?php echo $unicoId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-dark" id="exampleModalLabel">Alterar Quantidade</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body justify-content-start align-items-start">
                                                    <form action="FinalizarTransferencia.php" method="POST" enctype="multipart/form-data">
                                                        <input type="text" hidden name="idProduto" class="form-control" value="<?php echo $idProduto; ?>">
                                                        <label class="text-dark text-left" for="descricao">Descrição do Produto</label>
                                                        <input type="text" class="form-control" disabled value="<?php echo $value['descricao']; ?>">
                                                        <input type="hidden" class="form-control" name="descricao" value="<?php echo $value['descricao']; ?>">
                                                        <input type="hidden" class="form-control" name="quantidadeMax" value="<?php echo $value['quantidadeMax']; ?>">
                                                        <input type="hidden" class="form-control" name="idLocal" value="<?php echo $value['idLocal']; ?>">
                                                        <label class="text-dark text-left" for="quantidade">Quantidade</label>
                                                        <input type="number" class="form-control" name="quantidade" min="1" value="<?php echo $value['quantidade'] ?>" max="<?php echo $value['quantidadeMax']; ?>">
                                                        <label for="">Alterar NF</label>
                                                        <input type="file" name="comprovanteFiscal" class="form-control">
                                                     
                                                        <div class="modal-footer">
                                                            <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                                                            <input type="submit" class="btn btn-primary" name="alterarTransferencia" value="Alterar">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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