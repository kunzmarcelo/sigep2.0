<?php
session_start();

$url = basename($_SERVER['SCRIPT_FILENAME']);
$pagina = basename(__FILE__);
if ($url != 'index.php')
    include_once "../view/funcoes.php"; {
    include_once "../view/funcoes.php";
}
controlaAcessoUrl($url, $pagina);
//expiraSessao();
/*
 * 
 */
?>


<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Kunz, Marcelo 2014">

        <title>Bem Vindos</title>

        <!-- Bootstrap Core CSS -->
        <link href="../bootstrap/assets/css/bootstrap.css" rel="stylesheet">
        <link href="../bootstrap/assets/css/picture.css" rel="stylesheet">


        <link rel="stylesheet" type="text/css" href="../bootstrap/assets/css/default.css">
        <link rel="stylesheet" type="text/css" href="../bootstrap/assets/css/component.css">

        <script src="../bootstrap/assets/js/modernizr.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#tblEditavel tbody tr td.editavel').dblclick(function () {
                    if ($('td > input').length > 0) {
                        return;
                    }
                    var conteudoOriginal = $(this).text();
                    var novoElemento = $('<input/>', {type: 'text', value: conteudoOriginal});
                    $(this).html(novoElemento.bind('blur keydown', function (e) {
                        var keyCode = e.which;
                        var conteudoNovo = $(this).val();
                        if (keyCode == 13 && conteudoNovo != '' && conteudoNovo != conteudoOriginal) {
                            var objeto = $(this);
                            $.ajax({
                                type: "POST",
                                url: "alterarFalta.php",
                                data: {
                                    id: $(this).parents('tr').children().first().text(),
                                    campo: $(this).parent().attr('title'),
                                    valor: conteudoNovo
                                },
                                success: function (result) {
                                    objeto.parent().html(conteudoNovo)
                                    $('body').append(result);
                                    location.reload();
                                },
                            })
                        }
                        if (e.type == "blur") {
                            $(this).parent().html(conteudoOriginal);
                        }
                    }));

                    $(this).children().select();
                })
            })
        </script>

        <!-- Custom CSS -->


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <div class="container">
            <?php require_once './actionfonteMenu.php'; ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Faltas cadastradas</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-lg-12">                    
                    <div class="panel-heading">
                        <a href="../index.php" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Voltar Inicio</a>
                        <a href="cadastra_falta.php" class="btn btn-info"><span class='glyphicon glyphicon-plus'></span> Adicionar</a>
                    </div>
                    <div class="panel panel-primary">            
                        <div class="panel-heading" style="text-align: center;">
                            Faltas cadastradas
                        </div>
                        <div class="table-responsive">                    
                            <table class="table table-hover" id="tblEditavel">
                                <thead>
                                    <tr>
                                        <th><img src='../bibliotecas/img/1486591262_id.png'></th>
                                        <th>Funcionário</th>
                                        <th>Data</th>
                                        <th>Hora Ini</th>
                                        <th>Hora fim</th>
                                        <th>Motivo</th>
                                        <th>Tempo</th>
                                        <!--<th><span class="glyphicon glyphicon-info-sign" title="Visualizar lote"></span></th>-->
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    include_once "../modell/ControleFalta.class.php";
                                    $lote = new ControleFalta();
                                    $matriz = $lote->listaFalta();

                                    while ($dados = $matriz->fetchObject()) {
                                        //echo $dados->data_fabri;                                        
                                        $data1 = explode("-", $dados->data);
                                        $data = $data1[2] . '/' . $data1[1] . '/' . $data1[0];
//                                        $data2 = explode("-", $dados->data_final);
                                        //if ($dados->status == true) {

                                        $hora_ini1 = explode(":", "$dados->hora_ini");
                                        $hora_fim1 = explode(":", $dados->hora_fim);
//                                        $hora_int1 = explode(":", "02:05:00");

                                        $tempo1 = (($hora_ini1[0] * 3600) + ($hora_ini1[1] * 60) + ($hora_ini1[2]));
                                        $tempo2 = (($hora_fim1[0] * 3600) + ($hora_fim1[1] * 60) + ($hora_fim1[2]));
                                        //$tempo3 = (($hora_int1[0] * 3600) + ($hora_int1[1] * 60) + ($hora_int1[2]));


                                        $resultado_tempo = ($tempo2 - $tempo1);
//                                        $resultado_tempo = ($tempo2 - $tempo1) - $tempo3;
                                        $total_segundos = $resultado_tempo;

                                        $horas = floor($total_segundos / (60 * 60));
                                        $sobra_horas = ($total_segundos % (60 * 60));
                                        $minutos = floor($sobra_horas / 60);
                                        $sobra_minutos = ($sobra_horas % 60);
                                        $segundos = $sobra_minutos;

                                        if ($horas < 10) {
                                            $horas = "0$horas";
                                        } else {
                                            $horas = $horas;
                                        }

                                        $tempo = "$horas:$minutos:0$segundos";


                                        echo "<tr>
                                                    <td title='id_falta'>" . $dados->id_falta . "</td>
                                                    <td title='funcionário'>" . $dados->nome . "</td>
                                                    <td title='data'>" . $data . "</b></td>
                                                    <td title='hora_ini' class='editavel'>" . $dados->hora_ini . "</td>
                                                    <td title='hora_fim' class='editavel'>" . $dados->hora_fim . "</td>
                                                    <td title='motivo' class='editavel'>" . $dados->motivo . "</td>
                                                    <td title='tempo'><b>" . $tempo . "</b></td>
                                              </tr>";
                                    }//<button title='finalizar lote' type='submit' id='ativar' value='ativar'  onclick='ativar(" . $dados->id . ");' class='btn btn-default'> </button>
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--</div>-->
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12">
                            <!--<label for="legenda">*A soma das entradas é o (valor a vista + total de cartão + total de parcelas com cartão + total de parcelas).</label>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../ajax/config.js"></script>

<!--<script src="../ajax/jquery.js"></script>-->
        <script src="../bootstrap/assets/js/toucheffects.js"></script>
        <!-- For the demo ad only -->   

        <script src="../bootstrap/assets/js/bootstrap.js"></script>
    </body>
</html>
