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
                                                <label for="id_funcionario" class="tamanho-fonte">Funcionário:</label><small> (Campo Obrigatório)</small>
                                                <select name="id_funcionario" class="form-control" required="required">                                       
                                                    <?php
                                                    echo "<option value=''><b>Selecione ...</b></option>";
                                                    include_once '../modell/Funcionario.class.php';
                                                    $fun = new Funcionario();
                                                    $matriz = $fun->listaFuncionario();

                                                    while ($dados = $matriz->fetchObject()) {
                                                        if ($dados->ativo == true && $dados->departamento != 'Escritório') {
                                                            $cod = $dados->id_funcionario;
                                                            $nome = $dados->nome;
                                                            echo "<option value=" . $cod . ">" . $nome . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>                            
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label for="id_lote" class="tamanho-fonte">Lote:</label><small> (Campo Obrigatório)</small>
                                                <select name="id_lote" class="form-control" required="required" >                                       
                                                    <?php
                                                    echo "<option>Selecione ...</option>";
                                                    include_once '../modell/Lote.class.php';
                                                    $lote = new Lote();
                                                    $matriz = $lote->listaLote();

                                                    while ($dados = $matriz->fetchObject()) {
                                                        if ($dados->status == TRUE) {
                                                            $cod = $dados->id_lote;
                                                            $n_lote = $dados->numero;
                                                            $descricao = $dados->descricao;
                                                            echo "<option value=" . $cod . ">" . $descricao . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>                            
                                            </div>

                                            <div class="form-group"> 
                                                <label for="id_produto" class="tamanho-fonte">Produto:</label><small> (Campo Obrigatório)</small>
                                                <select name="id_produto" id="id_produto" class="form-control" required="required">
                                                    <option value="">Selecione...</option>
                                                    <?php
                                                    include_once '../modell/Produto.class.php';
                                                    $fun = new Produto();
                                                    $matriz = $fun->listaProduto();

                                                    while ($dados = $matriz->fetchObject()) {
                                                        if ($dados->status == true) {
                                                            $cod = $dados->id_produto;
                                                            $nome = $dados->descricao;
                                                            echo "<option value=" . $cod . ">" . $nome . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>                            
                                            </div>
                                            <div class="form-group"> 
                                                <label for="id_operacao" class="tamanho-fonte">Função:</label><small> (Campo Obrigatório)</small>
                                                <select name="id_operacao" id="id_operacao" class="form-control" required="required">
                                                    <option value="">Selecione um produto...</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="q_peca">Numero de peças</label>
                                                <input type="number" id="q_peca" name="q_peca" class="form-control" placeholder="numero de peças" required="required"  />
                                            </div>                                            
                                            <div class="form-group">
                                                <label for="data">Data da produção:</label>
                                                <input type="date" id="data" name="data" class="form-control" required="required" />
                                            </div>
                                            
                                            <div class="form-group">
                                                <button type="submit" name="cadastrar" value="cadastrar" class="btn btn-info">Cadastrar</button>
                                                <button type="reset" name="cancelar" value="cancelar" class="btn btn-inverse">Cancelar</button>                    
                                            </div>

                                        </form>


                                        <?php
                                        include_once "../modell/DetalheLoteFuncionario.class.php";
//instancia a classe de controle
                                        $prodL = new DetalheLoteFuncionario();

                                        $id_lote = \filter_input(INPUT_POST, 'id_lote');
                                        $id_funcionario = \filter_input(INPUT_POST, 'id_funcionario');
                                        $id_produto = \filter_input(INPUT_POST, 'id_produto');
                                        $id_operacao = \filter_input(INPUT_POST, 'id_operacao');
                                        $n_peca = \filter_input(INPUT_POST, 'q_peca');
                                        $data = \filter_input(INPUT_POST, 'data');
                                        $cadastro = \filter_input(INPUT_POST, 'cadastrar');
                                        if (isset($cadastro)) {
                                            if (empty($id_lote) || empty($id_produto) || empty($n_peca)) {
                                                echo "<div class='alert alert-danger alert-dismissable'>
                                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                        Algum dos campos acima não foi preenchido corretamente.
                                                    </div>";
                                                //echo "<div class='alert alert-danger' role='alert'>Algum dos campos acima não foi preenchido corretamente.</div>";
                                            } else {
                                                //var_dump($id_lote, $id_produto, $data, $n_peca,$preco,$observacao);
                                                $status = $prodL->cadastraLoteProduto($id_lote, $id_funcionario, $id_produto, $id_operacao, $n_peca, $data);
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
                    </div>
                </div>
            </div>
        </div>
<?php require_once "./actionRodape.php"; ?>
        <script type="text/javascript">
            $(function () {
                $('#id_produto').change(function () {
                    if ($(this).val()) {
                        $('#id_operacao').hide();
                        $('.carregando').show();
                        $.getJSON('operacao.ajax.php?search=', {id_produto: $(this).val(), ajax: 'true'}, function (j) {
                            var options = '<option value="1">Selecione ...</option>';
                            for (var i = 0; i < j.length; i++) {
                                if (j[i].operacao != null) {
                                    options += '<option value="' + j[i].id_operacao + '">' + j[i].operacao + '</option>';
                                }
                            }
                            $('#id_operacao').html(options).show();
                            $('.carregando').hide();
                        });
                    } else {
                        $('#id_operacao').html('<option value="">– Selecione... –</option>');
                    }
                });
            });
        </script>
    </body>
</html>
