<?php
include "../dao/conexao.php";
session_start();
if (!isset($_SESSION['estoquegm'])) {
  header('location: ../Index.html');
}
$idUsuario = $_SESSION['idUsuario'];

$sql = "SELECT * FROM usuario WHERE idUsuario = '$idUsuario' ";



$res = $con->query($sql);
$linha = $res->fetch_assoc();
$sql2 = "SELECT * FROM nivel_acesso WHERE idUsuario = '$idUsuario' ";



$res = $con->query($sql2);
$linha2 = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Controle de Estoque</title>
  <link href="../img/icone.png" rel="icon">

  <!-- Custom fonts for this template-->
  <!-- Icones-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Fontes-->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template estilo-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="MenuPrincipal.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-dolly"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Controle de Estoque</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="MenuPrincipal.php">
          <i class="fas fa-home"></i>
          <span>Página Inicial</span></a>
        <div class=" d-flex justify-content-center align-items-center col">
          <a class="fw-bold text-white nav-link" href="Duvidas.php" role="button" aria-expanded="false" aria-controls="search-nav">
            Dúvidas
            <i class="fas fa-question"></i>
          </a>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Menu
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <?php



      ?>
      <?php
      if ($_SESSION['idLocal'] != 0) { ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-box-open"></i>
            <span>Produto</span>
          </a>
          <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <?php if ($linha2['cadProduto'] == 1) { ?>
                <a class="collapse-item" href="CadastrarProduto.php">Cadastrar</a>
              <?php }
              if ($linha2['consulProduto'] == 1) { ?>
                <a class="collapse-item" href="ConsultarProduto.php">Consultar</a>
              <?php }
              if ($linha2['consulProdutoDesativado'] == 1) { ?>
                <a class="collapse-item" href="ConsultarProdutoDesativado.php">Consultar Desativado</a>
              <?php }
              if ($linha2['receberTransferencia'] == 1) { ?>
                <a class="collapse-item" href="ReceberProduto.php">Receber Transferência</a>
              <?php } ?>
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#fornecedor" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-truck-moving"></i>
            <span>Fornecedor</span>
          </a>
          <div id="fornecedor" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <?php if ($linha2['cadFornecedor'] == 1) { ?>
                <a class="collapse-item" href="CadastrarFornecedor.php">Cadastrar</a>
              <?php }
              if ($linha2['consulFornecedor'] == 1) { ?>
                <a class="collapse-item" href="ConsultarFornecedor.php">Consultar</a>
              <?php } ?>
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
            <i class="far fa-clipboard"></i>
            <span>Relatórios</span>
          </a>
          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <?php if ($linha2['relaProEstoque'] == 1) { ?>
                <a class="collapse-item" href="RelatorioProduto.php">Produtos em estoque</a>
              <?php }
              if ($linha2['relaLimite'] == 1) { ?>
                <a class="collapse-item" href="RelatorioProdutoEmBaixa.php">Produto no limite</a>
              <?php }
              if ($linha2['relaFiscal'] == 1) { ?>
                <a class="collapse-item" href="RelatorioNotaFiscal.php">Nota Fiscal</a>
              <?php }
              if ($linha2['relaRequisicao'] == 1) { ?>
                <a class="collapse-item" href="RelatorioRequisicao.php">Requisição</a>
              <?php } 
              if ($linha2['relatorioTransferencia'] == 1) { ?>
                <a class="collapse-item" href="RelatorioTransferencia.php">Transferência</a>
              <?php } ?>
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFuor" aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-file-pdf"></i>
            <span>Comprovantes</span>
          </a>
          <div id="collapseFuor" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <?php if ($linha2['compFiscal'] == 1) { ?>
                <a class="collapse-item" href="visualizarComprovanteFiscal.php">Comprovante Fiscal </a>
              <?php }
              if ($linha2['compRequi'] == 1) { ?>
                <a class="collapse-item" href="visualizarComprovanteRequisicao.php">Comprovante Requisição </a>
              <?php } ?>

            </div>
          </div>
        </li>

      <?php }
      if ($_SESSION['nomeUsuario'] != 'Financeiro' && $_SESSION['idLocal'] == 0) {
        echo  '<li class="nav-item">
<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#duvidas" aria-expanded="true" aria-controls="duvidas">
  <i class="fas fa-question"></i>
  <span>Duvidas</span>
</a>
<div id="duvidas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
  <div class="bg-white py-2 collapse-inner rounded">
    <a class="collapse-item" href="CadastrarDuvidas.php">Cadastrar</a>
    <a class="collapse-item" href="ConsultarDuvidas.php">Consultar</a>

  </div>
</div>
</li>';
        echo  '<li class="nav-item">
<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
  <i class="fas fa-map-marker-alt"></i>
  <span>Local</span>
</a>
<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
  <div class="bg-white py-2 collapse-inner rounded">
    <a class="collapse-item" href="CadastrarLocal.php">Cadastrar</a>
    <a class="collapse-item" href="ConsultarLocal.php">Consultar</a>

  </div>
</div>
</li>';


        echo  '<li class="nav-item">
<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
  <i class="fas fa-box-open"></i>
     <span>Produto</span>
</a>
<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
  <div class="bg-white py-2 collapse-inner rounded">
    <a class="collapse-item" href="CadastrarProduto.php">Cadastrar</a>
    <a class="collapse-item" href="ConsultarProduto.php">Consultar</a>
    <a class="collapse-item" href="ConsultarProdutoDesativado.php">Consultar Desativado</a>
    <a class="collapse-item" href="ReceberProduto.php">Receber Transferência</a>
    <a class="collapse-item" href="EntradasPendentes.php">Entradas Pendentes</a>
    <a class="collapse-item" href="SaidasPendentes.php">Saídas Pendentes</a>
  </div>
</div>
</li>';

        echo  '<li class="nav-item">
<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#fornecedor" aria-expanded="true" aria-controls="collapseUtilities">
<i class="fas fa-truck-moving"></i>
     <span>Fornecedor</span>
</a>
<div id="fornecedor" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
  <div class="bg-white py-2 collapse-inner rounded">
    <a class="collapse-item" href="CadastrarFornecedor.php">Cadastrar</a>
    <a class="collapse-item" href="ConsultarFornecedor.php">Consultar</a>
 
  </div>
</div>
</li>';

        echo  '<li class="nav-item">
<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
  <i class="fas fa-fw fa-user"></i>
  <span>Funcionario</span>
</a>
<div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
  <div class="bg-white py-2 collapse-inner rounded">
  <a class="collapse-item" href="CadastrarFuncionario.php">Cadastrar</a>
    <a class="collapse-item" href="ConsultarFuncionario.php">Consultar</a>
    <a class="collapse-item" href="ConsultarFuncionarioDesligado.php">Consultar desligados</a>
   
  
  </div>
</div>
</li>';


        echo  '<li class="nav-item">
<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
<i class="far fa-clipboard"></i>
  <span>Relatórios</span>
</a>
<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
  <div class="bg-white py-2 collapse-inner rounded">
    <a class="collapse-item" href="RelatorioProduto.php">Produtos em estoque </a>
    <a class="collapse-item" href="RelatorioProdutoEmBaixa.php">Produtos no limite</a>
    <a class="collapse-item" href="RelatorioNotaFiscal.php">Nota Fiscal</a>
    <a class="collapse-item" href="RelatorioRequisicao.php">Requisição</a>
    <a class="collapse-item" href="RelatorioFuncionario.php">Funcionário</a>
    <a class="collapse-item" href="RelatorioTransferencia.php">Transferência</a>

  </div>
</div>
</li>';

        echo  '<li class="nav-item">
<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFuor" aria-expanded="true" aria-controls="collapseThree">
<i class="fas fa-file-pdf"></i>
  <span>Comprovantes</span>
</a>
<div id="collapseFuor" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
  <div class="bg-white py-2 collapse-inner rounded">
    <a class="collapse-item" href="visualizarComprovanteFiscal.php">Comprovante Fiscal </a>
    <a class="collapse-item" href="visualizarComprovanteRequisicao.php">Comprovante Requisição </a>
   

  </div>
</div>
</li>';
      }


      ?>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-primary link d-md-none rounded-circle mr-3">
            <i class="fas fa-align-justify"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="FinalizarTransferencia.php">Transferência
                <i class="fa-solid fa-arrow-right-arrow-left text-gray-600"></i>
              </a>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="EntradaProduto.php">Entrada
                <i class="fas fa-dolly text-gray-600" title="Entre no Carinho"></i>
              </a>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="Carrinho.php">Saída
                <i class="fas fa-dolly text-gray-600" title="Entre no Carinho"></i>
              </a>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>


            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <span>Bem vindo(a), <?php echo $_SESSION['nomeUsuario']; ?></span>

                  <i class="fas fa-user-circle fa-2x"></i> </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#PerfilModal">
                  <i class="far fa-address-card fa-sm fa-fw mr-2 text-gray-600"></i>
                  Perfil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-600"></i>
                  Sair
                </a>
              </div>
            </li>

          </ul>

        </nav>


        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deseja sair?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">Selecione sair se você estiver pronto para encerrar sua sessão atual.
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary" href="../logout.php">Sair</a>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="PerfilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Meu Perfil</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>

              <div class="modal-body">
                <form action="AlterarPerfil.php" method="POST" onsubmit="return(verifica())">
                  <input type="hidden" name="idUsuario" value="<?php echo $linha['idUsuario']; ?>">
                  <?php if ($_SESSION['nomeUsuario'] == 'Financeiro') { ?>

                    <input type="text" class="form-control" name="nomeUsuario" hidden value="<?php echo $linha['nomeUsuario']; ?>"><?php } ?>
                  <?php if ($_SESSION['nomeUsuario'] != 'Financeiro') { ?>
                    <label>Nome usuario</label>
                    <input type="text" class="form-control" name="nomeUsuario" value="<?php echo $linha['nomeUsuario']; ?>"><?php } ?>
                  <label>Usuário</label>
                  <input type="text" class="form-control" name="user" value="<?php echo $linha['userAcesso']; ?>">
                  <label>Senha atual</label>
                  <input type="password" class="form-control col-md-8 col-xs-1" required="required" name="senhaAtual" maxlength="255">
                  <label>Nova senha</label>
                  <div id="input">

                    <input type="password" class="form-control col-md-8 col-xs-1" required="required" name="senha" maxlength="255">
                    <img src="http://i.stack.imgur.com/H9Sb2.png" height="30px">
                    <br>
                    <br>
                  </div>



                  <script>
                    var input = document.querySelector('#input input');
                    var img = document.querySelector('#input img');
                    img.addEventListener('click', function() {
                      input.type = input.type == 'text' ? 'password' : 'text';
                    });
                  </script>


                  <style>
                    #input>* {
                      float: left;
                    }

                    #input img {
                      cursor: pointer;
                    }
                  </style>

              </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Alterar">
                <a class="btn btn-secondary" href="MenuPrincipal.php">Cancelar</a>
                </form>
              </div>
            </div>
          </div>
        </div>
        <script src="https://kit.fontawesome.com/2477a48321.js" crossorigin="anonymous"></script>



        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">