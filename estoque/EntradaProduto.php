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
	$quantidadeEntrada = $_POST["quantidadeEntrada"];
	$valor = $_POST["valor"];
	$idFornecedor= $_POST["idFornecedor"];
	$descricao= $_POST["descricao"];


	$_SESSION['carrinho2'][$idProduto]['idProduto']= $idProduto;
	$_SESSION['carrinho2'][$idProduto]['descricao']= $descricao;
	$_SESSION['carrinho2'][$idProduto]['quantidadeEntrada']= $quantidadeEntrada;
	$_SESSION['carrinho2'][$idProduto]['valor']= $valor;
  $_SESSION['carrinho2'][$idProduto]['idFornecedor']= $idFornecedor;



}


?>
 <div class="container-fluid">

<div class="container-fluid">


<div class="card shadow mb-4">
<div class="card-header py-3">
<center><h3 class="m-0 font-weight-bold text-dark"> Entrada de Produtos</h3></center>
</div>
<div class="card-body">
    <div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Produto</th>
						<th>Quantidade entrada</th>
						<th>Ação</th>

					</tr>				
				</thead>
				<tbody>
				<?php
					if(isset($_SESSION['carrinho2'])){
						
foreach($_SESSION['carrinho2'] as $lista) {
	?>
					<tr>
						<td> <?php echo $lista['descricao'];  ?> </td>
						<td> <?php echo $lista['quantidadeEntrada']; ?> </td>
						<td>
						<?php  echo "<a  class='btn btn-danger' href='Remove_entrada.php?idProduto=" .$lista['idProduto']. "' onclick=\"return confirm('Tem certeza que deseja remover esse item do carrrinho?');\">"?> <i class='fas fa-trash-alt'></i><?php echo "</a>";  ?>
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
        <form action="EntradaProduto.php" method="POST">

        <input type="text" hidden name="idProduto"  class="form-control" value="<?php echo $lista['idProduto'];?>">

        <label>Descrição do Produto</label>
        <input type="text" class="form-control" disabled value="<?php echo $lista['descricao']; ?>">
		<input type="hidden" class="form-control" name="descricao" value="<?php echo $lista['descricao']; ?>">
		<input type="hidden" class="form-control" name="valor" value="<?php echo $lista['valor']; ?>">
		<input type="hidden" class="form-control" name="idFornecedor" value="<?php echo $lista['idFornecedor']; ?>">


      <label>Quantidade</label>

        <input type="number" class="form-control" name="quantidadeEntrada" min="1" >
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
    <?php if(empty($_SESSION['carrinho2']) ){
        echo "<center> Vazio !! </center>"; }else{?>

			<a class="btn btn-info" href="ConsultarProduto.php">Adicionar mais itens</a>
			<?php echo "<a class='btn btn-primary' href='Carrinho.php' data-toggle='modal' data-target='#finalizarModal'>" ?>Finalizar carrinho<?php echo "</a>"; }
      
      ?>
 


  </div>
    </div>
  </div>
  </div>
</div>

<!-- Modal-->
<div class="modal fade" id="finalizarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Requisição</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="EnvioEntradaProduto.php" method="POST" enctype="multipart/form-data">

       


      <label>Número nota fiscal</label>
	  <input type="text" class="form-control" required="required" name="numeroNota">


     

   
    <label for="">Comprovante fiscal</label>
    <input type="file" required="required" class="form-control" name="comprovanteFiscal" id="">

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