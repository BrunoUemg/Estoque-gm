<?php 
include_once("../dao/conexao.php");
include_once("Head.php"); 

$idUsuario = $_SESSION['idUsuario'];

$sql = "SELECT * FROM usuario WHERE idUsuario = '$idUsuario' " ;



$res = $con-> query($sql);
$linha = $res->fetch_assoc();


$data = date ("Y-m-d");

if (isset($_POST['idProduto']))
{

	$idProduto= $_POST["idProduto"];
	$descricao= $_POST["descricao"];
	$quantidade= $_POST["quantidade"];
	$quantidadeMax= $_POST["quantidadeMax"];
	$idLocal= $_POST["idLocal"];


	$_SESSION['carrinho'][$idProduto]['idProduto']= $idProduto;
	$_SESSION['carrinho'][$idProduto]['descricao']= $descricao;
	$_SESSION['carrinho'][$idProduto]['quantidade']= $quantidade;
  $_SESSION['carrinho'][$idProduto]['quantidadeMax']= $quantidadeMax;
  $_SESSION['carrinho'][$idProduto]['idLocal']= $idLocal;



}


?>
 <div class="container-fluid">

<div class="container-fluid">


<div class="card shadow mb-4">
<div class="card-header py-3">
<center><h3 class="m-0 font-weight-bold text-dark"> Saída de Produtos</h3></center>
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
					if(isset($_SESSION['carrinho'])){
						
foreach($_SESSION['carrinho'] as $lista) {
	?>
					<tr>
						<td> <?php echo $lista['descricao'];  ?> </td>
						<td> <?php echo $lista['quantidade']; ?> </td>
						<td>
						<?php  echo "<a  class='btn btn-danger' href='Remove.php?idProduto=" .$lista['idProduto']. "' onclick=\"return confirm('Tem certeza que deseja remover esse item do carrrinho?');\">"?> <i class='fas fa-trash-alt'></i><?php echo "</a>";  ?>
						<?php echo "<a class='btn btn-warning' href='Carrinho.php?idProduto=".$lista['idProduto'] ."' data-toggle='modal' data-target='#carrinhoModal".$lista['idProduto']."'>" ?><i class='fas fa-cart-arrow-down'></i><?php echo "</a>"; ?>

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
        <form action="Carrinho.php" method="POST">

        <input type="text" hidden name="idProduto"  class="form-control" value="<?php echo $lista['idProduto'];?>">

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
    <?php if(empty($_SESSION['carrinho']) ){
        echo "<center> Vazio !! </center>"; }else{?>

			<a class="btn btn-info" href="ConsultarProduto.php">Adicionar mais itens</a>
			<?php echo "<a class='btn btn-primary' href='Carrinho.php' data-toggle='modal' data-target='#RequisicaoModal'>" ?>Finalizar carrinho<?php echo "</a>"; }
      
      ?>
 


  </div>
    </div>
  </div>
  </div>
</div>

<!-- Modal-->
<div class="modal fade" id="RequisicaoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Requisição</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="SaidaProduto.php" method="POST" enctype="multipart/form-data">

        <label>Justificativa</label>
		<textarea class="form-control"  id="exampleFormControlTextarea1" required="required" rows="2" name="justificativa"></textarea>


      <label>Solicitante</label>
	  <input type="text" class="form-control" required="required" name="solicitante">


      <label>Data</label>
	  <input type="date" class="form-control" name="data" value="<?php echo $data ?>">

    <input type="text" hidden name="idUsuario" id="" value="<?php echo $linha['idUsuario']; ?>">
    <label for="">Comprovante requisição</label>
    <input type="file" required="required" class="form-control" name="comprovanteRequisicao" id="">

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