<?php
include_once "Head.php";
include_once "../dao/conexao.php";

$selectPerguntas = mysqli_query($con, "SELECT * FROM duvidas");
?>

<link rel="stylesheet" href="css/accordion.css">
<script src="https://kit.fontawesome.com/2477a48321.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Dúvidas Frequentes</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div id="accordion_search_bar_container" class="my-5">
                                            <input type="search" class="form-control" id="accordion_search_bar" placeholder="Exemplo: requisições" value="" onkeyup="this.setAttribute('value', this.value);">
                                        </div>

                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                            <?php while ($rowsDuvida = mysqli_fetch_assoc($selectPerguntas)) { ?>
                                                <div class="panel" id="collapse<?php echo $rowsDuvida['idPergunta'] ?>_container">
                                                    <div class="panel-heading" role="tab" id="heading<?php echo $rowsDuvida['idDuvida'] ?>">
                                                        <h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $rowsDuvida['idPergunta'] ?>" aria-expanded="false" aria-controls="collapse<?php echo $rowsDuvida['idPergunta'] ?>"><?php echo $rowsDuvida['tituloPergunta'] ?></a></h4> <!-- CATEGORIA -->
                                                    </div>
                                                    <div id="collapse<?php echo $rowsDuvida['idPergunta'] ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $rowsDuvida['idPergunta'] ?>">
                                                        <div class="panel-body">
                                                            <p class="text-justify"><?php echo $rowsDuvida['respostaPergunta'] ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>



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
<script>
    $(document).ready(function() {


        (function() {
            var searchTerm, panelContainerId;
            // Create a new contains that is case insensitive
            jQuery.expr[':'].containsCaseInsensitive = function(n, i, m) {
                return jQuery(n).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
            };

            jQuery('#accordion_search_bar').on('change keyup paste click', function() {
                searchTerm = jQuery(this).val();
                if (searchTerm.length >= 3) {
                    jQuery('#accordion > .panel').each(function() {
                        panelContainerId = '#' + jQuery(this).attr('id');
                        jQuery(panelContainerId + ':not(:containsCaseInsensitive(' + searchTerm + '))').hide();
                        jQuery(panelContainerId + ':containsCaseInsensitive(' + searchTerm + ')').show().find(".panel-collapse").collapse("show");
                    });
                } else {
                    jQuery(".panel-group > div").show();
                    jQuery(".panel-group > div").find(".panel-collapse").collapse("hide");
                }
            });
        }());
    });
</script>

<script src="js/states.js"></script>
<script src="js/mascaras.js"></script>
<script src="js/moeda.js"></script>
<?php
include_once "Footer.php"
?>