<?php
session_start();

$url = basename($_SERVER['SCRIPT_FILENAME']);
$pagina = basename(__FILE__);
if ($url != 'index.php')
    include_once "../view/funcoes.php";
{
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

<?php include_once "./actionCabecalho.php"; ?>


    </head>
    <body>
        <div id="wrapper">
<?php require_once './actionfonteMenu.php'; ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php
                            $url = $_SERVER['REQUEST_URI'];
                            $part = explode("/", $url);
                            $part[3];

                            include_once '../modell/Produto.class.php';
                            $con = new BancoDadosPDO();
                            $titulo = $con->listarUm("menu_filho", "link like '$part[3]'");
                            $resultado = $titulo->fetchObject();
                            ?>

<?= $resultado->nome ?>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="text-align: center">
                                Fomulário de cadastro
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form method="post" role="form">
                                            <div class="form-group">
                                                <label for="numero">Número do posto:</label>
                                                <input type="numer" id="numero" name="numero" class="form-control" placeholder="Ex: Acabamento" required="required"  />
                                            </div>
                                            <div class="form-group">
                                                <label for="descricao">Descrição da posto:</label>
                                                <input type="text" id="descricao" name="descricao" class="form-control" placeholder="Ex: Acabamento" required="required"  />
                                            </div>


                                            <div class="form-group">                                   
                                                <button type="submit" name="cadastrar" value="cadastrar" class="btn btn-info">Cadastrar</button>
                                                <button type="reset" name="cancelar" value="cancelar" class="btn btn-inverse">Cancelar</button>                    

                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <?php
                                include_once "../modell/PostoTrabalho.class.php";

//instancia a classe de controle
                                $fun = new PostoTrabalho();

                                $numero = \filter_input(INPUT_POST, 'numero');
                                $descricao = \filter_input(INPUT_POST, 'descricao');
                                $status = TRUE;

                                $cadastro = \filter_input(INPUT_POST, 'cadastrar');

                                if (isset($cadastro)) {
                                    if (empty($descricao)) {
                                        echo "<div class='alert alert-danger alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            Algum dos campos acima não foi preenchido corretamente.
                                        </div>";
                                        //echo "<div class='alert alert-danger' role='alert'>Algum dos campos acima não foi preenchido corretamente.</div>";
                                    } else {
                                        $status = $fun->cadastraPosto($numero, $descricao, $status);
                                        if ($status == true) {
                                            echo "<div class='alert alert-info alert-dismissable'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                Registro inserido com sucesso.
                                            </div>";
                                        } else {
                                            echo "<div class='alert alert-danger alert-dismissable'>
                                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                    Erro ao inserir o resgistro.
                                                </div>";
                                        }
                                    }
                                }
                                ?>


                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="panel panel-default">
                    <div class="panel-heading" style="text-align: center">
                        Listagem
                    </div>                 
                    <table class="table table-hover" id="tblEditavel">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>N°</th>
                                <th>Posto</th>
                                <th><i class="fa fa-low-vision"></i></th>
                            </tr>
                        </thead>
                        <tbody>                       

                            <?php
                            include_once "../modell/PostoTrabalho.class.php";
                            $lote = new PostoTrabalho();
                            $matriz = $lote->listaPosto();
                            if (empty($matriz)) {
                                echo "<div class='alert alert-info alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            Não possui nenhum registro armazenado.
                                            </div>";
                            } else {
                                while ($dados = $matriz->fetchObject()) {
                                    if ($dados->status == true) {
                                        echo "<tr>
                                                    <td title='id'>" . $dados->id_posto . "</td>
                                                    <td title='nome' class='editavel'>" . $dados->numero . "</td>
                                                    <td title='descricao' class='editavel'>" . $dados->descricao . "</td>                                                   
                                                        <td>     
							<span class='glyphicon glyphicon-eye-open' id='desativar' value='desativar'  onclick='desativar(" . $dados->id_posto . ");'></span> 													
                                                    </td>
                                                </tr>";
                                    } else {
                                        echo "<tr>
                                                    <td title='id'>" . $dados->id_posto . "</td>
                                                    <td title='numero' class='editavel'>" . $dados->numero . "</td>
                                                    <td title='descricao' class='editavel'>" . $dados->descricao . "</td>
                                                    <td>     
							<span class='glyphicon glyphicon-eye-close' id='ativar' value='ativar'  onclick='ativar(" . $dados->id_posto . ");'></span> 													
                                                    </td>
                                                </tr>";
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                
                
            </div>
        </div>
<?php require_once "./actionRodape.php"; ?>
    </body>
</html>