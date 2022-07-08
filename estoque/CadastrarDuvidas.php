<?php
include_once "Head.php"
?>
<link rel="stylesheet" href="trumbowyg/ui/trumbowyg.min.css">
<link rel="stylesheet" href="trumbowyg/plugins/emoji/ui/trumbowyg.emoji.min.css">

<?php if ($_SESSION['idLocal'] == 0) { ?>
    <!-- Container de Cadastro do Fornecedor -->
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Cadastrar Dúvidas</h4>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-center align-items-center container-fluid">
                                    <div class="col-lg-8 mb-4">
                                        <div class="card shadow mb-4">
                                            <div class="card-header py-3">
                                                <div class="card-body">
                                                    <?php
                                                    if (!empty($_SESSION['msg'])) {
                                                        echo $_SESSION['msg'];
                                                        unset($_SESSION['msg']);
                                                    } ?>
                                                    <form action="EnvioCadastrarDuvida.php" method="POST" class="form-horizontal form-label-left">
                                                        <div class="row">
                                                            <div class="col form-group">
                                                                <label for="titulo">Pergunta</label>
                                                                <input class="form-control" maxlength="255" name="titulo" required="required" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col form-group">
                                                                <label for="resposta">Resposta</label>
                                                                <textarea id="trumbowyg-editor" class="form-control" required name="resposta"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-offset-3">
                                                                <input type="button" name="cancelar" class="btn border border-secondary w-80" onclick="window.location.href='index.php'" value="Cancelar">
                                                                <input type="submit" name="enviar" class="btn btn-primary w-80" value="Salvar">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include_once "Footer.php";
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="trumbowyg/trumbowyg.min.js"></script>
        <script type="text/javascript" src="trumbowyg/langs/pt_br.min.js"></script>
        <script src="trumbowyg/plugins/emoji/trumbowyg.emoji.min.js"></script>
        <script>
            $('#trumbowyg-editor').trumbowyg({
                lang: 'pt_br',
                btns: [
                    ['undo', 'redo'], // Only supported in Blink browsers
                    ['formatting'],
                    ['strong', 'em', 'del'],
                    ['superscript', 'subscript'],
                    ['link'],
                    ['insertImage'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                    ['unorderedList', 'orderedList'],
                    ['horizontalRule'],
                    ['removeformat'],
                    ['fullscreen'],
                    ['emoji']
                ],
                autogrow: true
            });
        </script>

    <?php } else { ?>
        <script>
            window.location = "index.php";
        </script>
    <?php }
